{{-- =============================================
     مساعد الذكاء الاصطناعي NGU - Floating Widget
     - يحفظ المحادثة في localStorage (لا تختفي عند الرفرش)
     - حجم أكبر للوحة
     - يعرض صور المنتجات عند ذكرها
     ============================================= --}}
@auth

@php
    $isAdmin        = Auth::user()->is_admin;
    $nguProducts    = App\Models\Product::select('id','title','image_url')->get();
@endphp

{{-- ===== CSS ===== --}}
<style>
/* ---- زر التشغيل الدائري ---- */
#ngu-fab {
    position: fixed;
    bottom: 28px;
    left: 28px;
    z-index: 9999;
    width: 62px;
    height: 62px;
    border-radius: 50%;
    background: linear-gradient(135deg, #7c3aed, #ec4899);
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 20px rgba(124,58,237,0.55);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    outline: none;
}
#ngu-fab:hover { transform: scale(1.1); box-shadow: 0 6px 28px rgba(124,58,237,0.75); }
#ngu-fab i { font-size: 1.6rem; color: #fff; transition: transform 0.3s ease; }
#ngu-fab.open i { transform: rotate(20deg); }

#ngu-fab::after {
    content: '';
    position: absolute;
    top: 2px; right: 2px;
    width: 13px; height: 13px;
    border-radius: 50%;
    background: #22c55e;
    border: 2px solid #0f0c29;
    animation: ngu-pulse 2s infinite;
}
@keyframes ngu-pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50%       { transform: scale(1.3); opacity: .7; }
}

/* ---- لوحة الشات (أكبر حجماً) ---- */
#ngu-panel {
    position: fixed;
    bottom: 104px;
    left: 28px;
    z-index: 9998;
    width: 460px;          /* أوسع من السابق */
    max-height: 650px;     /* أطول من السابق */
    border-radius: 20px;
    background: rgba(10, 8, 30, 0.97);
    border: 1px solid rgba(124,58,237,0.35);
    box-shadow: 0 12px 50px rgba(0,0,0,0.6), 0 0 0 1px rgba(124,58,237,0.15);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    backdrop-filter: blur(20px);
    opacity: 0;
    transform: translateY(20px) scale(0.95);
    pointer-events: none;
    transition: opacity 0.25s ease, transform 0.25s ease;
}
#ngu-panel.open {
    opacity: 1;
    transform: translateY(0) scale(1);
    pointer-events: all;
}

/* ---- هيدر ---- */
#ngu-header {
    background: linear-gradient(135deg, #7c3aed 0%, #ec4899 100%);
    padding: 14px 18px;
    display: flex;
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
}
#ngu-avatar {
    width: 44px; height: 44px; border-radius: 50%;
    background: rgba(255,255,255,0.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; color: #fff; flex-shrink: 0;
}
#ngu-title { flex: 1; }
#ngu-title .name { font-weight: 700; font-size: 1.05rem; color: #fff; display: flex; align-items: center; gap: 6px; }
#ngu-title .sub  { font-size: .75rem; color: rgba(255,255,255,.75); margin-top: 2px; }
.ngu-admin-badge { font-size: .65rem; background: rgba(255,255,255,.2); padding: 1px 7px; border-radius: 20px; color: #fff; }

/* أزرار الهيدر */
.ngu-header-btns { display: flex; gap: 6px; }
.ngu-hbtn {
    background: rgba(255,255,255,.15); border: none; border-radius: 50%;
    width: 30px; height: 30px; cursor: pointer; color: #fff;
    display: flex; align-items: center; justify-content: center;
    transition: background .2s; font-size: .85rem;
}
.ngu-hbtn:hover { background: rgba(255,255,255,.3); }

/* ---- منطقة الرسائل ---- */
#ngu-messages {
    flex: 1; overflow-y: auto; padding: 16px;
    display: flex; flex-direction: column; gap: 12px;
    scrollbar-width: thin; scrollbar-color: rgba(124,58,237,.4) transparent;
}
#ngu-messages::-webkit-scrollbar { width: 5px; }
#ngu-messages::-webkit-scrollbar-thumb { background: rgba(124,58,237,.4); border-radius: 5px; }

