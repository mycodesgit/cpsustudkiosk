{{-- macOS dock-style on-screen keyboard for the login modal.
      Pops up when #studentIdInput or #studentPassInput is clicked;
      keys and DEL always act on the currently selected field.
      Key order: 1-9, 0, dash, K C D U G P, DEL.
      Vanilla JS (no jQuery needed). --}}

<div id="numericKeyboard" class="keyboard-container kiosk-keyboard" aria-hidden="true">
    <button type="button" class="key-btn" data-key="1">1</button>
    <button type="button" class="key-btn" data-key="2">2</button>
    <button type="button" class="key-btn" data-key="3">3</button>
    <button type="button" class="key-btn" data-key="4">4</button>
    <button type="button" class="key-btn" data-key="5">5</button>
    <button type="button" class="key-btn" data-key="6">6</button>
    <button type="button" class="key-btn" data-key="7">7</button>
    <button type="button" class="key-btn" data-key="8">8</button>
    <button type="button" class="key-btn" data-key="9">9</button>
    <button type="button" class="key-btn" data-key="0">0</button>
    <button type="button" class="key-btn key-control-dash" data-key="-" aria-label="Dash">
        <i class="fas fa-minus"></i>
    </button>

    <button type="button" class="key-btn key-letter" data-key="K">K</button>
    <button type="button" class="key-btn key-letter" data-key="C">C</button>
    <button type="button" class="key-btn key-letter" data-key="D">D</button>
    <button type="button" class="key-btn key-letter" data-key="U">U</button>
    <button type="button" class="key-btn key-letter" data-key="G">G</button>
    <button type="button" class="key-btn key-letter" data-key="P">P</button>

    <button type="button" class="key-btn key-control" data-key="backspace">DEL</button>
</div>

<script>
    (function () {
        if (window.__kioskKeyboardInit) return;
        window.__kioskKeyboardInit = true;

        function bindKeyboard() {
            const keyboard = document.getElementById('numericKeyboard');
            if (!keyboard) return;

            // Dock keyboard serves the login fields; it always acts on
            // whichever field is currently selected (focused).
            const studentIdInput = document.getElementById('studentIdInput');
            const studentPassInput = document.getElementById('studentPassInput');
            if (!studentIdInput && !studentPassInput) return;

            let activeInput = null;

            const showKeyboard = (inputField) => {
                if (window.innerWidth >= 768) {
                    keyboard.classList.add('show');
                    keyboard.setAttribute('aria-hidden', 'false');
                    activeInput = inputField;
                }
            };

            const hideKeyboard = () => {
                keyboard.classList.remove('show');
                keyboard.setAttribute('aria-hidden', 'true');
                activeInput = null;
            };

            // Pop up when either login field is clicked / focused, and
            // remember it as the target for keys and DEL.
            if (studentIdInput) {
                studentIdInput.addEventListener('focus', () => showKeyboard(studentIdInput));
                studentIdInput.addEventListener('click', () => showKeyboard(studentIdInput));
            }
            if (studentPassInput) {
                studentPassInput.addEventListener('focus', () => showKeyboard(studentPassInput));
                studentPassInput.addEventListener('click', () => showKeyboard(studentPassInput));
            }

            // Hide when clicking anywhere that is not a login field or the dock.
            document.addEventListener('click', (event) => {
                if (
                    !keyboard.contains(event.target) &&
                    event.target !== studentIdInput &&
                    event.target !== studentPassInput
                ) {
                    hideKeyboard();
                }
            });

            // Hide on Escape and when the login modal closes.
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') hideKeyboard();
            });
            const loginModal = document.getElementById('loginModal');
            if (loginModal) loginModal.addEventListener('hidden.bs.modal', hideKeyboard);

            // Keep the keyboard visible while it is used inside a modal.
            keyboard.addEventListener('mousedown', (event) => event.preventDefault());

            keyboard.addEventListener('click', (event) => {
                const keyBtn = event.target.closest('[data-key]');
                if (!keyBtn || !activeInput) return;

                const key = keyBtn.getAttribute('data-key');
                if (key.length === 1 || key === '-') {
                    activeInput.value = (activeInput.value + key).toUpperCase();
                } else if (key === 'backspace') {
                    activeInput.value = activeInput.value.slice(0, -1);
                } else if (key === 'clear') {
                    activeInput.value = '';
                }
            });

            // Haptic tap animation.
            keyboard.querySelectorAll('.key-btn').forEach((button) => {
                button.addEventListener('click', () => {
                    button.classList.add('clicked');
                    setTimeout(() => button.classList.remove('clicked'), 300);
                });
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', bindKeyboard);
        } else {
            bindKeyboard();
        }
    })();
</script>
