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
