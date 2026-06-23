<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * DemoInfoSeeder - Khoi tao du lieu demo cho cac bang phu tro
 *
 * Bang 1: demo_credentials - Chua tat ca thong tin dang nhap demo
 *   - Tai khoan ung dung web (admin, john, alice, bob, charlie)
 *   - Tai khoan cong cu (SonarQube, phpMyAdmin)
 *   - Cac payload SQL Injection mau de demo
 *
 * Bang 2: service_links - Chua danh sach tat ca URL he thong
 *   - Phan loai theo muc dich: app, tool, vulnerability
 *   - Dung de hien thi trong trang dashboard va tai lieu huong dan
 */
class DemoInfoSeeder extends Seeder
{
    public function run(): void
    {
        // =============================================
        // DEMO CREDENTIALS
        // =============================================
        DB::table('demo_credentials')->insert([
            // --- Vulnerable Web App Users ---
            [
                'service'  => 'Vulnerable Web App',
                'url'      => 'http://localhost:8000/login',
                'username' => 'admin',
                'password' => 'AdminPass2024!',
                'role'     => 'admin',
                'notes'    => 'Admin account - full access. SQLi test: username = admin\' OR \'1\'=\'1\' --',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'service'  => 'Vulnerable Web App',
                'url'      => 'http://localhost:8000/login',
                'username' => 'john',
                'password' => 'JohnPass123',
                'role'     => 'user',
                'notes'    => 'Regular user. Test IDOR: access /profile/1 while logged in as john (ID: 2)',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'service'  => 'Vulnerable Web App',
                'url'      => 'http://localhost:8000/login',
                'username' => 'alice',
                'password' => 'AlicePass123',
                'role'     => 'user',
                'notes'    => 'Regular user. Test XSS: create post with <script>alert(1)</script>',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'service'  => 'Vulnerable Web App',
                'url'      => 'http://localhost:8000/login',
                'username' => 'bob',
                'password' => 'BobPass123',
                'role'     => 'user',
                'notes'    => 'Regular user.',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'service'  => 'Vulnerable Web App',
                'url'      => 'http://localhost:8000/login',
                'username' => 'charlie',
                'password' => 'CharliePass123',
                'role'     => 'user',
                'notes'    => 'Regular user.',
                'created_at' => now(), 'updated_at' => now(),
            ],
            // --- SonarQube ---
            [
                'service'  => 'SonarQube',
                'url'      => 'http://localhost:9000',
                'username' => 'admin',
                'password' => 'admin',
                'role'     => 'admin',
                'notes'    => 'Default credentials. Change on first login.',
                'created_at' => now(), 'updated_at' => now(),
            ],
            // --- phpMyAdmin ---
            [
                'service'  => 'phpMyAdmin',
                'url'      => 'http://localhost:8080',
                'username' => 'root',
                'password' => 'root123',
                'role'     => 'root',
                'notes'    => 'Full DB access. DB: vulnerable_db',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'service'  => 'phpMyAdmin',
                'url'      => 'http://localhost:8080',
                'username' => 'appuser',
                'password' => 'apppass123',
                'role'     => 'user',
                'notes'    => 'App DB user. Limited access.',
                'created_at' => now(), 'updated_at' => now(),
            ],
            // --- SQL Injection Payloads ---
            [
                'service'  => 'SQLi Attack Payload',
                'url'      => 'http://localhost:8000/login',
                'username' => "admin' OR '1'='1' --",
                'password' => 'anything',
                'role'     => 'bypass',
                'notes'    => 'Authentication bypass via SQL Injection (CWE-89). Works on /login endpoint.',
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);

        // =============================================
        // SERVICE LINKS
        // =============================================
        DB::table('service_links')->insert([
            // Main App
            ['name' => 'Login Page',      'url' => 'http://localhost:8000/login',         'category' => 'app',         'description' => 'Main login page - vulnerable to SQL Injection', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dashboard',       'url' => 'http://localhost:8000/dashboard',      'category' => 'app',         'description' => 'Dashboard showing vulnerability status', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Posts List',      'url' => 'http://localhost:8000/posts',          'category' => 'app',         'description' => 'List of posts - some contain XSS payloads', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Create Post',     'url' => 'http://localhost:8000/posts/create',   'category' => 'vulnerability','description' => 'CSRF + XSS vulnerable form - no sanitization', 'created_at' => now(), 'updated_at' => now()],
            // IDOR Targets
            ['name' => 'Profile - Admin (IDOR)', 'url' => 'http://localhost:8000/profile/1', 'category' => 'vulnerability','description' => 'Admin profile - accessible by any logged-in user (IDOR)', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Profile - John',  'url' => 'http://localhost:8000/profile/2',      'category' => 'app',         'description' => 'User john profile', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Profile - Alice', 'url' => 'http://localhost:8000/profile/3',      'category' => 'app',         'description' => 'User alice profile', 'created_at' => now(), 'updated_at' => now()],
            // Sensitive files (should be blocked)
            ['name' => 'robots.txt',      'url' => 'http://localhost:8000/robots.txt',     'category' => 'vulnerability','description' => 'Exposes sensitive paths - information disclosure', 'created_at' => now(), 'updated_at' => now()],
            ['name' => '.env file',       'url' => 'http://localhost:8000/.env',           'category' => 'vulnerability','description' => 'Should be blocked - contains credentials', 'created_at' => now(), 'updated_at' => now()],
            // Tools
            ['name' => 'SonarQube',       'url' => 'http://localhost:9000',               'category' => 'tool',        'description' => 'Code quality & security scanning (admin/admin)', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'phpMyAdmin',      'url' => 'http://localhost:8080',               'category' => 'tool',        'description' => 'Database management UI (root/root123)', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'WAF / Nginx',     'url' => 'http://localhost:80',                 'category' => 'tool',        'description' => 'WAF-protected app proxy', 'created_at' => now(), 'updated_at' => now()],
        ]);

        echo "Da khoi tao du lieu bang demo_credentials va service_links thanh cong\n";
    }
}