/* فقاعة رسالة */
.ngu-msg { display: flex; gap: 8px; max-width: 100%; }
.ngu-msg.user  { flex-direction: row-reverse; }
.ngu-msg-avatar {
    width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: .9rem;
}
.ngu-msg.ai   .ngu-msg-avatar { background: linear-gradient(135deg,#7c3aed,#ec4899); color:#fff; }
.ngu-msg.user .ngu-msg-avatar { background: rgba(255,255,255,.08); color: rgba(255,255,255,.6); }

.ngu-bubble {
    padding: 10px 14px;
    border-radius: 14px;
    font-size: .9rem;
    line-height: 1.6;
    max-width: calc(100% - 44px);
    word-break: break-word;
    white-space: pre-wrap;
}
.ngu-msg.ai   .ngu-bubble { background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.08); color: #e2e8f0; border-radius: 4px 14px 14px 14px; }
.ngu-msg.user .ngu-bubble { background: linear-gradient(135deg,#7c3aed,#ec4899); color: #fff; border-radius: 14px 4px 14px 14px; }

/* ---- بطاقات المنتجات (صور) ---- */
.ngu-products-row {
    display: flex;
    gap: 8px;
    overflow-x: auto;
    padding: 8px 0 4px;
    scrollbar-width: thin;
    scrollbar-color: rgba(124,58,237,.3) transparent;
}
.ngu-product-card {
    flex-shrink: 0;
    width: 110px;
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(124,58,237,.3);
    border-radius: 12px;
    overflow: hidden;
    text-decoration: none;
    transition: transform .2s, border-color .2s;
}
.ngu-product-card:hover { transform: translateY(-3px); border-color: rgba(236,72,153,.5); }
.ngu-product-card img {
    width: 100%; height: 70px;
    object-fit: cover;
    display: block;
}
.ngu-product-card .ngu-pc-name {
    padding: 5px 6px;
    font-size: .72rem;
    color: #e2e8f0;
    line-height: 1.3;
    text-align: center;
}
.ngu-no-img {
    width: 100%; height: 70px;
    display: flex; align-items: center; justify-content: center;
    background: rgba(124,58,237,.1);
    font-size: 1.8rem;
}

/* بطاقة إجراء الأدمن */
.ngu-action-card {
    padding: 8px 12px; border-radius: 10px; font-size: .82rem;
    display: flex; align-items: center; gap: 7px; margin-top: 6px;
    white-space: normal;
}
.ngu-action-card.success { background: rgba(34,197,94,.12); border: 1px solid rgba(34,197,94,.3); color: #4ade80; }
.ngu-action-card.fail    { background: rgba(239,68,68,.12); border: 1px solid rgba(239,68,68,.3); color: #f87171; }

/* مؤشر الكتابة */
.ngu-typing .ngu-bubble { padding: 12px 14px; }
.ngu-dot { display: inline-block; width: 7px; height: 7px; border-radius: 50%; background: rgba(255,255,255,.4); margin: 0 2px; animation: ngu-bounce 1.2s infinite; }
.ngu-dot:nth-child(2) { animation-delay: .2s; }
.ngu-dot:nth-child(3) { animation-delay: .4s; }
@keyframes ngu-bounce { 0%,80%,100% { transform: translateY(0); } 40% { transform: translateY(-6px); } }

/* ---- قسم الإدخال ---- */
#ngu-input-area {
    padding: 12px 14px;
    border-top: 1px solid rgba(255,255,255,.08);
    display: flex; gap: 8px; align-items: flex-end; flex-shrink: 0;
}
#ngu-input {
    flex: 1;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(124,58,237,.3);
    border-radius: 12px;
    color: #fff;
    padding: 10px 14px;
    font-size: .9rem;
    resize: none;
    max-height: 90px;
    min-height: 42px;
    line-height: 1.4;
    outline: none;
    transition: border-color .2s;
    scrollbar-width: none;
    font-family: inherit;
}
#ngu-input:focus { border-color: rgba(124,58,237,.7); }
#ngu-input::placeholder { color: rgba(255,255,255,.3); }
#ngu-send {
    width: 42px; height: 42px; border-radius: 50%;
    background: linear-gradient(135deg,#7c3aed,#ec4899);
    border: none; cursor: pointer; color: #fff;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; transition: transform .2s, opacity .2s;
}
#ngu-send:hover  { transform: scale(1.08); }
#ngu-send:active { transform: scale(.95); }
#ngu-send:disabled { opacity: .4; cursor: default; transform: none; }

/* ---- زر رفع الصورة ---- */
#ngu-attach {
    width: 38px; height: 38px; border-radius: 50%;
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(124,58,237,.35);
    cursor: pointer; color: rgba(255,255,255,.7);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; transition: background .2s, color .2s;
    font-size: .95rem;
}
#ngu-attach:hover { background: rgba(124,58,237,.25); color: #fff; }

/* معاينة الصورة المرفوعة */
#ngu-img-preview {
    padding: 8px 14px 0;
    display: none;
    align-items: center;
    gap: 8px;
}
#ngu-img-preview img {
    height: 60px;
    border-radius: 8px;
    border: 1px solid rgba(124,58,237,.4);
    object-fit: cover;
}
#ngu-img-preview .ngu-remove-img {
    background: rgba(239,68,68,.15); border: 1px solid rgba(239,68,68,.3);
    color: #f87171; border-radius: 50%; width: 22px; height: 22px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: .75rem; flex-shrink: 0;
}

