{{--
    NAVIGASI KEYBOARD — Enter pindah ke field berikutnya.

    ⚠️ SARAN USER (9 Okt 2026):
    "Navigasi keyboard — Enter pindah ke field berikutnya; ini mempercepat
     input 2–3× lipat dibanding klik mouse terus."

    ⚠️ KENAPA INLINE SCRIPT (bukan resources/js/app.js):
    Panel /admin memuat `theme.css` lewat `viteTheme()`, TIDAK memuat app.js.
    Render hook `panels::body.end` memastikan skrip ini SELALU ikut, tanpa
    perlu build ulang aset.

    Perilaku:
      - Enter di input/select → fokus ke field berikutnya (bukan submit).
      - Enter di TEXTAREA tetap menambah baris baru (tidak diambil alih).
      - Enter di tombol / field terakhir → dibiarkan (submit seperti biasa).
      - Shift/Ctrl/Alt+Enter tidak diambil alih.
--}}
<script data-bks="enter-berikutnya">
    (() => {
        const MARKER = 'bks-enter-berikutnya';

        if (window[MARKER]) {
            return;
        }

        window[MARKER] = true;

        const FIELDS = 'input:not([type=hidden]):not([type=checkbox]):not([type=radio]):not([disabled]), select:not([disabled]), textarea:not([disabled])';

        document.addEventListener('keydown', (event) => {
            if (event.key !== 'Enter') {
                return;
            }

            if (event.shiftKey || event.ctrlKey || event.metaKey || event.altKey) {
                return;
            }

            const el = event.target;

            if (!el || typeof el.closest !== 'function') {
                return;
            }

            // Hanya di dalam field form Filament.
            const wrap = el.closest('.fi-fo-field-wrp');

            if (!wrap) {
                return;
            }

            // Textarea: Enter = baris baru, jangan diambil alih.
            if (el.tagName === 'TEXTAREA') {
                return;
            }

            const scope = el.closest('form') || document;

            const fields = Array.from(scope.querySelectorAll(FIELDS))
                .filter((f) => f.offsetParent !== null);

            const index = fields.indexOf(el);

            if (index === -1) {
                return;
            }

            const next = fields[index + 1];

            // Field terakhir: biarkan Enter men-submit form.
            if (!next) {
                return;
            }

            event.preventDefault();

            next.focus();

            if (typeof next.select === 'function' && next.tagName !== 'SELECT') {
                try {
                    next.select();
                } catch (e) {
                    /* input tanpa select() — abaikan */
                }
            }
        }, true);
    })();
</script>
