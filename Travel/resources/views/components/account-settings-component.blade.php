<!-- Thêm Font Awesome vào phần head -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="bg-gray-500 text-white p-6 rounded-lg max-w-4xl">
    <!-- Sidebar -->
    <div class="flex">
        <!-- Menu -->
        <div class="w-1/4">
            <ul class="space-y-4 text-sm font-semibold">
                <li class="text-blue-500">Tổng quan</li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="w-3/4 space-y-6 ml-6">

            <!-- Thông tin -->
            <form action="{{ route('profile.update.details', $profileUser->user_id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <!-- Nơi sống -->
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-black">Sống tại</p>
                        @if ($profileUser->address)
                            <p class="text-sm text-black" id="location-text">{{ $profileUser->address }}</p>
                            <input class="text-black hidden" id="location-input" type="text" name="address"
                                value="{{ $profileUser->address }}">
                        @else
                            <p class="text-sm text-black" id="location-text">{{ $profileUser->address }}</p>
                            <input class="text-black hidden" id="location-input" type="text" name="address">
                        @endif
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="button" class="text-gray-400 hover:text-gray-200"
                            onclick="toggleEdit('location')">
                            <i class="fa-solid fa-pen-to-square w-3 h-3"></i>
                        </button>
                    </div>
                </div>
                <!-- Ngày sinh -->
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-black">Ngày sinh</p>
                        @if ($profileUser->birthdate)
                            <p class="text-sm text-black" id="dob-text">
                                {{ date('d/m/Y', strtotime($profileUser->birthdate)) }}</p>
                            <input class="text-black hidden" id="dob-input" type="date" name="date_of_birth"
                                value="{{ $profileUser->birthdate }}">
                        @else
                            <p class="text-sm text-black" id="dob-text">Chưa có ngày sinh</p>
                            <input class="text-black hidden" id="dob-input" type="date" name="date_of_birth">
                        @endif

                    </div>
                    <button type="button" class="text-gray-400 hover:text-gray-200" onclick="toggleEdit('dob')">
                        <i class="fa-solid fa-pen-to-square w-3 h-3"></i>
                    </button>
                </div>
                <!-- Số điện thoại -->
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-black">Di động</p>
                        @if ($profileUser->phone)
                            <p class="text-sm text-black" id="phone-text">{{ $profileUser->phone }}</p>
                            <input class="text-black hidden" id="phone-input" type="text" name="phone"
                                value="{{ $profileUser->phone }}">
                        @else
                            <p class="text-sm text-black" id="phone-text">Chưa có số điện thoại</p>
                            <input class="text-black hidden" id="phone-input" type="text" name="phone">
                        @endif
                    </div>
                    <button type="button" class="text-gray-400 hover:text-gray-200" onclick="toggleEdit('phone')">
                        <i class="fa-solid fa-pen-to-square w-3 h-3"></i>
                    </button>
                </div>

                <!-- Giới tính -->
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-black">Giới tính</p>

                        @if ($profileUser->gender)
                            <p class="text-sm text-black" id="gender-text">
                                {{ ucfirst(strtolower($profileUser->gender)) }}
                            </p>
                            <select name="gender" id="gender-input"
                                class="bg-gray-400 w-full border rounded appearance-none text-black hidden">
                                <option value="male"
                                    {{ strtolower($profileUser->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female"
                                    {{ strtolower($profileUser->gender) === 'female' ? 'selected' : '' }}>Female
                                </option>
                                <option value="other"
                                    {{ strtolower($profileUser->gender) === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        @else
                            <p class="text-sm text-black" id="gender-text">Vui lòng cập nhật giới tính</p>
                            <select name="gender" id="gender-input"
                                class="bg-gray-400 w-full p-2 border rounded appearance-none text-black hidden">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="orther">Other</option>
                            </select>
                        @endif
                    </div>
                    <button type="button" class="text-gray-400 hover:text-gray-200" onclick="toggleEdit('gender')">
                        <i class="fa-solid fa-pen-to-square w-3 h-3"></i>
                    </button>
                </div>

                <!-- Nút Lưu -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Hàm để thay đổi trạng thái hiển thị của thẻ p và input
    function toggleEdit(field) {
        const textElement = document.getElementById(`${field}-text`);
        const inputElement = document.getElementById(`${field}-input`);

        // Thay đổi hiển thị: ẩn <p>, hiện <input>
        textElement.classList.toggle('hidden');
        inputElement.classList.toggle('hidden');
    }

    
</script>
