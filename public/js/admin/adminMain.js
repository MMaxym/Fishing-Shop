document.addEventListener('DOMContentLoaded', function () {
    const logoutLink = document.getElementById('logout-link');

    logoutLink.addEventListener('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Вийти з акаунта?',
            text: "Ви дійсно хочете вийти з акаунту?",
            icon: 'warning',
            background: '#f9feff',
            showCancelButton: true,
            confirmButtonText: 'Так, вийти',
            cancelButtonText: 'Скасувати',
            customClass: {
                popup: 'custom-swal-popup',
                title: 'custom-swal-title',
                htmlContainer: 'custom-swal-text',
                confirmButton: 'custom-swal-confirm',
                cancelButton: 'custom-swal-cancel'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    });
});
