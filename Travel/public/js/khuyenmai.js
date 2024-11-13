window.onscroll = function() {
    let promoBox = document.querySelector(".promo-box");
    if (document.documentElement.scrollTop > 100) { // Điều chỉnh số pixel tùy ý
        promoBox.style.display = "block";
    } else {
        promoBox.style.display = "none";
    }
};
