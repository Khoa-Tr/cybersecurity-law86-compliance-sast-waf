<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * LoginController - Xử lý đăng nhập và đăng xuất người dùng
 *
 * MUC DICH GIAO DUC: File nay co chua lo hong SQL Injection (CWE-89)
 * duoc tao ra co y de minh hoa cach ke tan cong co the khai thac
 * khi lap trinh vien khong dung cau lenh SQL an toan (Prepared Statement).
 *
 * DO NGUY HIEM: CRITICAL | Diem CVSS: 9.8
 */
class LoginController extends Controller
{
    /**
     * Hien thi trang dang nhap.
     * Neu nguoi dung da dang nhap (co session user_id), chuyen den dashboard.
     */
    public function showLoginForm()
    {
        if (session('user_id')) return redirect('/dashboard');
        return view('auth.login');
    }

    /**
     * Xu ly qua trinh dang nhap.
     *
     * LO HONG: SQL Injection thong qua noi chuoi string truc tiep vao query.
     * ------------------------------------------------------------------
     * Cach tan cong: Nhap vao o Username: admin'#
     * Cau lenh SQL sau khi inject:
     *   SELECT * FROM users WHERE username = 'admin'#' AND password = '...'
     * Ky tu # la comment trong MySQL, nen phan "AND password" bi bo qua.
     * Ket qua: Dang nhap thanh cong du khong biet mat khau.
     *
     * CACH PHONG NGAN (khong ap dung o day de demo):
     *   - Dung Prepared Statement: DB::select('... WHERE username = ?', [$username])
     *   - Dung Eloquent ORM: User::where('username', $username)->first()
     */
    public function login(Request $request)
    {
        // Lay du lieu nguoi dung nhap tu form
        $username = $request->input('username');
        $password = $request->input('password');

        // Ma hoa mat khau bang SHA256 de so sanh voi du lieu trong CSDL
        // Luu y: SHA256 la thuat toan yeu, nen dung bcrypt hoac argon2 trong thuc te
        $hashedPassword = hash('sha256', $password);

        // LO HONG: Noi chuoi truc tiep bien nguoi dung vao cau lenh SQL
        // Bien $username co the chua ma doc (SQL Injection payload)
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$hashedPassword'";

        // Ghi log canh bao - tat ca cau lenh SQL deu duoc ghi lai de kiem tra
        Log::warning('CANH BAO: VULNERABLE SQL Query executed', ['query' => $query]);

        try {
            // Thuc thi cau lenh SQL truc tiep (khong qua Prepared Statement)
            $users = DB::select($query);
        } catch (\Exception $e) {
            // LO HONG: Thong bao loi tra ve chi tiet loi CSDL cho nguoi dung
            // Trong thuc te khong nen hien thi loi nay vi lo thong tin he thong
            return back()->with('error', 'DB Error: ' . $e->getMessage());
        }

        // Neu tim thay nguoi dung hop le, tao session dang nhap
        if (!empty($users)) {
            $user = $users[0]; // Lay ban ghi dau tien trong ket qua

            // Luu thong tin nguoi dung vao session
            session([
                'user_id'  => $user->id,
                'username' => $user->username,
                'role'     => $user->role,
            ]);

            return redirect('/dashboard')->with('success', 'Chao mung, ' . $user->username . '!');
        }

        // Neu khong tim thay, tra ve thong bao loi chung
        return back()->with('error', 'Invalid username or password.')->withInput();
    }

    /**
     * Xu ly dang xuat.
     * Xoa toan bo du lieu session va chuyen ve trang login.
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login')->with('info', 'Ban da dang xuat thanh cong.');
    }
}
