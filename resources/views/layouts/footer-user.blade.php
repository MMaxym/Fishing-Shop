<head>
    <link rel="stylesheet" href="{{ asset('css/footer-user.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/@clr/icons@5.7.0/clr-icons.min.css">
</head>

<footer class="footer-style" style="width: 100%; background-color: #D0DAF3; padding: 0; margin: 0;">
    <div class="container" style="max-width:2000px; background: #D0DAF3; color: #2C73BB; padding-top: 80px;  width: 100%; padding-left: 150px; padding-right: 150px;">
            <div class="row g-5 custom-gap" style="border-bottom: 1px solid #888888; padding-bottom: 20px;">
                <div class="col-lg-2 col-md-6" style="margin-right: 20px;">
                    <h4 class="text mb-4" style="color: #04396E;">Наша адреса</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3" style="color:#04396E; margin-right: 10px;"></i> Зарічанська 10, Хмельницький, Україна</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3" style="color:#04396E; margin-right: 10px;"></i> +380988678545</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3" style="color:#04396E; margin-right: 10px;"></i> makspufi@gmail.com</p>
                    <div class="d-flex pt-3">
                        <a class="btn btn btn-social" href="https://t.me/maxym_melnyk"><i class="fab fa-telegram"></i></a>
                        <a class="btn btn btn-social" href="https://www.facebook.com/makspufi"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn btn-social" href="https://www.youtube.com/"><i class="fab fa-youtube"></i></a>
                        <a class="btn btn btn-social" href="https://ua.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h4 class="text mb-4" style="color: #04396E;">Години роботи</h4>
                    <h6 class="text" style="color: #04396E;">Понеділок - Пʼятниця:</h6>
                    <p class="mb-4">9:00 - 18:00</p>
                    <h6 class="text" style="color: #04396E;">Субота - Неділя:</h6>
                    <p class="mb-0">Вихідні дні</p>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h4 class="category-title">Категорії</h4>
                    <a class="category-link" href="{{route('user.categoryTailSpinners')}}">
                        <span class="clarity--fish-line"></span>Тейл-спінери
                        <i class="fas fa-chevron-right" style="margin-left: 5px;"></i>
                    </a>
                    <a class="category-link" href="{{route('user.categoryBalancers')}}">
                        <span class="clarity--fish-line"></span>Балансири
                        <i class="fas fa-chevron-right" style="margin-left: 5px;"></i>
                    </a>
                    <a class="category-link" href="{{route('user.categoryPilkers')}}">
                        <span class="clarity--fish-line"></span>Пількери
                        <i class="fas fa-chevron-right" style="margin-left: 5px;"></i>
                    </a>
                </div>


                <div class="col-lg-2 col-md-6">
                    <h4 class="text mb-4" style="color: #04396E;">Зворотній звʼязок</h4>
                    <p>Якщо у вас є питання щодо нашого асортименту або послуг, будь ласка, напишіть нам.</p>
                    <div class="position-relative w-100">
                        <input type="email" class="form-control email-input" id="emailInput" placeholder="Ваш email">
                        <button class="btn btn-email position-absolute top-50 end-0 translate-middle-y" id="sendButton">
                            <i class="fas fa-paper-plane" style="margin-right: 0;"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="copyright" style="margin-top: 30px; padding-bottom: 50px;">
                <div class="row">
                    <div class="col-md-6 text-left text-md-start">
                        &copy; <a class="border-bottom" href="">FISHING SHOP</a>, Усі права захищені.
                        <br>
                        Розроблено <a class="border-bottom" href="https://github.com/MMaxym">Melnyk Maksym</a>
                    </div>
                    <div class="col-md-6 text-right text-md-end">
                        <div class="footer-menu">
                            <a href="{{ route('user.main') }}">Головна</a> |
                            <a href="{{ route('user.about') }}">Про нас</a> |
                            <a href="{{ route('user.discount') }}">Знижки</a> |
                            <a href="{{ route('user.delivery') }}">Доставка</a>
                        </div>
                    </div>
                </div>
            </div>

    </div>
    <script src="https://unpkg.com/@clr/icons@5.7.0/clr-icons.min.js"></script>
    <script>
        document.getElementById('sendButton').addEventListener('click', function (event) {
            event.preventDefault();
            alert("Дякуємо за повідомлення!\nМи звʼяжемося з Вами як найшвидше!!!");
            document.getElementById('emailInput').value = '';
        });

    </script>

</footer>


