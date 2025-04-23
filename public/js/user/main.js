let mainSlideIndex = 1;
showMainSlides(mainSlideIndex);

function moveMainSlide(n) {
    showMainSlides(mainSlideIndex += n);
}

function currentMainSlide(n) {
    showMainSlides(mainSlideIndex = n);
}

function showMainSlides(n) {
    const slides = document.getElementsByClassName("main-slide");
    const dots = document.getElementsByClassName("main-dot");

    if (n > slides.length) {
        mainSlideIndex = 1;
    }
    if (n < 1) {
        mainSlideIndex = slides.length;
    }

    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove("active-main-slide");
    }

    slides[mainSlideIndex - 1].style.display = "block";
    dots[mainSlideIndex - 1].classList.add("active-main-slide");
}

setInterval(function() {
    moveMainSlide(1);
}, 5000);


document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.like-btn .like-icon').forEach(function (icon) {
        icon.addEventListener('click', function (e) {
            e.stopPropagation();

            const outlineSrc = icon.dataset.outline;
            const filledSrc = icon.dataset.filled;
            const btn = icon.closest('.like-btn');

            if (icon.getAttribute('src') === outlineSrc) {
                icon.setAttribute('src', filledSrc);
            } else {
                icon.setAttribute('src', outlineSrc);
            }

            btn.classList.toggle('liked');
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const scrollContainer = document.getElementById('new-products-scroll-container');
    let scrollSpeed = 0.5;
    function autoScroll() {

        scrollContainer.scrollLeft += scrollSpeed;

        if (scrollContainer.scrollLeft + scrollContainer.clientWidth >= scrollContainer.scrollWidth - 1) {
            scrollContainer.scrollLeft = 0;
        }

        requestAnimationFrame(autoScroll);
    }
    autoScroll();
});

document.addEventListener("DOMContentLoaded", () => {
    const scrollContainer = document.getElementById('sail-products-scroll-container');
    let scrollSpeed = 0;
    function autoScroll() {

        scrollContainer.scrollLeft += scrollSpeed;

        if (scrollContainer.scrollLeft + scrollContainer.clientWidth >= scrollContainer.scrollWidth - 1) {
            scrollContainer.scrollLeft = 0;
        }

        requestAnimationFrame(autoScroll);
    }
    autoScroll();
});

document.addEventListener('DOMContentLoaded', () => {
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        question.addEventListener('click', () => {
            item.classList.toggle('open');
        });
    });
});
