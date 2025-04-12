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
    </head>

    <body style="background-color: var(--main-light);">

        <div id="global-loader" class="loader-hidden">
            <div class="loader-spinner"></div>
        </div>

        @yield('content')

        @if (session('success'))
            <div class="success-parent" id="success-alert">
                <img class="icon-success" alt="Success" src="{{ asset('images/v2/icon/DoneOutline.svg') }}">
                <div class="alert-success">  {{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="cancel-parent"  id="cancel-alert">
                <img class="icon-cancel" alt="Cancel" src="{{ asset('images/v2/icon/CanselOutline.svg') }}">
                <div class="alert-danger">  {{ session('error') }}</div>
            </div>
        @endif


        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

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
                }, 500);
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


        </script>
    </body>
</html>
