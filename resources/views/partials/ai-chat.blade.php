{{-- =============================================
     مساعد الذكاء الاصطناعي NGU - Floating Widget (Stitch Edition)
     ============================================= --}}
@auth

@php
    $isAdmin        = Auth::user()->is_admin;
    $nguProducts    = App\Models\Product::select('id','title','image_url','price','type')->get();
@endphp

{{-- ===== CSS ===== --}}
<style>
/* ---- زر التشغيل الدائري ---- */
#ngu-fab {
    position: fixed;
    bottom: 30px;
    left: 30px;
    z-index: 9999;
    width: 65px;
    height: 65px;
    border-radius: 50%;
    background: linear-gradient(135deg, #d946ef, #7c3aed);
    border: none;
    cursor: pointer;
    box-shadow: 0 0 20px rgba(217, 70, 239, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    outline: none;
}
#ngu-fab:hover { transform: scale(1.1) rotate(5deg); box-shadow: 0 0 35px rgba(217, 70, 239, 0.6); }
#ngu-fab i { font-size: 1.8rem; color: #fff; }
#ngu-fab.open { transform: scale(0.9) rotate(-90deg); opacity: 0; pointer-events: none; }

/* ---- لوحة الشات (Stitch Glassmorphism) ---- */
#ngu-panel {
    position: fixed;
    bottom: 30px;
    left: 30px;
    z-index: 9998;
    width: 480px;
    height: 750px;
    max-height: calc(100vh - 60px);
    border-radius: 32px;
    background: rgba(15, 15, 26, 0.9);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 40px rgba(217, 70, 239, 0.1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    opacity: 0;
    transform: translateX(-30px) scale(0.9);
    pointer-events: none;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
}
#ngu-panel.open {
    opacity: 1;
    transform: translateX(0) scale(1);
    pointer-events: all;
}

/* ---- هيدر ---- */
#ngu-header {
    padding: 20px 24px;
    background: rgba(255, 255, 255, 0.03);
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    display: flex;
    align-items: center;
    gap: 16px;
    flex-shrink: 0;
}
#ngu-avatar-box {
    width: 50px; height: 50px; border-radius: 16px;
    background: linear-gradient(135deg, #d946ef, #7c3aed);
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 0 15px rgba(217, 70, 239, 0.3);
}
#ngu-avatar-box i { font-size: 1.5rem; color: #fff; }

#ngu-header-title { flex: 1; }
#ngu-header-title .name { font-weight: 800; font-size: 1.1rem; color: #fff; display: flex; align-items: center; gap: 8px; }
#ngu-header-title .status { font-size: 0.75rem; color: #22c55e; display: flex; align-items: center; gap: 4px; }
#ngu-header-title .status::before { content: ''; width: 6px; height: 6px; background: currentColor; border-radius: 50%; }

.ngu-hbtn {
    background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px; width: 36px; height: 36px; cursor: pointer; color: #94a3b8;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
}
.ngu-hbtn:hover { background: rgba(255, 255, 255, 0.1); color: #fff; border-color: rgba(255, 255, 255, 0.2); }

/* ---- منطقة الرسائل ---- */
#ngu-messages {
    flex: 1; overflow-y: auto; padding: 24px;
    display: flex; flex-direction: column; gap: 20px;
    scroll-behavior: smooth;
}
#ngu-messages::-webkit-scrollbar { width: 4px; }
#ngu-messages::-webkit-scrollbar-thumb { background: rgba(217, 70, 239, 0.3); border-radius: 10px; }

.ngu-msg { display: flex; gap: 12px; animation: ngu-fade-in 0.3s ease-out; }
.ngu-msg.user { flex-direction: row-reverse; }

