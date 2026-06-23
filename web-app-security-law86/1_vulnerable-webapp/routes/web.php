<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', fn() => redirect('/login'));

Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('check.session')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export', [DashboardController::class, 'exportCsv'])->name('dashboard.export');

    // Mockup routes for sidebar links
    Route::view('/employees', 'mockups.employees')->name('employees.index');
    Route::view('/attendances', 'mockups.attendances')->name('attendances.index');
    Route::view('/calendar', 'mockups.calendar')->name('calendar.index');
    Route::view('/leaves', 'mockups.leaves')->name('leaves.index');

    Route::get('/employee/create', [ProfileController::class, 'create'])->name('employee.create');
    Route::post('/employee', [ProfileController::class, 'store'])
        ->name('employee.store')
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]); // Cố tình vô hiệu hóa bảo vệ CSRF để thực hành

    // LỖ HỔNG CSRF (Cross-Site Request Forgery):
    // Cố tình vô hiệu hóa middleware VerifyCsrfToken cho route này.
    // Điều này có nghĩa là ứng dụng sẽ không kiểm tra token bảo mật khi nhận request POST.
    // Kẻ tấn công có thể lừa nạn nhân truy cập một trang web độc hại, từ đó tự động gửi
    // một request POST ẩn đến '/posts' bằng quyền của nạn nhân mà họ không hề hay biết.
    Route::get('/posts',         [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create',  [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts',        [PostController::class, 'store'])
        ->name('posts.store')
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);  // Vô hiệu hóa bảo vệ CSRF
    Route::get('/posts/{id}',    [PostController::class, 'show'])->name('posts.show');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

    // LỖ HỔNG IDOR (Insecure Direct Object Reference) & CSRF:
    // Route '/profile/{id}' nhận tham số ID trực tiếp từ URL.
    // Nếu Controller không kiểm tra xem ID này có thuộc về người dùng đang đăng nhập hay không,
    // bất kỳ ai cũng có thể thay đổi ID trên URL (ví dụ từ /profile/1 sang /profile/2) 
    // để xem hoặc chỉnh sửa trái phép thông tin của người khác.
    Route::get('/profile/{id}',         [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/{id}/update', [ProfileController::class, 'update'])
        ->name('profile.update')
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);  // Vô hiệu hóa bảo vệ CSRF

    // My profile (shortcut)
    Route::get('/profile', function () {
        return redirect('/profile/' . session('user_id'));
    })->name('profile.mine');
});
