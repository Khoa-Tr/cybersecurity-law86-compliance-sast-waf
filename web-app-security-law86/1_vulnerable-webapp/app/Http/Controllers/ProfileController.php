<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

/**
 * LỖ HỔNG CỐ Ý - CHỈ DÀNH CHO MỤC ĐÍCH GIÁO DỤC
 *
 * Loại lỗi: IDOR (Insecure Direct Object Reference - Tham chiếu Đối tượng Trực tiếp Không an toàn)
 * Mức độ: CAO | CVSS: 7.3
 * OWASP: A01:2021 - Broken Access Control (Kiểm soát truy cập bị hỏng)
 *
 * KHÔNG SỬ DỤNG MÃ NÀY TRONG THỰC TẾ
 */
class ProfileController extends \Illuminate\Routing\Controller
{
    /**
     * LỖ HỔNG BẢO MẬT: Không kiểm tra quyền sở hữu (IDOR).
     * Bất kỳ người dùng nào cũng có thể xem hồ sơ của người khác chỉ bằng cách đổi ID trên URL.
     * Ví dụ: Một nhân viên bình thường truy cập GET /profile/999 để xem thông tin của Admin.
     */
    public function show($userId)
    {
        // Thiếu logic xác thực: Hệ thống lấy thông tin User trực tiếp từ ID do người dùng cung cấp 
        // mà không kiểm tra xem ID này có khớp với auth()->id() (người dùng đang đăng nhập) hay không.
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Lỗi rò rỉ dữ liệu: Trả về toàn bộ object $user cho View, bao gồm cả các trường nhạy cảm
        // như số an sinh xã hội (SSN), số điện thoại, mật khẩu đã băm, quyền hạn (role) v.v.
        return view('profile.show', [
            'user' => $user,
        ]);
    }

    /**
     * LỖ HỔNG BẢO MẬT: Không kiểm tra quyền (Authorization) & Lỗi Gán Hàng Loạt (Mass Assignment).
     * Bất kỳ ai cũng có thể sửa hồ sơ của người khác và tự nâng cấp quyền của mình.
     * Khai thác: Gửi request POST đến /profile/999/update kèm theo trường role=admin.
     */
    public function update(Request $request, $userId)
    {
        // Lỗi IDOR: Lấy thông tin người dùng để sửa đổi dựa trên ID từ URL mà không xác thực quyền.
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Lỗi Mass Assignment (Gán hàng loạt) và Privilege Escalation (Leo thang đặc quyền):
        // Cho phép gán trực tiếp bất kỳ giá trị nào từ Request vào Database mà không lọc.
        // Kẻ tấn công có thể chèn thêm trường 'role' vào request để tự phong mình làm 'admin'.
        if ($request->has('email')) $user->email = $request->input('email');
        if ($request->has('phone')) $user->phone = $request->input('phone');
        if ($request->has('role')) $user->role = $request->input('role');

        // Lỗi Upload File: Không kiểm tra nghiêm ngặt loại file (MIME type) hoặc đuôi file hợp lệ.
        // (Được để lại cho mục đích demo XSS qua file ảnh giả mạo).
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/avatars'), $filename);
            $user->avatar = '/uploads/avatars/' . $filename;
        }

        $user->save();

        return redirect("/profile/$userId")->with('success', 'Profile updated!');
    }

    /**
     * LỖ HỔNG BẢO MẬT: Không kiểm tra quyền (Authorization).
     * Cho phép bất kỳ ai xóa tài khoản của người khác bằng cách gửi request tới chức năng xóa.
     */
    public function destroy($userId)
    {
        // Lỗi IDOR: Xóa tài khoản mà không kiểm tra xem người yêu cầu có phải là chủ tài khoản
        // hoặc có phải là Quản trị viên (Admin) hay không.
        $user = User::find($userId);
        $user->delete();
        return redirect('/users')->with('success', 'User deleted!');
    }

    /**
     * Show form to create a new employee
     */
    public function create()
    {
        return view('profile.create');
    }

    /**
     * LỖ HỔNG BẢO MẬT: Thiếu bảo vệ CSRF và dính lỗi Gán Hàng Loạt (Mass Assignment).
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = hash('sha256', $request->input('password'));
        
        // Lỗi Privilege Escalation: Cho phép người dùng tự do gửi lên quyền hạn (role) tùy thích
        // thay vì gán một quyền mặc định an toàn ở phía backend.
        $user->role = $request->input('role', 'developer');
        $user->department = $request->input('department', 'Engineering');
        $user->join_date = date('Y-m-d');
        $user->status = 'Active';
        $user->avatar = 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random';
        $user->save();

        return redirect('/dashboard')->with('success', 'Employee created successfully!');
    }
}
