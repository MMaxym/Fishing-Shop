document.querySelector('.toggle-password').addEventListener('click', function() {
    const passwordField = document.getElementById('password');
    const passwordFieldType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', passwordFieldType);

    const icon = this.querySelector('i');
    icon.classList.toggle('fa-eye-slash');
    icon.classList.toggle('fa-eye');
});

document.querySelector('.toggle-password-confirmation').addEventListener('click', function() {
    const passwordConfirmationField = document.getElementById('password_confirmation');
    const passwordFieldType = passwordConfirmationField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordConfirmationField.setAttribute('type', passwordFieldType);

    const icon = this.querySelector('i');
    icon.classList.toggle('fa-eye-slash');
    icon.classList.toggle('fa-eye');
});

document.addEventListener('DOMContentLoaded', function() {
    const phoneInputField = document.querySelector("#phone");
    if (phoneInputField) {
        const iti = window.intlTelInput(phoneInputField, {
            initialCountry: "ua",
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
            nationalMode: false,
            formatOnDisplay: true,
            autoHideDialCode: false,
        });

        phoneInputField.addEventListener('input', function(e) {
            let digits = phoneInputField.value.replace(/\D/g, '');

            let countryData = iti.getSelectedCountryData();
            let countryCode = countryData.dialCode;

            if (countryCode === '380' && digits.length > 3) {
                let formatted = digits.slice(0, 3);
                let rest = digits.slice(3);
                let match = rest.match(/(\d{0,2})(\d{0,3})(\d{0,2})(\d{0,2})/);

                phoneInputField.value = '+' + formatted + ' ' + (match[1] ? match[1] : '') + (match[2] ? ' ' + match[2] : '') + (match[3] ? ' ' + match[3] : '') + (match[4] ? ' ' + match[4] : '');
            }
        });

        phoneInputField.addEventListener('input', function() {
            let maxDigits = 12;
            let digits = phoneInputField.value.replace(/\D/g, '');
            let countryData = iti.getSelectedCountryData();
            let countryCodeLength = countryData.dialCode.length;

            if (digits.length > (maxDigits + countryCodeLength)) {
                phoneInputField.value = phoneInputField.value.slice(0, maxDigits + countryCodeLength + 1);
            }
        });
    }
});
