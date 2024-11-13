document.getElementById('check_promotion_button').addEventListener('click', function () {
    const programCode = document.getElementById('program_code').value.trim();

    // Lấy giá trị tổng tiền hiện tại từ `totalAmount`
    let currentTotalAmount = parseFloat(
        document.getElementById('totalAmount').innerText.replace(/[^\d]/g, '') // Loại bỏ dấu phẩy và ký tự không phải số
    );

    if (programCode.length >= 5) {
        fetch('/apply-promotion', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                program_code: programCode,
                original_price: currentTotalAmount // Gửi tổng tiền hiện tại để tính giảm giá
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(error => { throw new Error(error.message); });
            }
            return response.json();
        })
        .then(data => {
            // Cập nhật tổng tiền sau khi áp dụng khuyến mãi
            document.getElementById('totalAmount').innerText = `${data.discounted_price.toLocaleString()} ₫`;
            alert(data.message); // Thông báo thành công
        })
        .catch(error => {
            alert(error.message); // Thông báo lỗi
        });
    } else {
        alert("Vui lòng nhập mã khuyến mãi hợp lệ.");
    }
});
