<?php

/**
/**
 * LỖ HỔNG CỐ Ý - CHỈ DÀNH CHO MỤC ĐÍCH GIÁO DỤC
 *
 * Loại lỗi: Lưu trữ Hardcoded Secrets (Mật khẩu cứng) trong mã nguồn (CWE-798)
 * Mức độ: RẤT NGHIÊM TRỌNG | CVSS: 9.1
 * OWASP: A02:2021 - Cryptographic Failures
 *
 * Thông tin bị lộ bao gồm:
 * - Thông tin đăng nhập Database
 * - API Keys (Stripe, PayPal, AWS)
 * - Khóa mã hóa ứng dụng (Encryption keys)
 *
 * KHÔNG ĐẨY MÃ NÀY LÊN GITHUB HOẶC MÔI TRƯỜNG THỰC TẾ
 */

return [

    // LỖ HỔNG BẢO MẬT: Mật khẩu và thông tin CSDL bị lưu cứng (hardcoded) trong mã nguồn.
    'default' => 'mysql',

    'connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => 'mysql.company.com',          // Tên miền thật của DB
            'port'      => '3306',
            'database'  => 'production_db',               // Tên database thật
            'username'  => 'root',                        // Sử dụng tài khoản root (Rất nguy hiểm)
            'password'  => 'RootPass123!SecureDB',        // MẬT KHẨU BỊ LỘ
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ],
    ],

    // LỖ HỔNG BẢO MẬT: Lưu trữ Key API (Stripe, Paypal) trong code. Nếu source code bị lộ,
    // công ty có thể bị thất thoát tài chính nghiêm trọng.
    'api_keys' => [
        'stripe_publishable' => 'pk_live_51234567890abcdefghijklmnop',
        'stripe_secret'      => 'sk_live_51234567890abcdefghijklmnop',  // KHÓA BÍ MẬT!
        'paypal_client_id'   => 'AeV123PayPalClientID-EXAMPLE',
        'paypal_secret'      => 'EIZ5J1Z5DhX-vZZZZZZZZZZZZZZZZZZZZZ',  // KHÓA BÍ MẬT!
        'sendgrid_api_key'   => 'SG.exampleKey123456789-ABCDEFGH',
    ],

    // LỖ HỔNG BẢO MẬT: AWS Keys bị hardcode. Bot trên Github có thể quét và chiếm đoạt AWS chỉ trong 1 phút.
    'aws' => [
        'key'    => 'AKIAIOSFODNN7EXAMPLE',
        'secret' => 'wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY',  // AWS SECRET KEY!
        'region' => 'us-east-1',
        'bucket' => 'company-production-bucket',
    ],

    // LỖ HỔNG BẢO MẬT: Khóa mã hóa (Encryption key) và JWT bị lộ.
    // Kẻ tấn công có thể dùng key này để tạo JWT giả mạo, đăng nhập dưới tư cách bất kỳ ai.
    'encryption' => [
        'app_key'       => 'base64:abcdefghijklmnopqrstuvwxyz123456==',  // Khóa mã hóa Laravel
        'database_key'  => 'DBEncrypt987654321SecretKeyValue!',
        'jwt_secret'    => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.SECRET',
        'oauth_secret'  => 'oauth_secret_abc123_PRODUCTION_VALUE',
    ],

    // LỖ HỔNG BẢO MẬT: Tài khoản Admin bị đặt cứng trong mã nguồn.
    'admin' => [
        'email'    => 'admin@company.com',
        'password' => 'AdminPass2024!',   // MẬT KHẨU ADMIN!
    ],

    /*
    |--------------------------------------------------------------------------
    | ✅ SECURE VERSION - What it should look like
    |--------------------------------------------------------------------------
    |
    | 'mysql' => [
    |     'host'     => env('DB_HOST', '127.0.0.1'),
    |     'port'     => env('DB_PORT', '3306'),
    |     'database' => env('DB_DATABASE', 'forge'),
    |     'username' => env('DB_USERNAME', 'forge'),
    |     'password' => env('DB_PASSWORD', ''),   // ✅ From environment
    | ],
    |
    | 'api_keys' => [
    |     'stripe_secret' => env('STRIPE_SECRET_KEY'),  // ✅ From .env
    |     'aws_secret'    => env('AWS_SECRET_ACCESS_KEY'),
    | ],
    |
    */

];
