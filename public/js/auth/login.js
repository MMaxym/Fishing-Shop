document.querySelector('.toggle-password').addEventListener('click', function() {
    const passwordField = document.getElementById('password');
    const passwordFieldType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', passwordFieldType);

    const icon = this.querySelector('i');
    icon.classList.toggle('fa-eye-slash');
    icon.classList.toggle('fa-eye');
});