@keyframes ngu-fade-in {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.ngu-bubble {
    padding: 12px 18px;
    border-radius: 20px;
    font-size: 0.95rem;
    line-height: 1.6;
    max-width: 85%;
    position: relative;
}
.ngu-msg.ai .ngu-bubble {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #e2e8f0;
    border-bottom-right-radius: 4px;
}
.ngu-msg.user .ngu-bubble {
    background: linear-gradient(135deg, #d946ef, #7c3aed);
    color: #fff;
    border-bottom-left-radius: 4px;
    box-shadow: 0 4px 15px rgba(217, 70, 239, 0.2);
}

/* ---- بطاقات المنتجات المدمجة ---- */
.ngu-product-embed {
    margin-top: 12px;
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    width: 100%;
}
.ngu-product-embed img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}
.ngu-product-embed-info {
    padding: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.ngu-product-embed-title { font-weight: 700; color: #fff; font-size: 0.9rem; }
.ngu-product-embed-price { color: #d946ef; font-weight: 900; }
.ngu-product-link {
    display: block;
    margin-top: 4px;
    background: rgba(217, 70, 239, 0.1);
    color: #d946ef;
    text-align: center;
    padding: 8px;
    font-size: 0.8rem;
    font-weight: bold;
    text-decoration: none;
    transition: background 0.2s;
}
.ngu-product-link:hover { background: rgba(217, 70, 239, 0.2); }

/* ---- منطقة الإدخال ---- */
#ngu-input-area-container {
    padding: 20px 24px;
    background: rgba(255, 255, 255, 0.02);
    border-top: 1px solid rgba(255, 255, 255, 0.05);
}
#ngu-input-wrapper {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    display: flex;
    align-items: flex-end;
    padding: 8px 12px;
    gap: 8px;
    transition: all 0.3s;
}
#ngu-input-wrapper:focus-within {
    border-color: #d946ef;
    background: rgba(255, 255, 255, 0.08);
    box-shadow: 0 0 15px rgba(217, 70, 239, 0.1);
}

#ngu-input {
    flex: 1;
    background: transparent;
    border: none;
    color: #fff;
    padding: 8px 4px;
    font-size: 0.95rem;
    resize: none;
    max-height: 120px;
    outline: none;
    font-family: inherit;
}

#ngu-send {
    width: 40px; height: 40px; border-radius: 14px;
    background: #d946ef; border: none; cursor: pointer; color: #fff;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s; flex-shrink: 0;
}
#ngu-send:hover { transform: scale(1.05); filter: brightness(1.1); }
#ngu-send:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

.ngu-tool-btn {
    width: 36px; height: 36px; border-radius: 12px;
    background: rgba(255, 255, 255, 0.05); border: none; cursor: pointer; color: #94a3b8;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s; flex-shrink: 0;
}
.ngu-tool-btn:hover { background: rgba(255, 255, 255, 0.1); color: #fff; }

/* ---- معاينة الصورة المرفوعة ---- */
#ngu-img-preview {
    margin-bottom: 12px;
    display: none;
    position: relative;
    width: 80px;
    height: 80px;
}
#ngu-img-preview img {
    width: 100%; height: 100%; border-radius: 12px; object-fit: cover;
    border: 2px solid #d946ef;
}
.ngu-remove-img {
    position: absolute; -top-2; -left-2;
    background: #ef4444; color: #fff; width: 20px; height: 20px;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 10px; cursor: pointer; border: 2px solid #0f0f1a;
}

