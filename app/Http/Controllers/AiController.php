<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * كونترولر مساعد الذكاء الاصطناعي NGU
 * يدير المحادثات مع Gemini API بوضعين: مستخدم وأدمن
 */
class AiController extends Controller
{
    // مفتاح Gemini API
    private $apiKey = 'AIzaSyCF0hGgSwvlzh3KI2G1Za6Z1c9fZ1ziV_s';
    // رابط الـ API
    private $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';

    /**
     * استقبال رسالة المستخدم وإرجاع رد NGU
     */
    public function chat(Request $request)
    {
        $request->validate(['message' => 'required|string|max:2000']);

        $user   = Auth::user();
        $isAdmin = $user->is_admin;

        // جلب كل المنتجات من قاعدة البيانات لحقنها في الـ System Prompt
        $products = Product::all();
        $productsContext = $products->map(function ($p) {
            return [
                'id'          => $p->id,
                'title'       => $p->title,
                'description' => $p->description,
                'price'       => (float) $p->price,
                'type'        => $p->type,
                'quantity'    => $p->quantity,
                'image_url'   => $p->image_url,
                'link'        => url('/products/' . $p->id),
            ];
        })->toJson(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        // اختيار الـ System Prompt حسب صلاحية المستخدم
        $systemPrompt = $isAdmin
            ? $this->getAdminPrompt($productsContext)
            : $this->getUserPrompt($productsContext);

        // استقبال تاريخ المحادثة من الواجهة
        $history = $request->input('history', []);

        // استدعاء Gemini API
        $aiText = $this->callGemini($systemPrompt, $request->message, $history);

        // إذا كان الأدمن، تحليل وتنفيذ أوامر CRUD الموجودة في الرد
        $actions = [];
        if ($isAdmin) {
            [$aiText, $actions] = $this->executeAdminCommands($aiText);
        }

        return response()->json([
            'reply'   => $aiText,
            'actions' => $actions,
        ]);
    }

    /**
     * الـ System Prompt للمستخدم العادي (بحث واقتراح فقط)
     */
    private function getUserPrompt($productsContext)
    {
        return "أنت NGU، مساعد ذكاء اصطناعي ودود لمتجر الألعاب GameStore.
مهمتك الوحيدة هي مساعدة العملاء في:
- البحث عن المنتجات المناسبة لهم
- الإجابة على أسئلة المواصفات والمقارنة بين المنتجات
- اقتراح منتجات بحسب الميزانية أو النوع أو التفضيل
- شرح تفاصيل وخصائص أي منتج

قاعدة بيانات المنتجات الحالية:
{$productsContext}

تعليمات مهمة:
- أجب دائماً باللغة العربية بلهجة ودية ومحترمة
- عند اقتراح منتج اذكر: الاسم، النوع، السعر، والرابط: /products/{id}
- لا تتحدث عن أشياء خارج نطاق المتجر والألعاب
- إذا طلب المستخدم تعديل أي شيء قل: 'عذراً، هذه الصلاحية للمسؤول فقط'
- كن مختصراً ومفيداً ومرحباً";
    }

    /**
     * الـ System Prompt للأدمن (صلاحيات CRUD كاملة)
     */
    private function getAdminPrompt($productsContext)
    {
        return "أنت NGU، مساعد ذكاء اصطناعي احترافي لإدارة متجر GameStore. تعمل حصرياً مع المسؤول (Admin).

صلاحياتك الكاملة على قاعدة البيانات:
1. عرض وتحليل المنتجات والمخزون
2. إضافة منتجات جديدة (مع الصور برابط URL)
3. تحديث كمية أي منتج
4. تعديل سعر أي منتج
5. حذف منتج (بالاسم أو الرقم - تعرفه من قاعدة البيانات)

قاعدة بيانات المنتجات الحالية:
{$productsContext}

عند تنفيذ أي عملية، أضف في نهاية ردك كوداً JSON بهذا الشكل الدقيق (لا تغير الصيغة):

لإضافة منتج:
[ACTION:{\"type\":\"add_product\",\"data\":{\"title\":\"اسم المنتج\",\"description\":\"الوصف\",\"price\":0.00,\"type\":\"game\",\"quantity\":0,\"image_url\":\"رابط الصورة أو null\"}}]

لتحديث الكمية:
[ACTION:{\"type\":\"update_quantity\",\"data\":{\"id\":1,\"quantity\":50}}]

لتعديل السعر:
[ACTION:{\"type\":\"update_price\",\"data\":{\"id\":1,\"price\":29.99}}]

لحذف منتج:
[ACTION:{\"type\":\"delete_product\",\"data\":{\"id\":1}}]

تعليمات مهمة:
- أجب باللغة العربية دائماً
- للحذف بالاسم: ابحث عن الـ ID من قاعدة البيانات المعطاة واستخدمه في الأمر
- للصور: إذا أرسل المسؤول رابط صورة (http/https) في المحادثة، استخرجه واستخدمه في image_url
- أخبر المسؤول بتفاصيل كل عملية قبل وبعد تنفيذها
- نوع المنتج يجب أن يكون: game أو pc أو console فقط
- لا تسأل عن تأكيد إضافي، نفذ مباشرة ما يطلبه المسؤول";
    }

    /**
     * استدعاء Gemini API وإرجاع الرد
     */
    private function callGemini($systemPrompt, $userMessage, $history = [])
    {
        $contents = [];

        // بناء تاريخ المحادثة بالصيغة المطلوبة لـ Gemini
        foreach ($history as $msg) {
            $contents[] = [
                'role'  => $msg['role'] === 'ai' ? 'model' : 'user',
                'parts' => [['text' => $msg['text']]],
            ];
        }

        // إضافة الرسالة الحالية
        $contents[] = [
            'role'  => 'user',
            'parts' => [['text' => $userMessage]],
        ];

        $payload = [
            'system_instruction' => [
                'parts' => [['text' => $systemPrompt]],
            ],
            'contents'         => $contents,
            'generationConfig' => [
                'temperature'     => 0.7,
                'maxOutputTokens' => 1024,
            ],
        ];

        // إرسال الطلب لـ Gemini بواسطة cURL
        $ch = curl_init($this->apiUrl . '?key=' . $this->apiKey);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        // إرجاع الرد أو رسالة خطأ
        return $data['candidates'][0]['content']['parts'][0]['text']
            ?? 'عذراً، حدث خطأ في الاتصال مع NGU. حاول مرة أخرى.';
    }

    /**
     * استخراج وتنفيذ أوامر CRUD من رد النموذج (للأدمن فقط)
     */
    private function executeAdminCommands($text)
    {
        $actions = [];

        // البحث عن أي أوامر [ACTION:{...}] في نص الرد
        preg_match_all('/\[ACTION:(.*?)\]/s', $text, $matches);

        // إزالة الأوامر من النص المرئي
        $cleanText = trim(preg_replace('/\[ACTION:.*?\]/s', '', $text));

        foreach ($matches[1] as $jsonStr) {
            $cmd = json_decode($jsonStr, true);
            if (!$cmd || !isset($cmd['type'])) {
                continue;
            }
            $actions[] = $this->executeCommand($cmd);
        }

        return [$cleanText, $actions];
    }

    /**
     * تنفيذ أمر CRUD واحد على قاعدة البيانات
     */
    private function executeCommand($cmd)
    {
        switch ($cmd['type']) {
            // إضافة منتج جديد
            case 'add_product':
                $d = $cmd['data'];
                if (empty($d['title'])) {
                    return ['success' => false, 'message' => '❌ بيانات المنتج غير مكتملة'];
                }
                $product = Product::create([
                    'title'       => $d['title'],
                    'description' => $d['description'] ?? '',
                    'price'       => $d['price'] ?? 0,
                    'type'        => in_array($d['type'] ?? '', ['game', 'pc', 'console']) ? $d['type'] : 'game',
                    'quantity'    => $d['quantity'] ?? 0,
                    'image_url'   => (!empty($d['image_url']) && $d['image_url'] !== 'null') ? $d['image_url'] : null,
                ]);
                return ['success' => true, 'message' => "✅ تم إضافة المنتج: {$product->title} (ID: #{$product->id})"];

            // تحديث الكمية
            case 'update_quantity':
                $product = Product::find($cmd['data']['id']);
                if ($product) {
                    $old = $product->quantity;
                    $product->update(['quantity' => $cmd['data']['quantity']]);
                    return ['success' => true, 'message' => "✅ تم تحديث كمية [{$product->title}]: {$old} → {$cmd['data']['quantity']}"];
                }
                return ['success' => false, 'message' => '❌ المنتج غير موجود في قاعدة البيانات'];

            // تعديل السعر
            case 'update_price':
                $product = Product::find($cmd['data']['id']);
                if ($product) {
                    $old = $product->price;
                    $product->update(['price' => $cmd['data']['price']]);
                    return ['success' => true, 'message' => "✅ تم تعديل سعر [{$product->title}]: \${$old} → \${$cmd['data']['price']}"];
                }
                return ['success' => false, 'message' => '❌ المنتج غير موجود في قاعدة البيانات'];

            // حذف منتج
            case 'delete_product':
                $product = Product::find($cmd['data']['id']);
                if ($product) {
                    $title = $product->title;
                    $product->delete();
                    return ['success' => true, 'message' => "✅ تم حذف المنتج: {$title}"];
                }
                return ['success' => false, 'message' => '❌ المنتج غير موجود في قاعدة البيانات'];

            default:
                return ['success' => false, 'message' => '❌ نوع الأمر غير معروف'];
        }
    }
}
