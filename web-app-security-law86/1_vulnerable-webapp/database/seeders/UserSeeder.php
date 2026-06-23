<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * UserSeeder - Khoi tao du lieu mau cho bang users (nguoi dung)
 *
 * Muc dich:
 *   - Tao cac tai khoan demo voi nhieu vai tro (admin, user)
 *   - Bao gom du lieu nhay cam gia (SSN, so dien thoai) de demo lo hong IDOR
 *   - Co kiem tra "da seed chua" de tranh tao trung lap khi restart
 *
 * Lo hong trong file nay:
 *   - Mat khau duoc ma hoa bang SHA256 (thuat toan yeu, khong co salt)
 *   - Trong thuc te phai dung: bcrypt hoac argon2 voi salt ngau nhien
 *
 * Danh sach tai khoan:
 *   admin    / AdminPass2024!  - Quyen quan tri he thong
 *   john     / JohnPass123     - Nguoi dung thuong (ID=2, dung de test IDOR)
 *   alice    / AlicePass123    - Nguoi dung thuong (ID=3)
 *   bob      / BobPass123      - Nguoi dung thuong (ID=4)
 *   charlie  / CharliePass123  - Nguoi dung thuong (ID=5)
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Remove the early return so we can update existing users
        $users = [
            [
                'name'      => 'Administrator',
                'username'  => 'admin',
                'email'     => 'admin@company.com',
                'password'  => hash('sha256', 'AdminPass2024!'),
                'phone'     => '+84901234567',
                'ssn_last4' => '1234',
                'role'      => 'admin',
                'department'=> 'Management',
                'join_date' => '2020-01-15',
                'status'    => 'Active',
                'avatar'    => 'https://ui-avatars.com/api/?name=Admin&background=4F46E5&color=fff',
            ],
            [
                'name'      => 'John Doe',
                'username'  => 'john',
                'email'     => 'john@example.com',
                'password'  => hash('sha256', 'JohnPass123'),
                'phone'     => '+84902345678',
                'ssn_last4' => '5678',
                'role'      => 'developer',
                'department'=> 'Engineering',
                'join_date' => '2023-05-10',
                'status'    => 'Active',
                'avatar'    => 'https://ui-avatars.com/api/?name=John+Doe&background=random',
            ],
            [
                'name'      => 'Alice Smith',
                'username'  => 'alice',
                'email'     => 'alice@example.com',
                'password'  => hash('sha256', 'AlicePass123'),
                'phone'     => '+84903456789',
                'ssn_last4' => '9012',
                'role'      => 'design',
                'department'=> 'Design',
                'join_date' => '2023-06-24',
                'status'    => 'Active',
                'avatar'    => 'https://ui-avatars.com/api/?name=Alice+Smith&background=random',
            ],
            [
                'name'      => 'Bob Johnson',
                'username'  => 'bob',
                'email'     => 'bob@example.com',
                'password'  => hash('sha256', 'BobPass123'),
                'phone'     => '+84904567890',
                'ssn_last4' => '3456',
                'role'      => 'engineer',
                'department'=> 'Engineering',
                'join_date' => '2022-11-05',
                'status'    => 'Active',
                'avatar'    => 'https://ui-avatars.com/api/?name=Bob+Johnson&background=random',
            ],
            [
                'name'      => 'Charlie Brown',
                'username'  => 'charlie',
                'email'     => 'charlie@example.com',
                'password'  => hash('sha256', 'CharliePass123'),
                'phone'     => '+84905678901',
                'ssn_last4' => '7890',
                'role'      => 'developer',
                'department'=> 'AI & ML',
                'join_date' => '2023-07-12',
                'status'    => 'Inactive',
                'avatar'    => 'https://ui-avatars.com/api/?name=Charlie+Brown&background=random',
            ],
        ];

        // Vong lap tao hoac cap nhat tung tai khoan nguoi dung
        foreach ($users as $user) {
            User::updateOrCreate(['username' => $user['username']], $user);
        }

        // Thong bao ket qua seed thanh cong
        echo "Da tao " . count($users) . " tai khoan nguoi dung thanh cong\n";
    }
}
