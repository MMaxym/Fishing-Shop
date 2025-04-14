document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');

    toggle.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        const iconPath = type === 'password' ? 'PasswordYes.svg' : 'PasswordNo.svg';
        toggle.setAttribute('src', `/images/v2/icon/${iconPath}`);
    });
});

