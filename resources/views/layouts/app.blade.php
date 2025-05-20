<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Fishing Store')</title>

        <link rel="stylesheet" href="{{ asset('css/global.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="icon" href="{{ asset('images/v2/img/site-logo.png') }}"  type="image/x-icon">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    </head>

    <body style="background-color: var(--main-light);">

        <div id="global-loader" class="loader-hidden">
            <div class="loader-spinner"></div>
        </div>

        @yield('content')

        <div id="scrollToTop" class="scroll-to-top">
            <img  class="arrow-scroll-icon" src="{{ asset('images/v2/icon/ArrowBigUpScrollToTop.svg') }}" alt="ArrowIcon">
        </div>


        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>

            document.addEventListener('DOMContentLoaded', function () {
                const successAlert = document.getElementById('success-alert');
                const cancelAlert = document.getElementById('cancel-alert');

                if (successAlert) {
                    setTimeout(() => {
                        successAlert.remove();
                    }, 30000);
                }

                if (cancelAlert) {
                    setTimeout(() => {
                        cancelAlert.remove();
                    }, 3000);
                }
            });

            let loaderTimeout;

            function showLoaderWithDelay() {
                loaderTimeout = setTimeout(() => {
                    document.getElementById('global-loader')?.classList.remove('loader-hidden');
                }, 100);
            }

            function hideLoader() {
                clearTimeout(loaderTimeout);
                document.getElementById('global-loader')?.classList.add('loader-hidden');
            }

            window.addEventListener('beforeunload', () => {
                showLoaderWithDelay();
            });

            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('form').forEach(form => {
                    form.addEventListener('submit', function () {
                        showLoaderWithDelay();
                    });
                });
            });

            window.addEventListener('load', () => {
                hideLoader();
            });

            // showLoaderWithDelay(); перед ajax запитом
            // hideLoader(); після ajax запиту

            document.addEventListener("DOMContentLoaded", () => {
                const scrollBtn = document.getElementById("scrollToTop");

                window.addEventListener("scroll", () => {
                    if (window.scrollY > 200) {
                        scrollBtn.classList.add("show");
                    } else {
                        scrollBtn.classList.remove("show");
                    }
                });

                scrollBtn.addEventListener("click", () => {
                    window.scrollTo({
                        top: 0,
                        behavior: "smooth"
                    });
                });
            });


            function showToast(message, type = 'success') {
                const icons = {
                    success: "{{ asset('images/v2/icon/DoneFilled.svg') }}",
                    warning: "{{ asset('images/v2/icon/WarningFilled.svg') }}",
                    info: "{{ asset('images/v2/icon/InfoOutline.svg') }}",
                    error: "{{ asset('images/v2/icon/CanselFilled.svg') }}"
                };

                const icon = icons[type] || 'ℹ️';

                Toastify({
                    node: createCustomToast(icon, message, type),
                    duration: 5000,
                    gravity: "bottom",
                    position: "left",
                    stopOnFocus: true,
                    close: false,
                    style: {
                        background: "none",
                        boxShadow: "none"
                    },
                    offset: {
                        x: 0,
                        y: 0
                    }
                }).showToast();
            }

            function createCustomToast(iconSrc, message, type) {
                const toast = document.createElement('div');
                toast.className = `custom-toast toast-${type}`;

                toast.innerHTML = `
                     <span class="toast-icon">
                        <img src="${iconSrc}" alt="icon" width="28" height="28">
                    </span>
                    <span class="toast-message">${message}</span>
                    <button class="toast-close">&times;</button>
                `;

                toast.querySelector('.toast-close').addEventListener('click', () => {
                    toast.parentElement?.remove();
                });

                return toast;
            }


            document.addEventListener('DOMContentLoaded', function () {
                @if (session('success'))
                showToast(@json(session('success')), 'success');
                @endif

                @if (session('warning'))
                showToast(@json(session('warning')), 'warning');
                @endif

                @if (session('error'))
                showToast(@json(session('error')), 'error');
                @endif
            });

        </script>
    </body>
</html>