@media (max-width: 520px) {
    #ngu-panel { width: calc(100vw - 32px); bottom: 100px; left: 16px; max-height: 70vh; }
    #ngu-fab   { bottom: 20px; left: 16px; }
}
</style>

{{-- ===== HTML ===== --}}
<button id="ngu-fab" title="تحدث مع NGU" aria-label="فتح مساعد NGU">
    <i class="fa-solid fa-robot"></i>
</button>

<div id="ngu-panel" role="dialog" aria-label="محادثة NGU">
    {{-- هيدر --}}
    <div id="ngu-header">
        <div id="ngu-avatar"><i class="fa-solid fa-robot"></i></div>
        <div id="ngu-title">
            <div class="name">
                NGU
                @if($isAdmin)
                    <span class="ngu-admin-badge">⚙️ أدمن</span>
                @endif
            </div>
            <div class="sub">{{ $isAdmin ? 'مساعد الإدارة — صلاحيات كاملة' : 'مساعد المتجر — أنا هنا لمساعدتك' }}</div>
        </div>
        <div class="ngu-header-btns">
            {{-- زر مسح المحادثة --}}
            <button class="ngu-hbtn" id="ngu-clear" title="مسح المحادثة">
                <i class="fa-solid fa-trash-can"></i>
            </button>
            <button class="ngu-hbtn" id="ngu-close" title="إغلاق">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>

    {{-- الرسائل --}}
    <div id="ngu-messages"></div>

    {{-- الإدخال --}}
    {{-- معاينة الصورة المرفوعة --}}
    <div id="ngu-img-preview">
        <img id="ngu-preview-img" src="" alt="معاينة">
        <button class="ngu-remove-img" id="ngu-remove-img" title="إزالة الصورة">
            <i class="fa-solid fa-times"></i>
        </button>
        <span style="font-size:.75rem;color:rgba(255,255,255,.5);">ستُرفق مع رسالتك</span>
    </div>
    <div id="ngu-input-area">
        {{-- زر رفع الصورة (للأدمن فقط) --}}
        @if($isAdmin)
        <button id="ngu-attach" title="إرفاق صورة منتج">
            <i class="fa-solid fa-image"></i>
        </button>
        <input type="file" id="ngu-file-input" accept="image/*" style="display:none">
        @endif
        <textarea
            id="ngu-input"
            placeholder="{{ $isAdmin ? 'أعطِ أمراً للمتجر...' : 'ابحث عن منتج أو اسأل...' }}"
            rows="1"
        ></textarea>
        <button id="ngu-send" title="إرسال">
            <i class="fa-solid fa-paper-plane"></i>
        </button>
    </div>
