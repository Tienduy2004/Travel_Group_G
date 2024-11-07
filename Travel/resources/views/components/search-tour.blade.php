{{-- @props(['budgets']) --}}

<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6">
        <form>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="space-y-2 relative">
                    <label for="destination" class="block text-sm font-medium text-green-500">
                        <i class="fas fa-map-marker-alt mr-2"></i>Bạn muốn đi đâu?
                    </label>
                    <input type="text" id="destination" name="destination" placeholder="Nhập địa điểm"
                        class="w-full px-4 py-3 rounded-lg bg-gray-100 border-transparent focus:border-blue-500 focus:bg-white focus:ring-0 text-sm"
                        autocomplete="off">
                    <ul id="suggestions"
                        class="absolute z-10 bg-white border border-gray-300 mt-1 w-full rounded-md hidden"></ul>
                </div>
                <div class="space-y-2">
                    <label for="date" class="block text-sm font-medium text-green-500">
                        <i class="fas fa-calendar-alt mr-2"></i>Ngày đi
                    </label>
                    <input type="date" id="date" name="date"
                        class="w-full px-4 py-3 rounded-lg bg-gray-100 border-transparent focus:border-blue-500 focus:bg-white focus:ring-0 text-sm"
                        min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
                </div>
                <div class="space-y-2">
                    <label for="budget" class="block text-sm font-medium text-green-500">
                        <i class="fas fa-money-bill-wave mr-2"></i>Ngân sách
                    </label>
                    <select id="budget" name="budget"    
                    class="w-full px-4 py-3 rounded-lg bg-gray-100 border-transparent focus:border-blue-500 focus:bg-white focus:ring-0 text-sm">
                    <option value="">Chọn mức giá</option>
                        @foreach ($budgets as $budget)
                            <option value="{{ $budget->name }}">{{ $budget->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-black hover:bg-green-500 focus:bg-blue-700 text-white rounded-lg px-4 py-3 transition-colors duration-300 flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>
                        <span>Tìm Kiếm</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        let timeout;

        $('#destination').on('input', function() {
            let query = $(this).val();

            clearTimeout(timeout);
            timeout = setTimeout(function() {
                if (query.length > 0) {
                    $.ajax({
                        url: '/search-suggestions',
                        method: 'GET',
                        data: {
                            destination: query
                        },
                        success: function(data) {
                            $('#suggestions').empty().removeClass('hidden');
                            data.forEach(function(item) {
                                // Đổi màu ký tự trong gợi ý
                                let highlightedItem = item.replace(
                                    new RegExp(`(${query})`, 'gi'),
                                    '<span class="text-green-400">$1</span>'
                                    );
                                $('#suggestions').append(
                                    '<li class="px-4 py-2 hover:bg-gray-200 cursor-pointer">' +
                                    highlightedItem + '</li>');
                            });
                        }
                    });
                } else {
                    $('#suggestions').empty().addClass('hidden');
                }
            }, 200); // Thay đổi thời gian độ trễ (200ms)
        });

        $(document).on('click', '#suggestions li', function() {
            $('#destination').val($(this).text());
            $('#suggestions').empty().addClass('hidden');
        });

        // Thêm sự kiện cho nút tìm kiếm
        $('form').on('submit', function(e) {
            e.preventDefault(); // Ngăn chặn hành vi mặc định của form

            // Lấy dữ liệu từ các trường nhập
            let destination = $('#destination').val();
            let date = $('#date').val();
            let budget = $('#budget').val();

            // Chuyển hướng đến trang kết quả tìm kiếm với các tham số
            window.location.href =
                `/search-results?destination=${encodeURIComponent(destination)}&date=${encodeURIComponent(date)}&budget=${encodeURIComponent(budget)}`;
        });
    });
</script>