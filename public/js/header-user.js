document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.search-input');
    const searchIcon = document.querySelector('.search-icon');

    function performSearch() {
        const query = searchInput.value.trim();
        if (query) {
            window.location.href = `/search?query=${encodeURIComponent(query)}`;
        }
        else {
            window.location.href = `/user/main`;
        }
    }

    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            performSearch();
        }
    });

    searchIcon.addEventListener('click', () => {
        performSearch();
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const burgerButton = document.getElementById('burgerMenu');
    const mobileNav = document.getElementById('mobileNav');

    burgerButton.addEventListener('click', function () {
        mobileNav.classList.toggle('active');
        burgerButton.classList.toggle('open');
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById('searchToggleBtn');
    const overlay = document.getElementById('searchOverlay');
    const closeBtn = document.getElementById('closeSearchBtn');

    if (toggleBtn && overlay && closeBtn) {
        toggleBtn.addEventListener('click', () => {
            overlay.classList.add('active');
            overlay.querySelector('input').focus();
        });

        closeBtn.addEventListener('click', () => {
            overlay.classList.remove('active');
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                overlay.classList.remove('active');
            }
        });
    }
});
