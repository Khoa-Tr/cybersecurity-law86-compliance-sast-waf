<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * DatabaseSeeder - Dieu phoi qua trinh seed toan bo CSDL
 *
 * Day la seeder chinh, duoc goi khi chay lenh: php artisan db:seed
 * No goi lan luot tung seeder theo thu tu phu thuoc du lieu:
 *   1. UserSeeder     - Tao nguoi dung truoc (PostSeeder can user_id)
 *   2. PostSeeder     - Tao bai viet (can user_id tu UserSeeder)
 *   3. DemoInfoSeeder - Tao du lieu phu tro (bang credentials, links)
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Chay toan bo seeder theo thu tu dinh nghia.
     * Moi seeder tu co kiem tra de tranh tao trung lap du lieu.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PostSeeder::class,
            DemoInfoSeeder::class,
        ]);
    }
}
