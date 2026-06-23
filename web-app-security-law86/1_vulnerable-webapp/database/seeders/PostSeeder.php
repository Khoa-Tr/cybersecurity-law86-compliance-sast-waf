<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

/**
 * PostSeeder - Khoi tao du lieu mau cho bang posts (bai viet)
 *
 * Muc dich:
 *   - Tao san cac bai viet demo khi ung dung lan dau khoi dong
 *   - Bao gom cac bai viet co chua XSS payload de demo lo hong
 *   - Co kiem tra "da seed chua" de tranh tao trung lap khi restart
 *
 * Luu y: Cac XSS payload duoc luu co y khong qua loc (unsanitized)
 * nham muc dich minh hoa lo hong Stored XSS (CWE-79)
 */
class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Kiem tra neu da co bai viet trong CSDL thi bo qua, khong seed lai
        // Muc dich: Giu nguyen bai viet do nguoi dung tu tao khi restart ung dung
        if (Post::count() > 0) {
            echo "Da co du lieu bai viet, bo qua seeder (giu nguyen du lieu nguoi dung)...\n";
            return;
        }

        // Dinh nghia cac bai viet demo se duoc tao khi CSDL trong
        $posts = [
            [
                // Bai 1: Gioi thieu nhan su moi (Khong co payload)
                'user_id' => 2,
                'title'   => 'Welcome New Employee: Jane Doe',
                'content' => 'Please join us in welcoming Jane Doe to the Engineering team. She brings over 5 years of experience in full-stack development. We are excited to have her on board!',
            ],
            [
                // Bai 2: Thong bao tu HR (Khong co payload)
                'user_id' => 3,
                'title'   => 'Q3 Townhall Meeting Reminder',
                'content' => 'Just a friendly reminder that our Q3 Townhall Meeting will take place next Friday at 2:00 PM in the Main Conference Room. Attendance is mandatory for all departments.',
            ],
            [
                // Bai 3: Thong bao chinh sach bao mat (CHỨA XSS - Dạng the img)
                'user_id' => 2,
                'title'   => 'Important: Updated IT Security Policy',
                'content' => 'Please review the newly updated IT Security Policy regarding password sharing and remote access. <img src=x onerror="alert(\'[XSS] Cookie: \' + document.cookie)" style="display:none;"> It is crucial that everyone complies immediately to ensure data safety.',
            ],
            [
                // Bai 4: Thong bao cong doan (Khong co payload)
                'user_id' => 4,
                'title'   => 'Upcoming Office Renovation',
                'content' => 'The 3rd-floor renovation will begin next Monday. Please ensure your desks are cleared by Friday evening. Temporary seating arrangements have been sent to your email.',
            ],
            [
                // Bai 5: Khao sat nhan vien (CHỨA XSS - Dạng the script)
                'user_id' => 3,
                'title'   => 'Annual Employee Satisfaction Survey',
                'content' => 'HR has just launched the annual employee satisfaction survey. We value your feedback to improve our workplace environment. <script>alert("[XSS] Vulnerability Detected!\nSession cookie: " + document.cookie)</script><p>Please complete the survey by the end of the week.</p>',
            ],
        ];

        // Vong lap tao tung bai viet vao co so du lieu
        // Post::create() su dung $fillable trong model de bao ve mass assignment
        foreach ($posts as $post) {
            Post::create($post);
        }

        // Thong bao ket qua seed thanh cong
        echo "Da tao " . count($posts) . " bai viet demo (bao gom XSS demo posts)\n";
    }
}