/* Typing Indicator */
.ngu-typing .ngu-bubble { display: flex; gap: 4px; padding: 14px 20px; }
.ngu-dot { width: 6px; height: 6px; background: #94a3b8; border-radius: 50%; animation: ngu-dot-pulse 1.4s infinite; }
.ngu-dot:nth-child(2) { animation-delay: 0.2s; }
.ngu-dot:nth-child(3) { animation-delay: 0.4s; }
@keyframes ngu-dot-pulse { 0%, 100% { opacity: 0.3; transform: scale(1); } 50% { opacity: 1; transform: scale(1.2); } }

@media (max-width: 500px) {
    #ngu-panel { width: calc(100vw - 32px); height: calc(100vh - 100px); left: 16px; bottom: 16px; border-radius: 24px; }
    #ngu-fab { left: 16px; bottom: 16px; }
}
</style>

{{-- ===== HTML ===== --}}
<button id="ngu-fab" title="مساعد NGU">
    <i class="fa-solid fa-wand-magic-sparkles"></i>
</button>

<div id="ngu-panel">
    {{-- Header --}}
    <div id="ngu-header">
        <div id="ngu-avatar-box"><i class="fa-solid fa-robot"></i></div>
        <div id="ngu-header-title">
            <div class="name">NGU AI</div>
            <div class="status">متصل الآن</div>
        </div>
        <div class="flex gap-2">
            <button class="ngu-hbtn" id="ngu-clear" title="مسح">
                <i class="fa-solid fa-rotate-left"></i>
            </button>
            <button class="ngu-hbtn" id="ngu-close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>

    {{-- Messages Area --}}
    <div id="ngu-messages"></div>

    {{-- Input Area --}}
    <div id="ngu-input-area-container">
        <div id="ngu-img-preview">
            <img id="ngu-preview-img" src="">
            <div class="ngu-remove-img" id="ngu-remove-img"><i class="fa-solid fa-xmark"></i></div>
        </div>
        <div id="ngu-input-wrapper">
            @if($isAdmin)
                <button class="ngu-tool-btn" id="ngu-attach" title="إضافة صورة">
                    <i class="fa-solid fa-image"></i>
                </button>
                <input type="file" id="ngu-file-input" accept="image/*" style="display:none">
            @endif
            <textarea id="ngu-input" placeholder="اكتب سؤالك هنا..." rows="1"></textarea>
            <button id="ngu-send">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

{{-- ===== JavaScript ===== --}}
<script>
(function() {
    const fab = document.getElementById('ngu-fab');
    const panel = document.getElementById('ngu-panel');
    const closeBtn = document.getElementById('ngu-close');
    const clearBtn = document.getElementById('ngu-clear');
    const input = document.getElementById('ngu-input');
    const sendBtn = document.getElementById('ngu-send');
    const msgArea = document.getElementById('ngu-messages');
    const fileInput = document.getElementById('ngu-file-input');
    const attachBtn = document.getElementById('ngu-attach');
    const imgPreview = document.getElementById('ngu-img-preview');
    const previewImg = document.getElementById('ngu-preview-img');
    const removeImgBtn = document.getElementById('ngu-remove-img');

    const isAdmin = {{ $isAdmin ? 'true' : 'false' }};
    const STORE_KEY = 'ngu_chat_v2_{{ Auth::id() }}';
    const nguProducts = @json($nguProducts);
    const baseUrl = '{{ url("/") }}';

    let history = [];
    let loading = false;
    let pendingImgUrl = null;

    const welcomeMsg = isAdmin 
        ? "مرحباً أيها المدير! 👋 أنا NGU مساعدك الذكي. يمكنني مساعدتك في إدارة المنتجات، إضافة ألعاب جديدة، أو تحديث المخزون ببساطة عبر المحادثة."
        : "مرحباً بك! 👋 أنا NGU مساعدك في متجر GameStore. اسألني عن أي لعبة أو مواصفات حاسوب وسأعطيك أفضل الاقتراحات!";

    function init() {
        const saved = JSON.parse(localStorage.getItem(STORE_KEY) || '[]');
        if (saved.length > 0) {
            saved.forEach(m => renderMessage(m.role, m.text, m.actions || []));
            history = saved.map(m => ({ role: m.role, text: m.text }));
        } else {
            renderMessage('ai', welcomeMsg);
        }
        scrollToBottom();
    }

    fab.onclick = () => { panel.classList.add('open'); fab.classList.add('open'); setTimeout(() => input.focus(), 300); };
    closeBtn.onclick = () => { panel.classList.remove('open'); fab.classList.remove('open'); };
    clearBtn.onclick = () => { if(confirm('مسح تاريخ المحادثة؟')) { history = []; localStorage.removeItem(STORE_KEY); msgArea.innerHTML = ''; renderMessage('ai', welcomeMsg); } };

    if(attachBtn) {
        attachBtn.onclick = () => fileInput.click();
        fileInput.onchange = async () => {
            const file = fileInput.files[0];
            if(!file) return;
            previewImg.src = URL.createObjectURL(file);
            imgPreview.style.display = 'block';
            attachBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
            
            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', '{{ csrf_token() }}');
            
            try {
                const res = await fetch('{{ route("ai.upload") }}', { method: 'POST', body: formData });
                const data = await res.json();
                if(data.success) {
                    pendingImgUrl = data.url;
                } else {
                    alert('فشل الرفع');
                    clearPreview();
                }
            } catch(e) { alert('خطأ في الرفع'); clearPreview(); }
            attachBtn.innerHTML = '<i class="fa-solid fa-image"></i>';
        };
        removeImgBtn.onclick = clearPreview;
    }

    function clearPreview() {
        pendingImgUrl = null;
        imgPreview.style.display = 'none';
        previewImg.src = '';
        if(fileInput) fileInput.value = '';
    }

    async function sendMessage() {
        const text = input.value.trim();
        if((!text && !pendingImgUrl) || loading) return;

        let displayMsg = text;
        let aiMsg = text;

        if(pendingImgUrl) {
            const userMsgWrap = document.createElement('div');
            userMsgWrap.className = 'ngu-msg user';
            userMsgWrap.innerHTML = `
                <div class="ngu-bubble">
                    <img src="${previewImg.src}" style="width:100%;border-radius:12px;margin-bottom:8px">
                    ${text ? '<div>' + text + '</div>' : ''}
                </div>`;
            msgArea.appendChild(userMsgWrap);
            aiMsg = (text ? text + '\n' : '') + '[صورة مرفقة: ' + pendingImgUrl + ']';
            clearPreview();
        } else {
            renderMessage('user', text);
        }

        history.push({ role: 'user', text: aiMsg });
        input.value = '';
        input.style.height = 'auto';
        scrollToBottom();

        const typing = appendTyping();
        loading = true;
        sendBtn.disabled = true;

        try {
            const res = await fetch('{{ route("ai.chat") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ message: aiMsg, history: history.slice(-8) })
            });
            const data = await res.json();
            typing.remove();
            
            const reply = data.reply || 'عذراً، حدث خطأ.';
            renderMessage('ai', reply, data.actions || []);
            history.push({ role: 'ai', text: reply });
            
            const toSave = history.map((m, i) => ({ ...m, actions: (i === history.length-1 ? data.actions : []) }));
            localStorage.setItem(STORE_KEY, JSON.stringify(toSave.slice(-20)));
        } catch(e) {
            typing.remove();
            renderMessage('ai', '❌ خطأ في الاتصال بخادم NGU');
        }
        loading = false;
        sendBtn.disabled = false;
        scrollToBottom();
    }

    function renderMessage(role, text, actions = []) {
        const wrap = document.createElement('div');
        wrap.className = `ngu-msg ${role}`;
        
        const bubble = document.createElement('div');
        bubble.className = 'ngu-bubble';
        bubble.innerHTML = formatText(text);

        if(actions.length > 0) {
            actions.forEach(a => {
                const act = document.createElement('div');
                act.className = `mt-3 p-3 rounded-xl border ${a.success ? 'bg-green-500/10 border-green-500/30 text-green-400' : 'bg-red-500/10 border-red-500/30 text-red-400'} text-xs font-bold`;
                act.innerHTML = `<i class="fa-solid ${a.success ? 'fa-circle-check' : 'fa-circle-xmark'} mr-1"></i> ${a.message}`;
                bubble.appendChild(act);
            });
        }

        if(role === 'ai') {
            const matched = findProducts(text);
            matched.forEach(p => {
                const embed = document.createElement('div');
                embed.className = 'ngu-product-embed';
                const imgSrc = p.image_url ? (p.image_url.startsWith('http') ? p.image_url : baseUrl + '/' + p.image_url) : null;
                embed.innerHTML = `
                    ${imgSrc ? `<img src="${imgSrc}">` : '<div class="h-20 bg-white/5 flex items-center justify-center text-3xl">🎮</div>'}
                    <div class="ngu-product-embed-info">
                        <span class="ngu-product-embed-title">${p.title}</span>
                        <span class="ngu-product-embed-price">$${p.price}</span>
                    </div>
                    <a href="${baseUrl}/products/${p.id}" target="_blank" class="ngu-product-link">عرض التفاصيل</a>
                `;
                bubble.appendChild(embed);
            });
        }

        wrap.appendChild(bubble);
        msgArea.appendChild(wrap);
        scrollToBottom();
    }

    function findProducts(text) {
        const t = text.toLowerCase();
        return nguProducts.filter(p => t.includes(p.title.toLowerCase())).slice(0, 3);
    }

    function formatText(text) {
        return text.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>').replace(/\n/g, '<br>');
    }

    function appendTyping() {
        const wrap = document.createElement('div');
        wrap.className = 'ngu-msg ai ngu-typing';
        wrap.innerHTML = '<div class="ngu-bubble"><span class="ngu-dot"></span><span class="ngu-dot"></span><span class="ngu-dot"></span></div>';
        msgArea.appendChild(wrap);
        scrollToBottom();
        return wrap;
    }

    function scrollToBottom() { msgArea.scrollTop = msgArea.scrollHeight; }

    sendBtn.onclick = sendMessage;
    input.onkeydown = (e) => { if(e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); } };
    input.oninput = () => { input.style.height = 'auto'; input.style.height = input.scrollHeight + 'px'; };

    init();
})();
</script>
@endauth

