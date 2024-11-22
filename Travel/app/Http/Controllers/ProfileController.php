<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Booking;
use App\Models\Friendship;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{

    public function profile(Request $request)
    {
        $user = Auth::user();
        $profile = Profile::getByUserId($request->input('id'));

        if (!$profile) {
            abort(404); // Hoặc xử lý theo cách khác
        }
        if ($profile->user_id == $user->id) {
            $bookings = Booking::getBookingsByUserId($user->id); // lấy lịch sử booking
            $bookingNews = Booking::getBookingNewsByUserId($user->id); // lấy danh sách booking trong 2 ngày qua
        } else {
            $bookings = [];
            $bookingNews = [];
        }
        $latestTours = Tour::getLatestTours(6); // Gọi hàm để lấy 6 tour mới nhất
        // $receiver = User::findOrFail(1);
        // $messages = Message::where('receiver_id', 1)
        //     ->orWhere('sender_id', 2)
        //     ->orderBy('created_at', 'asc')
        //     ->get();
        // $receiverId = 3;
        $friendship = Friendship::getFriendship($user->id, $profile->user_id);
        // Kiểm tra người gửi và người nhận yêu cầu
        $isInitiator = false;
        if ($friendship) {
            $isInitiator = ($friendship->friend_id == $user->id);
        }

        return view('profile.profile', compact('bookings', 'latestTours', 'bookingNews', 'profile', 'friendship', 'isInitiator'));
    }

    public function updateCover(Request $request, $id)
    {
        $request->validate([
            'cover_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra định dạng ảnh
        ]);

        $profile = Profile::findOrFail($id);

        // Xóa ảnh cũ nếu có
        if ($profile->cover_photo) {
            $oldPath = public_path('img/profile/cover/' . $profile->cover_photo);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Tạo tên file mới và lưu ảnh
        $fileName = time() . '_' . $request->cover_photo->getClientOriginalName();
        $destinationPath = public_path('img/profile/cover');
        $request->cover_photo->move($destinationPath, $fileName);

        // Lưu tên file vào cơ sở dữ liệu
        $profile->cover_photo = $fileName;
        $profile->save();

        return redirect()->back()->with('success', 'Ảnh bìa đã được cập nhật!');
    }

    public function updateAvatar(Request $request, $id)
    {
        //dd($request->file('avatar'));
        // Validate file upload
        try {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return dd($request->file('avatar'),$e->errors());
        }
        
        $profile = Profile::findOrFail($id);

        // Xóa ảnh cũ nếu có
        if ($profile->avatar) {
            $oldPath = public_path('img/profile/avatar/' . $profile->avatar);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Chuẩn hóa tên file
        $originalName = pathinfo($request->avatar->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $request->avatar->getClientOriginalExtension();

        // Tạo tên file an toàn
        $safeName = time() . '_' . Str::slug($originalName, '_') . '.' . $extension;

        // Tạo thư mục lưu file nếu chưa tồn tại
        $destinationPath = public_path('img/profile/avatar');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Lưu file vào thư mục
        $request->avatar->move($destinationPath, $safeName);

        // Cập nhật tên file trong cơ sở dữ liệu
        $profile->avatar = $safeName;
        $profile->save();

        return redirect()->back()->with('success', 'Ảnh đại diện đã được cập nhật!');
    }

    public function updateDetails(Request $request, $id)
    {

       // Gọi phương thức trong model Profile để cập nhật thông tin
       Profile::updateUserProfile($request, $id);

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
