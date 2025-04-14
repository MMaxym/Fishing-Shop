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

document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('toggle-password-confirm');
    const passwordInput = document.getElementById('password_confirmation');

    toggle.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        const iconPath = type === 'password' ? 'PasswordYes.svg' : 'PasswordNo.svg';
        toggle.setAttribute('src', `/images/v2/icon/${iconPath}`);
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const input = document.querySelector("#phone");
    const hiddenInput = document.querySelector("#full_phone");

    if (input && hiddenInput) {
        const iti = window.intlTelInput(input, {
            initialCountry: "ua",
            preferredCountries: [
                "ua", "pl", "de", "fr", "it", "es", "ro", "cz", "sk", "hu", "nl", "be", "se", "no"
            ],
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.min.js"
        });

        input.addEventListener("input", function () {
            this.value = this.value.replace(/[^\d]/g, '');

            const maxLength = getMaxLength(iti.getSelectedCountryData().iso2);
            if (this.value.length > maxLength) {
                this.value = this.value.slice(0, maxLength);
            }
        });

        input.form.addEventListener("submit", function () {
            if (iti.isValidNumber()) {
                hiddenInput.value = iti.getNumber();
            } else {
                hiddenInput.value = '';
            }
        });

        function getMaxLength(countryCode) {
            const lengths = {
                ua: 9,  pl: 9,  de: 11, fr: 9,
                it: 10, es: 9,  ro: 9,  cz: 9,
                sk: 9,  hu: 9,  nl: 9,  be: 9,
                se: 9,  no: 8
            };
            return lengths[countryCode] || 10;
        }
    }
});
