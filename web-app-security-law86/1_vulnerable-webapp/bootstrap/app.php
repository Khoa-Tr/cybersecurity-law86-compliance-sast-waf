<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/**
 * bootstrap/app.php - File khoi tao ung dung Laravel
 *
 * Day la file quan trong nhat khi Laravel khoi dong.
 * No dinh nghia:
 *   1. Cau hinh routing: File nao chua cac route
 *   2. Cau hinh middleware: Cac lop xu ly request/response
 *   3. Cau hinh xu ly loi (exception handling)
 *
 * LO HONG CO Y: CSRF bi tat cho mot so route de demo tan cong
 */
return Application::configure(basePath: dirname(__DIR__))

    // =========================================================
    // CAU HINH ROUTING
    // =========================================================
    // Khai bao vi tri cac file route cua ung dung
    ->withRouting(
        web: __DIR__.'/../routes/web.php',         // Route chinh cho ung dung web
        commands: __DIR__.'/../routes/console.php', // Route cho lenh artisan console
        health: '/up',                              // Route kiem tra tinh trang server (health check)
    )

    // =========================================================
    // CAU HINH MIDDLEWARE
    // =========================================================
    ->withMiddleware(function (Middleware $middleware) {

        // Dang ky alias cho middleware xac thuc phien (session-based auth)
        // Khi route dung ->middleware('check.session'), no se goi CheckSession class
        $middleware->alias([
            'check.session' => \App\Http\Middleware\CheckSession::class,
        ]);

        // LO HONG CO Y: TAT CSRF cho cac route sau (muc dich demo tan cong)
        // ------------------------------------------------------------------
        // CSRF (Cross-Site Request Forgery) la co che bao ve chong lai viec
        // ke tan cong gui request gia mao nhan danh nguoi dung dang dang nhap.
        //
        // Cac route nay khong duoc kiem tra CSRF token:
        //   /posts        - Tao bai viet moi (de demo XSS + CSRF)
        //   /posts/*      - Xoa bai viet (DELETE request)
        //   /profile/*/update - Cap nhat thong tin profile (de demo IDOR + CSRF)
        //
        // Trong ung dung thuc te, TAT CA form POST phai co @csrf token.
        $middleware->validateCsrfTokens(except: [
            '*',
        ]);
    })

    // =========================================================
    // CAU HINH XU LY LOI
    // =========================================================
    ->withExceptions(function (Exceptions $exceptions) {
        // Hien tai xu ly loi mac dinh cua Laravel (chua tuy chinh)
        // Trong thuc te co the them: log loi, gui thong bao email, etc.
    })->create();
