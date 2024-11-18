window.onscroll = function() {
    let promoBox = document.querySelector(".promo-box");
    if (document.documentElement.scrollTop > 100) { // Điều chỉnh số pixel tùy ý
        promoBox.style.display = "block";
    } else {
        promoBox.style.display = "none";
    }
};



document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.countdown').forEach(function(countdownElement) {
        const expiryTime = new Date(countdownElement.getAttribute('data-expiry'));

        // Đếm ngược
        const interval = setInterval(function() {
            const remainingTime = expiryTime - new Date();
            if (remainingTime <= 0) {
                countdownElement.innerHTML = 'Mã đã hết hạn';
                countdownElement.parentElement.querySelector('.expired-text').style.display = 'block';
                clearInterval(interval);
            } else {
                const days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
                const hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
                countdownElement.innerHTML = `${days} ngày ${hours} giờ ${minutes} phút ${seconds} giây`;
            }
        }, 1000);
    });
})