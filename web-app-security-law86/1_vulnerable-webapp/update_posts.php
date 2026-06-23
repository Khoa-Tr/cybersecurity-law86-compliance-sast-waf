<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Post;

Post::truncate();

$posts = [
    [
        'user_id' => 2,
        'title'   => 'Welcome New Employee: Jane Doe',
        'content' => 'Please join us in welcoming Jane Doe to the Engineering team. She brings over 5 years of experience in full-stack development. We are excited to have her on board!',
    ],
    [
        'user_id' => 3,
        'title'   => 'Q3 Townhall Meeting Reminder',
        'content' => 'Just a friendly reminder that our Q3 Townhall Meeting will take place next Friday at 2:00 PM in the Main Conference Room. Attendance is mandatory for all departments.',
    ],
    [
        'user_id' => 2,
        'title'   => 'Important: Updated IT Security Policy',
        'content' => 'Please review the newly updated IT Security Policy regarding password sharing and remote access. <img src=x onerror="alert(\'[XSS] Cookie: \' + document.cookie)" style="display:none;"> It is crucial that everyone complies immediately to ensure data safety.',
    ],
    [
        'user_id' => 4,
        'title'   => 'Upcoming Office Renovation',
        'content' => 'The 3rd-floor renovation will begin next Monday. Please ensure your desks are cleared by Friday evening. Temporary seating arrangements have been sent to your email.',
    ],
    [
        'user_id' => 3,
        'title'   => 'Annual Employee Satisfaction Survey',
        'content' => 'HR has just launched the annual employee satisfaction survey. We value your feedback to improve our workplace environment. <script>alert("[XSS] Vulnerability Detected!\nSession cookie: " + document.cookie)</script><p>Please complete the survey by the end of the week.</p>',
    ],
];

foreach ($posts as $post) {
    Post::create($post);
}

echo "Posts updated successfully!\n";

