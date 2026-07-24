// Modul Halaman Login — Toggle Visibility Password.
function initPasswordToggle() {
    const toggleButton = document.getElementById('cupos-toggle-password');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('cupos-eye-icon');

    // Guard clause: hentikan eksekusi jika elemen tidak ditemukan
    // (misal saat script ini dimuat di halaman selain login).
    if (!toggleButton || !passwordInput || !eyeIcon) {
        return;
    }

    toggleButton.addEventListener('click', () => {
        const isHidden = passwordInput.type === 'password';
        passwordInput.type = isHidden ? 'text' : 'password';

        eyeIcon.innerHTML = isHidden
            ? '<path d="M3 3l18 18"/><path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 7 11 7a13.16 13.16 0 0 1-1.67 2.68M6.1 6.1C3.2 7.9 1 11 1 11s4 7 11 7a9.7 9.7 0 0 0 5.1-1.4"/>'
            : '<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/>';
    });
}

document.addEventListener('DOMContentLoaded', initPasswordToggle);