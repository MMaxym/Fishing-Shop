<head>
    <link rel="stylesheet" href="{{ asset('css/footer-user.css') }}">
</head>

<footer class="footer">
    <div class="footer-info-section">
        <div class="address-info">
            <h4 class="address-title">Наша адреса</h4>
            <div class="address-main">
                <div class="address-text">
                    <img class="address-icon" alt="Logo" src="{{ asset('images/v2/icon/LocationOutlineFooter.svg') }}">
                    <div class="address-text-row">
                        <p class="address-text-row-title">Зарічанська 10,</p>
                        <p class="address-text-row-description">м.Хмельницький, Україна</p>
                    </div>
                </div>
                <div class="address-text">
                    <img class="address-icon" alt="Logo" src="{{ asset('images/v2/icon/PhoneOutlineFooter.svg') }}">
                    <div class="address-text-row">
                        <p class="address-text-row-title">+380 (98) 867 85 45</p>
                    </div>
                </div>
                <div class="address-text">
                    <img class="address-icon" alt="Logo" src="{{ asset('images/v2/icon/EmailOutlineFooter.svg') }}">
                    <div class="address-text-row">
                        <p class="address-text-row-title">makspufi@gmail.com</p>
                    </div>
                </div>
            </div>
            <div class="social-icon-section">
                <a href="https://t.me/maxym_melnyk" class="social-icon">
                    <img class="user-page-icon" alt="Logo" src="{{ asset('images/v2/icon/SocialTelegram.svg') }}">
                </a>
                <a href="https://www.instagram.com/accurat.com.ua/" class="social-icon">
                    <img class="user-page-icon" alt="Logo" src="{{ asset('images/v2/icon/SocialInstagram.svg') }}">
                </a>
                <a href="https://ua.linkedin.com/" class="social-icon">
                    <img class="user-page-icon" alt="Logo" src="{{ asset('images/v2/icon/SocialLinkedin.svg') }}">
                </a>
                <a href="https://www.facebook.com/makspufi" class="social-icon">
                    <img class="user-page-icon" alt="Logo" src="{{ asset('images/v2/icon/SocialFacebook.svg') }}">
                </a>
            </div>
        </div>
        <div class="address-info">
            <h4 class="address-title">Графік роботи</h4>
            <div class="address-main">
                <div class="address-text">
                    <div class="address-text-row">
                        <p class="address-text-row-title">Понеділок - П’ятниця</p>
                        <p class="address-text-row-description">9:00 - 18:00</p>
                    </div>
                </div>
                <div class="address-text">
                    <div class="address-text-row">
                        <p class="address-text-row-title">Субота - Неділя</p>
                        <p class="address-text-row-description">Вихідні дні</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="address-info" id="footer-categories">
            <h4 class="address-title">Категорії</h4>
            <div class="address-main">
                <div class="address-text">
                    <img class="address-icon" alt="Logo" src="{{ asset('images/v2/icon/FishFooter.svg') }}">
                    <a href="{{route('user.categoryPilkers')}}" class="address-link-row">
                            <p class="address-link-row-title">Пількери</p>
                    </a>
                </div>
                <div class="address-text">
                    <img class="address-icon" alt="Logo" src="{{ asset('images/v2/icon/FishFooter.svg') }}">
                    <a href="{{route('user.categoryTailSpinners')}}" class="address-link-row">
                        <p class="address-link-row-title">Тейл-спінери</p>
                    </a>
                </div>
                <div class="address-text">
                    <img class="address-icon" alt="Logo" src="{{ asset('images/v2/icon/FishFooter.svg') }}">
                    <a href="{{route('user.categoryBalancers')}}" class="address-link-row">
                        <p class="address-link-row-title">Балансири</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="address-info" id="contact-section">
            <h4 class="address-title">Зворотній звʼязок</h4>
            <div class="address-main" id="contact-main">
                <div class="address-text" id="contact-text">
                    <img class="address-icon" alt="Logo" src="{{ asset('images/v2/icon/PhoneOutlineFooter.svg') }}">
                    <div class="address-text-row">
                        <p class="address-text-row-title">+380 (98) 867 85 45</p>
                    </div>
                </div>
                <div class="address-text" id="contact-text">
                    <img class="address-icon" alt="Logo" src="{{ asset('images/v2/icon/PhoneOutlineFooter.svg') }}">
                    <div class="address-text-row">
                        <p class="address-text-row-title">+380 (97) 225 02 48</p>
                    </div>
                </div>

            </div>
            <div class="address-text" id="contact-text">
                <p class="address-text-row-title" id="contact-text-row">* Якщо у вас є питання щодо нашого асортименту або послуг, будь ласка, зателефонуйте нам.</p>
            </div>
        </div>
    </div>
    <div class="footer-info-section" id="second-section">
        <a href="{{ route('user.main') }}" class="logo-link" id="logo-link-footer">
            <img class="logo-icon" alt="Logo" title="Перейти на головну" src="{{ asset('images/v2/img/logo.svg') }}">
        </a>
        <div class="address-text-row" id="pages-links-footer">
            <a href="{{route('user.main')}}" class="address-link-row">
                <p class="address-link-row-title">Головна</p>
            </a>
            <div class="vertical-line">|</div>
            <a href="{{route('user.about')}}" class="address-link-row">
                <p class="address-link-row-title">Про нас</p>
            </a>
            <div class="vertical-line">|</div>
            <a href="{{route('user.discount')}}" class="address-link-row">
                <p class="address-link-row-title">Знижки</p>
            </a>
            <div class="vertical-line">|</div>
            <a href="{{route('user.delivery')}}" class="address-link-row">
                <p class="address-link-row-title">Доставка</p>
            </a>
        </div>
        <p class="footer-info-dev">
            Розроблено <a href="https://github.com/MMaxym" class="footer-info-dev-link" id="link-fs">Melnyk Maksym. </a>
            <a href="{{ route('user.main') }}" class="footer-info-dev-link" >FISHING STORE. </a> © Усі права захищені. 2025
        </p>
    </div>
</footer>


