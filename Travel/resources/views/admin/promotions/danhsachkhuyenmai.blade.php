@extends('layouts.app')

@section('content')
<div class="khuyenmai">
    <div class="container">
        <h1>Danh sách mã khuyến mãi</h1>
        <div class="promotions-container">
            @foreach ($promotions as $promotion)
            <div class="promotion-card">
                <div class="promotion-code">
                    <div class="code">Code:
                        <strong>{{ $promotion->code }}</strong>
                    </div>
                    <div class="mota">Mô tả:
                        <strong>{{ $promotion->description }}</strong>
                    </div>
                </div>
                <div class="promotion-expiry">
                    <span class="countdown" data-expiry="{{ $promotion->end_date->format('Y-m-d H:i:s') }}"></span>
                    <div class="expired-text" style="display: none; color: red;">Mã đã hết hạn!</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Promo box hiển thị khi scroll -->
    <div class="promo-box" style="display: none; position: fixed; bottom: 10px; right: 10px; background: #f8d7da; padding: 10px; border-radius: 5px;">
        Promo Box Hiển Thị Khi Scroll!
    </div>
</div>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Hiển thị promo-box khi scroll
        window.onscroll = function () {
            let promoBox = document.querySelector(".promo-box");
            if (document.documentElement.scrollTop > 100) {
                promoBox.style.display = "block";
            } else {
                promoBox.style.display = "none";
            }
        };

        // Countdown cho các mã khuyến mãi
        document.querySelectorAll('.countdown').forEach(function (countdownElement) {
            const expiryTime = new Date(countdownElement.getAttribute('data-expiry'));

            const interval = setInterval(function () {
                const remainingTime = expiryTime - new Date();
                if (remainingTime <= 0) {
                    countdownElement.innerHTML = 'Mã đã hết hạn';
                    const expiredText = countdownElement.parentElement.querySelector('.expired-text');
                    if (expiredText) {
                        expiredText.style.display = 'block';
                    }
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
    });
</script>
@endsection
