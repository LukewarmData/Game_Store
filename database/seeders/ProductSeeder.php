<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // أجهزة كونسول وحاسبات
            [
                'title' => 'PlayStation 5 Console',
                'description' => 'جهاز بلايستيشن 5 مع تجربة لعب بدقة 4K.',
                'price' => 499.99,
                'type' => 'console',
                'quantity' => 15,
                'source_url' => 'https://images.unsplash.com/photo-1606813907291-d86efa9b94db?q=80&w=600&auto=format&fit=crop',
            ],
            [
                'title' => 'Xbox Series X',
                'description' => 'أقوى جهاز إكس بوكس في التاريخ، مع رسوميات فائقة.',
                'price' => 489.00,
                'type' => 'console',
                'quantity' => 10,
                'source_url' => 'https://images.unsplash.com/photo-1621259182978-fbf93132e53d?q=80&w=600&auto=format&fit=crop',
            ],
            [
                'title' => 'تجميعة PC احترافية (RTX 4070)',
                'description' => 'تجميعة قوية معالج i7 وكرت شاشة RTX 4070.',
                'price' => 1450.00,
                'type' => 'pc',
                'quantity' => 5,
                'source_url' => 'https://images.unsplash.com/photo-1587831990711-23ca6441447b?q=80&w=600&auto=format&fit=crop',
            ],
            // الألعاب القديمة
            [
                'title' => 'God of War',
                'description' => 'الرحلة الملحمية لـ كريتوس في عوالم الأساطير الإسكندنافية.',
                'price' => 49.99,
                'type' => 'game',
                'quantity' => 40,
                'source_url' => 'https://steamcdn-a.akamaihd.net/steam/apps/1593500/library_600x900.jpg',
            ],
            [
                'title' => 'Red Dead Redemption 2',
                'description' => 'استكشف حياة عصابات الغرب الأمريكي في أضخم الألعاب.',
                'price' => 39.99,
                'type' => 'game',
                'quantity' => 30,
                'source_url' => 'https://steamcdn-a.akamaihd.net/steam/apps/1174180/library_600x900.jpg',
            ],
            [
                'title' => 'Elden Ring',
                'description' => 'مغامرة قاسية في عالم الأراضي الوسطى.',
                'price' => 59.99,
                'type' => 'game',
                'quantity' => 20,
                'source_url' => 'https://steamcdn-a.akamaihd.net/steam/apps/1245620/library_600x900.jpg',
            ],
            [
                'title' => 'Cyberpunk 2077',
                'description' => 'لعبة أكشن في نايت سيتي المستقبلية.',
                'price' => 45.00,
                'type' => 'game',
                'quantity' => 25,
                'source_url' => 'https://steamcdn-a.akamaihd.net/steam/apps/1091500/library_600x900.jpg',
            ],
            [
                'title' => 'Marvel\'s Spider-Man Remastered',
                'description' => 'العب بشخصية سبايدرمان وتأرجح في نيويورك.',
                'price' => 59.99,
                'type' => 'game',
                'quantity' => 18,
                'source_url' => 'https://steamcdn-a.akamaihd.net/steam/apps/1817070/library_600x900.jpg',
            ],
            // الألعاب الجديدة (سلسلة دارك سولز)
            [
                'title' => 'Dark Souls: Remastered',
                'description' => 'الجزء الأول المحسن من سلسلة دارك سولز العظيمة.',
                'price' => 19.99,
                'type' => 'game',
                'quantity' => 50,
                'source_url' => 'https://steamcdn-a.akamaihd.net/steam/apps/570940/library_600x900.jpg',
            ],
            [
                'title' => 'Dark Souls II: Scholar of the First Sin',
                'description' => 'الجزء الثاني من السلسلة بنسخته الشاملة، أصعب التحديات في انتظارك.',
                'price' => 19.99,
                'type' => 'game',
                'quantity' => 45,
                'source_url' => 'https://steamcdn-a.akamaihd.net/steam/apps/335300/library_600x900.jpg',
            ],
            [
                'title' => 'Dark Souls III',
                'description' => 'خاتمة السلسلة الأسطورية والنهاية الملحمية، قاتل زعماء لا يُنسون.',
                'price' => 59.99,
                'type' => 'game',
                'quantity' => 35,
                'source_url' => 'https://steamcdn-a.akamaihd.net/steam/apps/374320/library_600x900.jpg',
            ],
            // العاب الإندي
            [
                'title' => 'Hollow Knight',
                'description' => 'لعبة إندي عظيمة وملحمية برسومات ثنائية الأبعاد، اكتشف مملكة الحشرات المنسية.',
                'price' => 14.99,
                'type' => 'game',
                'quantity' => 100,
                'source_url' => 'https://steamcdn-a.akamaihd.net/steam/apps/367520/library_600x900.jpg',
            ],
            [
                'title' => 'Celeste',
                'description' => 'من أقوى ألعاب المنصات (Platformer). تسلق الجبل واكتشف قوة التحدي الذاتي.',
                'price' => 19.99,
                'type' => 'game',
                'quantity' => 80,
                'source_url' => 'https://steamcdn-a.akamaihd.net/steam/apps/504230/library_600x900.jpg',
            ],
            // ألعاب الشوتر
            [
                'title' => 'DOOM Eternal',
                'description' => 'مزق ودمر! اقضِ على جحافل الشياطين بأقوى ترسانة أسلحة في لعبة الشوتر الأسرع على الإطلاق.',
                'price' => 39.99,
                'type' => 'game',
                'quantity' => 60,
                'source_url' => 'https://steamcdn-a.akamaihd.net/steam/apps/782330/library_600x900.jpg',
            ],
            [
                'title' => 'Call of Duty: Modern Warfare II',
                'description' => 'أفضل لعبة إطلاق نار وتكتيك حربي، انضم للعمليات الخاصة المتعددة اللاعبين.',
                'price' => 69.99,
                'type' => 'game',
                'quantity' => 120,
                'source_url' => 'https://steamcdn-a.akamaihd.net/steam/apps/1938090/library_600x900.jpg',
            ],
            // الكونسول (الجيل السابق وممول)
            [
                'title' => 'PlayStation 4 Pro 1TB',
                'description' => 'جهاز الجيل السابق القوي مع دعم رسوميات 4K وتشكيلة ضخمة من الألعاب الحصرية الكلاسيكية.',
                'price' => 249.99,
                'type' => 'console',
                'quantity' => 20,
                'source_url' => 'https://images.unsplash.com/photo-1507457379470-08b800bebc67?q=80&w=600&auto=format&fit=crop',
            ],
            [
                'title' => 'Steam Deck OLED 512GB',
                'description' => 'العب مكتبة Steam الخاصة بك في أي مكان مع شاشة OLED المذهلة وتجربة الألعاب المحمولة المتكاملة.',
                'price' => 549.99,
                'type' => 'console',
                'quantity' => 8,
                'source_url' => 'https://images.unsplash.com/photo-1629429408209-1f9f2961b2a1?q=80&w=600&auto=format&fit=crop',
            ],
            // قطع الـ PC
            [
                'title' => 'NVIDIA GeForce RTX 4090 24GB',
                'description' => 'أقوى كرت شاشة في العالم للألعاب بدقة 4K وعمل الريندر والتصميمات المعقدة مع تتبع الأشعة.',
                'price' => 1599.99,
                'type' => 'pc',
                'quantity' => 3,
                'source_url' => 'https://images.unsplash.com/photo-1587202372634-32705e3bf49c?q=80&w=600&auto=format&fit=crop',
            ],
            [
                'title' => 'Intel Core i9-13900K',
                'description' => 'معالج أسطوري بـ 24 نواة يقدم أداءً لا يضاهى في سرعة اللعب والبرمجة والمونتاج.',
                'price' => 589.00,
                'type' => 'pc',
                'quantity' => 12,
                'source_url' => 'https://images.unsplash.com/photo-1591462002342-df2adcb3b808?q=80&w=600&auto=format&fit=crop',
            ],
            [
                'title' => 'Corsair Vengeance 32GB (2x16) DDR5',
                'description' => 'ذاكرة وصول عشوائي لسرعة فائقة تواكب أحدث المعالجات، تتضمن إضاءة مبهرة.',
                'price' => 120.00,
                'type' => 'pc',
                'quantity' => 25,
                'source_url' => 'https://images.unsplash.com/photo-1563687463846-569b922a912a?q=80&w=600&auto=format&fit=crop',
            ],
            [
                'title' => 'ASUS ROG Strix Z790 Motherboard',
                'description' => 'لوحة أم متطورة مخصصة للاعبين تدعم معالجات الجيل الرابع عشر وإمكانيات كسر السرعة والتبريد الشديد.',
                'price' => 399.99,
                'type' => 'pc',
                'quantity' => 7,
                'source_url' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=600&auto=format&fit=crop',
            ],
        ];

        // Ensure public/images directory exists
        $imgDir = public_path('images/products');
        if (!file_exists($imgDir)) {
            mkdir($imgDir, 0777, true);
        }

        // Empty products table to avoid duplicates during seeding
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\OrderItem::truncate();
        \App\Models\CartItem::truncate();
        \App\Models\Product::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        foreach ($products as $productData) {
            $sourceUrl = $productData['source_url'];
            unset($productData['source_url']);

            $slug = \Illuminate\Support\Str::slug($productData['title']);
            $filename = $slug . '.jpg';
            $localPath = $imgDir . '/' . $filename;

            // Simple cURL to download locally 
            if (!file_exists($localPath)) {
                $ch = curl_init($sourceUrl);
                $fp = fopen($localPath, 'wb');
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
                curl_exec($ch);
                curl_close($ch);
                fclose($fp);
            }

            $productData['image_url'] = '/images/products/' . $filename;
            
            \App\Models\Product::create($productData);
            
            echo "Seeded: " . $productData['title'] . "\n";
        }
    }
}
