<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * LỖ HỔNG CỐ Ý - CHỈ DÀNH CHO MỤC ĐÍCH GIÁO DỤC
 * 
 * Loại lỗi: SQL Injection (Tiêm mã SQL) (CWE-89)
 * Mức độ: NGHIÊM TRỌNG | CVSS: 9.8
 * OWASP: A03:2021 - Injection
 * 
 * KHÔNG SỬ DỤNG MÃ NÀY TRONG THỰC TẾ
 */
class LoginController
{
    /**
     * LỖ HỔNG BẢO MẬT: SQL Injection qua nối chuỗi trực tiếp.
     * 
     * Payload tấn công: username = admin' OR '1'='1' --
     */
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // ĐOẠN MÃ LỖI - Nối chuỗi SQL trực tiếp thay vì sử dụng Prepared Statements.
        // Điều này cho phép người dùng chèn thẳng lệnh SQL độc hại vào câu truy vấn.
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        
        try {
            $user = DB::select(DB::raw($query));

            if ($user) {
                session(['user_id' => $user[0]->id, 'username' => $user[0]->username]);
                return redirect('/dashboard')->with('success', 'Login successful!');
            }
        } catch (\Exception $e) {
            // Cố tình in ra lỗi SQL thô (Raw Error) để công cụ ZAP dễ dàng bắt được
            return response($e->getMessage(), 500);
        }

        return back()->with('error', 'Invalid credentials');
    }

    /**
     * ✅ SECURE VERSION (for comparison)
     * Uses parameterized queries - NOT vulnerable to SQL injection
     */
    public function loginSecure(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // ✅ SECURE CODE - Parameterized query using Eloquent
        $user = DB::table('users')
            ->where('username', $username)
            ->where('password', hash('sha256', $password))
            ->first();

        if ($user) {
            session(['user_id' => $user->id, 'username' => $user->username]);
            return redirect('/dashboard')->with('success', 'Login successful!');
        }

        return back()->with('error', 'Invalid credentials');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login')->with('info', 'Logged out successfully');
    }

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
}
