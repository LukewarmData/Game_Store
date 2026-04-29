{{-- =============================================
     مساعد الذكاء الاصطناعي NGU - Floating Widget
     يظهر فقط للمستخدمين المسجلين
     ============================================= --}}
@auth

@php
    $isAdmin = Auth::user()->is_admin;
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
#ngu-fab:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 28px rgba(124,58,237,0.75);
}
#ngu-fab i {
    font-size: 1.6rem;
    color: #fff;
    transition: transform 0.3s ease;
}
#ngu-fab.open i { transform: rotate(20deg); }

/* نبضة حية */
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

/* ---- لوحة الشات ---- */
#ngu-panel {
    position: fixed;
    bottom: 104px;
    left: 28px;
    z-index: 9998;
    width: 370px;
    max-height: 540px;
    border-radius: 20px;
    background: rgba(10, 8, 30, 0.97);
    border: 1px solid rgba(124,58,237,0.35);
    box-shadow: 0 12px 50px rgba(0,0,0,0.6), 0 0 0 1px rgba(124,58,237,0.15);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    backdrop-filter: blur(20px);

    /* حالة الإغلاق */
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
    width: 42px; height: 42px;
    border-radius: 50%;
    background: rgba(255,255,255,0.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; color: #fff;
    flex-shrink: 0;
}
#ngu-title { flex: 1; }
#ngu-title .name {
    font-weight: 700; font-size: 1rem; color: #fff;
    display: flex; align-items: center; gap: 6px;
}
#ngu-title .sub {
    font-size: .75rem; color: rgba(255,255,255,.75); margin-top: 1px;
}
.ngu-admin-badge {
    font-size: .65rem; background: rgba(255,255,255,.2);
    padding: 1px 7px; border-radius: 20px; color: #fff;
}
#ngu-close {
    background: rgba(255,255,255,.15); border: none; border-radius: 50%;
    width: 30px; height: 30px; cursor: pointer; color: #fff;
    display: flex; align-items: center; justify-content: center;
    transition: background .2s;
}
#ngu-close:hover { background: rgba(255,255,255,.3); }

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
    width: 30px; height: 30px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: .85rem;
}
.ngu-msg.ai   .ngu-msg-avatar { background: linear-gradient(135deg,#7c3aed,#ec4899); color:#fff; }
.ngu-msg.user .ngu-msg-avatar { background: rgba(255,255,255,.08); color: rgba(255,255,255,.6); }
.ngu-bubble {
    padding: 10px 14px;
    border-radius: 14px;
    font-size: .88rem;
    line-height: 1.55;
    max-width: calc(100% - 42px);
    word-break: break-word;
    white-space: pre-wrap;
}
.ngu-msg.ai   .ngu-bubble {
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.08);
    color: #e2e8f0;
    border-radius: 4px 14px 14px 14px;
}
.ngu-msg.user .ngu-bubble {
    background: linear-gradient(135deg,#7c3aed,#ec4899);
    color: #fff;
    border-radius: 14px 4px 14px 14px;
}

/* بطاقة إجراء الأدمن */
.ngu-action-card {
    padding: 8px 12px; border-radius: 10px; font-size: .8rem;
    display: flex; align-items: center; gap: 7px; margin-top: 4px;
}
.ngu-action-card.success { background: rgba(34,197,94,.12); border: 1px solid rgba(34,197,94,.3); color: #4ade80; }
.ngu-action-card.fail    { background: rgba(239,68,68,.12); border: 1px solid rgba(239,68,68,.3); color: #f87171; }

/* مؤشر الكتابة */
.ngu-typing .ngu-bubble { padding: 12px 14px; }
.ngu-dot {
    display: inline-block; width: 7px; height: 7px; border-radius: 50%;
    background: rgba(255,255,255,.4); margin: 0 2px;
    animation: ngu-bounce 1.2s infinite;
}
.ngu-dot:nth-child(2) { animation-delay: .2s; }
.ngu-dot:nth-child(3) { animation-delay: .4s; }
@keyframes ngu-bounce {
    0%,80%,100% { transform: translateY(0); }
    40%          { transform: translateY(-6px); }
}

/* ---- قسم الإدخال ---- */
#ngu-input-area {
    padding: 12px 14px;
    border-top: 1px solid rgba(255,255,255,.08);
    display: flex; gap: 8px; align-items: flex-end;
    flex-shrink: 0;
}
#ngu-input {
    flex: 1;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(124,58,237,.3);
    border-radius: 12px;
    color: #fff;
    padding: 10px 14px;
    font-size: .88rem;
    resize: none;
    max-height: 90px;
    min-height: 40px;
    line-height: 1.4;
    outline: none;
    transition: border-color .2s;
    scrollbar-width: none;
    font-family: inherit;
}
#ngu-input:focus { border-color: rgba(124,58,237,.7); }
#ngu-input::placeholder { color: rgba(255,255,255,.3); }
#ngu-send {
    width: 40px; height: 40px; border-radius: 50%;
    background: linear-gradient(135deg,#7c3aed,#ec4899);
    border: none; cursor: pointer; color: #fff;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; transition: transform .2s, opacity .2s;
}
#ngu-send:hover  { transform: scale(1.08); }
#ngu-send:active { transform: scale(.95); }
#ngu-send:disabled { opacity: .4; cursor: default; transform: none; }

/* شاشات صغيرة */
@media (max-width: 480px) {
    #ngu-panel { width: calc(100vw - 40px); bottom: 100px; left: 20px; }
    #ngu-fab   { bottom: 20px; left: 20px; }
}
</style>

{{-- ===== HTML ===== --}}

{{-- الزر الدائري العائم --}}
<button id="ngu-fab" title="تحدث مع NGU" aria-label="فتح مساعد NGU">
    <i class="fa-solid fa-robot"></i>
</button>

{{-- لوحة الشات --}}
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
            <div class="sub">
                {{ $isAdmin ? 'مساعد الإدارة — صلاحيات كاملة' : 'مساعد المتجر — أنا هنا لمساعدتك' }}
            </div>
        </div>
        <button id="ngu-close" title="إغلاق"><i class="fa-solid fa-xmark"></i></button>
    </div>

    {{-- الرسائل --}}
    <div id="ngu-messages">
        {{-- رسالة الترحيب --}}
        <div class="ngu-msg ai">
            <div class="ngu-msg-avatar"><i class="fa-solid fa-robot"></i></div>
            <div class="ngu-bubble">
                @if($isAdmin)
                    مرحباً بك في لوحة إدارة المتجر! 👋<br>
                    أنا <strong>NGU</strong>، أعرف قاعدة البيانات كاملة.<br>
                    يمكنني <strong>إضافة، تعديل، وحذف</strong> المنتجات بأوامرك.<br><br>
                    <em>مثال: "ضيف لعبة Elden Ring بسعر 59.99 وكمية 20"</em>
                @else
                    مرحباً! أنا <strong>NGU</strong> 🤖، مساعدك الذكي في متجر GameStore.<br>
                    أستطيع مساعدتك في:<br>
                    🎮 البحث عن ألعاب وأجهزة<br>
                    💡 اقتراح منتجات بحسب ميزانيتك<br>
                    🔍 مقارنة المواصفات<br><br>
                    <em>بماذا أستطيع مساعدتك؟</em>
                @endif
            </div>
        </div>
    </div>

    {{-- الإدخال --}}
    <div id="ngu-input-area">
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
    const input    = document.getElementById('ngu-input');
    const sendBtn  = document.getElementById('ngu-send');
    const msgArea  = document.getElementById('ngu-messages');

    // ── الحالة ──
    const isAdmin  = {{ $isAdmin ? 'true' : 'false' }};
    const csrfToken = '{{ csrf_token() }}';
    let history    = [];   // [{role:'user'|'ai', text:'...'}]
    let loading    = false;

    // ── فتح/إغلاق ──
    fab.addEventListener('click', () => togglePanel(!panel.classList.contains('open')));
    closeBtn.addEventListener('click', () => togglePanel(false));

    function togglePanel(open) {
        panel.classList.toggle('open', open);
        fab.classList.toggle('open', open);
        if (open) { setTimeout(() => input.focus(), 150); }
    }

    // ── إرسال الرسالة ──
    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    // تمدد مربع النص تلقائياً
    input.addEventListener('input', () => {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 90) + 'px';
    });

    async function sendMessage() {
        const text = input.value.trim();
        if (!text || loading) return;

        // عرض رسالة المستخدم
        appendMessage('user', text);
        history.push({ role: 'user', text });
        input.value = '';
        input.style.height = 'auto';

        // إظهار مؤشر الكتابة
        const typingEl = appendTyping();
        sendBtn.disabled = true;
        loading = true;

        try {
            const res = await fetch('{{ route("ai.chat") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ message: text, history }),
            });

            const data = await res.json();

            // إزالة مؤشر الكتابة
            typingEl.remove();

            // عرض رد NGU
            const reply = data.reply || 'عذراً، لم أستطع الحصول على رد.';
            appendMessage('ai', reply);
            history.push({ role: 'ai', text: reply });

            // عرض بطاقات الإجراءات للأدمن
            if (isAdmin && data.actions && data.actions.length > 0) {
                const lastMsg = msgArea.querySelector('.ngu-msg.ai:last-child .ngu-bubble');
                data.actions.forEach(action => {
                    const card = document.createElement('div');
                    card.className = 'ngu-action-card ' + (action.success ? 'success' : 'fail');
                    card.innerHTML = `<i class="fa-solid ${action.success ? 'fa-check-circle' : 'fa-times-circle'}"></i> ${action.message}`;
                    if (lastMsg) lastMsg.appendChild(card);
                });
            }

        } catch (err) {
            typingEl.remove();
            appendMessage('ai', '❌ حدث خطأ في الاتصال. تحقق من الإنترنت وحاول مرة أخرى.');
        }

        sendBtn.disabled = false;
        loading = false;
    }

    // ── دوال مساعدة ──

    function appendMessage(role, text) {
        const wrapper = document.createElement('div');
        wrapper.className = `ngu-msg ${role}`;

        const avatar = document.createElement('div');
        avatar.className = 'ngu-msg-avatar';
        avatar.innerHTML = role === 'ai'
            ? '<i class="fa-solid fa-robot"></i>'
            : '<i class="fa-solid fa-user"></i>';

        const bubble = document.createElement('div');
        bubble.className = 'ngu-bubble';

        // تحويل **نص** لـ bold وروابط المنتجات
        bubble.innerHTML = formatText(text);

        wrapper.appendChild(avatar);
        wrapper.appendChild(bubble);
        msgArea.appendChild(wrapper);
        scrollToBottom();
        return wrapper;
    }

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

    function formatText(text) {
        // تحويل **نص** لـ bold
        text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        // تحويل روابط المنتجات /products/\d+ لروابط قابلة للنقر
        text = text.replace(/(\/products\/\d+)/g, '<a href="$1" style="color:#c084fc;text-decoration:underline;" target="_blank">$1</a>');
        // تحويل السطر الجديد لـ <br>
        text = text.replace(/\n/g, '<br>');
        return text;
    }

    function scrollToBottom() {
        msgArea.scrollTop = msgArea.scrollHeight;
    }
})();
</script>

@endauth
