<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

/**
 * LỖ HỔNG CỐ Ý - CHỈ DÀNH CHO MỤC ĐÍCH GIÁO DỤC
 *
 * Loại lỗi: IDOR (Insecure Direct Object Reference) (CWE-639)
 * Mức độ: CAO | CVSS: 7.3
 * OWASP: A01:2021 - Broken Access Control
 *
 * KHÔNG SỬ DỤNG MÃ NÀY TRONG THỰC TẾ
 */
class ProfileController
{
    /**
     * LỖ HỔNG BẢO MẬT: Không kiểm tra quyền sở hữu (IDOR).
     * Bất kỳ người dùng nào cũng có thể xem hồ sơ của người khác.
     *
     * Khai thác: GET /profile/1, /profile/2, /profile/999 (admin)
     */
    public function show($userId)
    {
        // Thiếu kiểm tra quyền: Lấy thông tin user dựa vào ID bất kỳ
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Lỗi rò rỉ dữ liệu: Trả về tất cả các trường nhạy cảm (SSN, số điện thoại, v.v.)
        return view('profile.show', [
            'user' => $user,
        ]);
    }

    /**
     * LỖ HỔNG BẢO MẬT: Không kiểm tra quyền (IDOR) & Lỗi Gán Hàng Loạt (Mass Assignment).
     *
     * Khai thác: POST /profile/999/update với tham số role=admin để tự nâng cấp quyền.
     */
    public function update(Request $request, $userId)
    {
        // Lỗi IDOR: Không kiểm tra quyền sở hữu
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Lỗi Mass Assignment: Cho phép tự do cập nhật bất kỳ trường nào, kể cả trường role
        $user->email    = $request->input('email');
        $user->phone    = $request->input('phone');
        $user->role     = $request->input('role');  // Người dùng tự phong làm admin!
        $user->save();

        return redirect("/profile/$userId")->with('success', 'Profile updated!');
    }

    /**
     * LỖ HỔNG BẢO MẬT: Không kiểm tra quyền. Ai cũng có thể xóa tài khoản của người khác.
     */
    public function destroy($userId)
    {
        // Lỗi IDOR: Không kiểm tra quyền sở hữu
        $user = User::find($userId);
        $user->delete();
        return redirect('/users')->with('success', 'User deleted!');
    }

    /**
     * ✅ SECURE VERSION: Ownership check before access
     */
    public function showSecure($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            abort(404, 'User not found');
        }

        // ✅ Check ownership - only owner or admin can view
        if (auth()->user()->id !== $user->id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        // ✅ Return only non-sensitive fields
        return view('profile.show', [
            'user' => $user->only(['id', 'name', 'email', 'created_at']),
        ]);
    }

    /**
     * ✅ SECURE VERSION: Using Laravel policies
     */
    public function showWithPolicy(User $user)
    {
        // ✅ Laravel policy handles authorization
        $this->authorize('view', $user);
        return view('profile.show', ['user' => $user]);
    }

    /**
     * ✅ SECURE VERSION: Secure update with validation
     */
    public function updateSecure(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        // ✅ Check ownership
        if (auth()->user()->id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        // ✅ Only allow updating safe fields
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        // ✅ No role field - cannot escalate privileges
        $user->update($validated);

        return redirect("/profile/$userId")->with('success', 'Profile updated securely!');
    }
}
