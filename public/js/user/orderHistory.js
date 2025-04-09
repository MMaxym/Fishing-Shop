function toggleOrderItems(orderId) {
    var itemsDiv = document.getElementById('order-items-' + orderId);
    itemsDiv.style.display = (itemsDiv.style.display === 'none') ? 'block' : 'none';
}

window.onscroll = function () {
    const scrollToTopButton = document.getElementById("scrollToTop");
    if (window.scrollY > 200) {
        scrollToTopButton.style.display = "block";
    } else {
        scrollToTopButton.style.display = "none";
    }
};

document.getElementById("scrollToTop").onclick = function () {
    window.scrollTo({ top: 0, behavior: "smooth" });
};