</div>

{{-- ===== JavaScript ===== --}}
<script>
(function () {
    'use strict';

    // ── العناصر ──
    const fab      = document.getElementById('ngu-fab');
    const panel    = document.getElementById('ngu-panel');
    const closeBtn = document.getElementById('ngu-close');
    const clearBtn = document.getElementById('ngu-clear');
    const input    = document.getElementById('ngu-input');
    const sendBtn  = document.getElementById('ngu-send');
    const msgArea  = document.getElementById('ngu-messages');

    // ── الثوابت ──
    const isAdmin    = {{ $isAdmin ? 'true' : 'false' }};
    const csrfToken  = '{{ csrf_token() }}';
    const STORE_KEY  = 'ngu_history_{{ Auth::id() }}';
    const baseUrl    = '{{ url("/") }}'; // الرابط الأساسي للخادم

    // ── بيانات المنتجات لعرض الصور ──
    const nguProducts = @json($nguProducts);

    // ── الحالة ──
    let history       = [];
    let loading       = false;
    let pendingImgUrl = null;  // رابط الصورة المرفوعة في انتظار الإرسال

    // رسالة الترحيب الافتراضية
    const welcomeMsg = isAdmin
        ? `مرحباً بك في لوحة إدارة المتجر! 👋\nأنا **NGU**، أعرف قاعدة البيانات كاملة.\nيمكنني **إضافة، تعديل، وحذف** المنتجات بأوامرك.\n\n*مثال: "ضيف لعبة Elden Ring بسعر 59.99 وكمية 20"*`
        : `مرحباً! أنا **NGU** 🤖، مساعدك في متجر GameStore.\n🎮 البحث عن ألعاب وأجهزة\n💡 اقتراح منتجات بحسب ميزانيتك\n🔍 مقارنة المواصفات\n\n*بماذا أستطيع مساعدتك؟*`;

    // ── تهيئة: تحميل المحادثة المحفوظة أو عرض الترحيب ──
    function init() {
        const saved = loadFromStorage();
        if (saved && saved.length > 0) {
            // استعادة المحادثة
            saved.forEach(msg => {
                renderMessage(msg.role, msg.text, msg.actions || []);
            });
            history = saved.map(m => ({ role: m.role, text: m.text }));
        } else {
            // رسالة الترحيب
            renderMessage('ai', welcomeMsg, []);
        }
    }

    // ── فتح/إغلاق ──
    fab.addEventListener('click', () => togglePanel(!panel.classList.contains('open')));
    closeBtn.addEventListener('click', () => togglePanel(false));

    function togglePanel(open) {
        panel.classList.toggle('open', open);
        fab.classList.toggle('open', open);
        if (open) { setTimeout(() => input.focus(), 150); }
    }

    // ── مسح المحادثة ──
    clearBtn.addEventListener('click', () => {
        if (!confirm('هل تريد مسح المحادثة؟')) return;
        history = [];
        localStorage.removeItem(STORE_KEY);
        msgArea.innerHTML = '';
        renderMessage('ai', welcomeMsg, []);
    });

    // ── رفع الصورة (للأدمن) ──
    const attachBtn   = document.getElementById('ngu-attach');
    const fileInput   = document.getElementById('ngu-file-input');
    const imgPreview  = document.getElementById('ngu-img-preview');
    const previewImg  = document.getElementById('ngu-preview-img');
    const removeImgBtn= document.getElementById('ngu-remove-img');

    if (attachBtn) {
        attachBtn.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', async () => {
            const file = fileInput.files[0];
            if (!file) return;

            // عرض معاينة محلية فوراً
            previewImg.src = URL.createObjectURL(file);
            imgPreview.style.display = 'flex';
            attachBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
            attachBtn.disabled = true;

            // رفع الصورة للخادم
            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', csrfToken);

            try {
                const res  = await fetch('{{ route("ai.upload") }}', { method: 'POST', body: formData });
                const data = await res.json();
                if (data.success) {
                    pendingImgUrl = data.url;  // نحفظ المسار النسبي للإرسال مع الرسالة
                    previewImg.src = data.full_url; // نعرض الصورة من الخادم
                } else {
                    alert('فشل رفع الصورة');
                    clearImagePreview();
                }
            } catch(e) {
                alert('خطأ في رفع الصورة');
                clearImagePreview();
            }

            attachBtn.innerHTML = '<i class="fa-solid fa-image"></i>';
            attachBtn.disabled  = false;
            fileInput.value     = '';
        });

        if (removeImgBtn) {
            removeImgBtn.addEventListener('click', clearImagePreview);
        }
    }

    function clearImagePreview() {
        pendingImgUrl = null;
        imgPreview.style.display = 'none';
        previewImg.src = '';
    }

    // ── إرسال الرسالة ──
    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
    });
    input.addEventListener('input', () => {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 90) + 'px';
    });

    async function sendMessage() {
        const text = input.value.trim();
        if (!text && !pendingImgUrl || loading) return;

        // بناء الرسالة مع الصورة إن وجدت
        let fullMessage = text;
        let displayText = text;

        if (pendingImgUrl) {
            // عرض معاينة الصورة في فقاعة المستخدم
            const imgBubble = document.createElement('div');
            imgBubble.className = 'ngu-msg user';
            imgBubble.innerHTML = `
                <div class="ngu-msg-avatar"><i class="fa-solid fa-user"></i></div>
                <div class="ngu-bubble" style="padding:6px">
                    <img src="${previewImg.src}" style="max-width:180px;border-radius:10px;display:block">
                    ${text ? '<div style="margin-top:6px">' + text + '</div>' : ''}
                </div>`;
            msgArea.appendChild(imgBubble);
            scrollToBottom();

            // إضافة رابط الصورة للرسالة المرسلة لـ Ollama
            fullMessage = (text ? text + '\n' : '') + '[رابط الصورة: ' + pendingImgUrl + ']';
            clearImagePreview();
        } else {
            renderMessage('user', text, []);
        }

        if (fullMessage) history.push({ role: 'user', text: fullMessage });
        input.value = '';
        input.style.height = 'auto';

        const typingEl = appendTyping();
        sendBtn.disabled = true;
        loading = true;

        try {
            const res = await fetch('{{ route("ai.chat") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ message: fullMessage, history: history.slice(-10) }),
            });

            const data = await res.json();
            typingEl.remove();

            const reply   = data.reply || 'عذراً، لم أستطع الحصول على رد.';
            const actions = data.actions || [];

            renderMessage('ai', reply, actions);
            history.push({ role: 'ai', text: reply });
            saveToStorage(buildStorageData(actions));

        } catch (err) {
            typingEl.remove();
            renderMessage('ai', '❌ تعذّر الاتصال. تأكد أن أولاما يعمل (ollama serve).', []);
        }

        sendBtn.disabled = false;
        loading = false;
    }

    // ── رندر رسالة ──
    function renderMessage(role, text, actions) {
        const wrapper = document.createElement('div');
        wrapper.className = `ngu-msg ${role}`;

        const avatar = document.createElement('div');
        avatar.className = 'ngu-msg-avatar';
        avatar.innerHTML = role === 'ai'
            ? '<i class="fa-solid fa-robot"></i>'
            : '<i class="fa-solid fa-user"></i>';

        const bubble = document.createElement('div');
        bubble.className = 'ngu-bubble';
        bubble.innerHTML = formatText(text);

        // إضافة بطاقات إجراءات الأدمن
        if (actions && actions.length > 0) {
            actions.forEach(action => {
                const card = document.createElement('div');
                card.className = 'ngu-action-card ' + (action.success ? 'success' : 'fail');
                card.innerHTML = `<i class="fa-solid ${action.success ? 'fa-check-circle' : 'fa-times-circle'}"></i> ${action.message}`;
                bubble.appendChild(card);
            });
        }

        // عرض صور المنتجات المذكورة في رسائل NGU
        if (role === 'ai') {
            const matched = findProducts(text);
            if (matched.length > 0) {
                const row = document.createElement('div');
                row.className = 'ngu-products-row';
                matched.forEach(p => {
                    const link = document.createElement('a');
                    link.className = 'ngu-product-card';
                    link.href = '/products/' + p.id;
                    link.target = '_blank';

                    // بناء الرابط الصحيح للصورة
                    let imgSrc = null;
                    if (p.image_url) {
                        imgSrc = p.image_url.startsWith('http')
                            ? p.image_url
                            : baseUrl + '/' + p.image_url;
                    }

                    if (imgSrc) {
                        link.innerHTML = `
                            <img src="${imgSrc}" alt="${p.title}"
                                 style="width:100%;height:80px;object-fit:cover;display:block"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                            <div style="display:none;width:100%;height:80px;align-items:center;justify-content:center;font-size:1.8rem;background:rgba(124,58,237,.1)">🎮</div>
                            <div class="ngu-pc-name">${p.title}</div>`;
                    } else {
                        link.innerHTML = `
                            <div style="width:100%;height:80px;display:flex;align-items:center;justify-content:center;font-size:1.8rem;background:rgba(124,58,237,.1)">🎮</div>
                            <div class="ngu-pc-name">${p.title}</div>`;
                    }
                    row.appendChild(link);
                });
                bubble.appendChild(row);
            }
        }

        wrapper.appendChild(avatar);
        wrapper.appendChild(bubble);
        msgArea.appendChild(wrapper);
        scrollToBottom();
        return wrapper;
    }

    // ── إيجاد المنتجات المذكورة في النص ──
    function findProducts(text) {
        const lower = text.toLowerCase();
        return nguProducts.filter(p => lower.includes(p.title.toLowerCase()));
    }

    // ── مؤشر الكتابة ──
    function appendTyping() {
        const wrapper = document.createElement('div');
        wrapper.className = 'ngu-msg ai ngu-typing';
        wrapper.innerHTML = `
            <div class="ngu-msg-avatar"><i class="fa-solid fa-robot"></i></div>
            <div class="ngu-bubble">
                <span class="ngu-dot"></span>
                <span class="ngu-dot"></span>
                <span class="ngu-dot"></span>
            </div>`;
        msgArea.appendChild(wrapper);
        scrollToBottom();
        return wrapper;
    }

    // ── تنسيق النص ──
    function formatText(text) {
        text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        text = text.replace(/\*(.*?)\*/g, '<em>$1</em>');
        text = text.replace(/(\/products\/\d+)/g, '<a href="$1" style="color:#c084fc;text-decoration:underline;" target="_blank">$1</a>');
        text = text.replace(/\n/g, '<br>');
        return text;
    }

    function scrollToBottom() {
        msgArea.scrollTop = msgArea.scrollHeight;
    }

    // ── localStorage ──
    function saveToStorage(entries) {
        try { localStorage.setItem(STORE_KEY, JSON.stringify(entries)); } catch(e) {}
    }
    function loadFromStorage() {
        try { return JSON.parse(localStorage.getItem(STORE_KEY)) || []; } catch(e) { return []; }
    }
    function buildStorageData(lastActions) {
        // نبني بيانات الحفظ من history الحالي
        return history.map((m, i) => {
            const entry = { role: m.role, text: m.text, actions: [] };
            if (i === history.length - 1 && m.role === 'ai') entry.actions = lastActions;
            return entry;
        });
    }

    // ── تشغيل ──
    init();
})();
</script>

@endauth
