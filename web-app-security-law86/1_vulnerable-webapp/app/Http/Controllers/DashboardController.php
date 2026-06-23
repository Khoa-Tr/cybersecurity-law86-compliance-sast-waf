<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;

/**
 * DashboardController - Trang tong quan he thong
 *
 * Controller nay hien thi thong ke tong quat cua ung dung:
 *   - Tong so nguoi dung dang ky
 *   - Tong so bai viet trong he thong
 *   - 5 bai viet moi nhat
 *   - Danh sach tat ca nguoi dung (de demo IDOR)
 */
class DashboardController extends Controller
{
    /**
     * Hien thi trang dashboard chinh.
     *
     * Du lieu tra ve cho view:
     *   $totalUsers  - Dem tong so nguoi dung trong bang users
     *   $totalPosts  - Dem tong so bai viet trong bang posts
     *   $recentPosts - 5 bai viet moi nhat, kem thong tin nguoi dang
     *   $allUsers    - Danh sach tat ca nguoi dung (id, username, email, role)
     *                  duoc dung de hien thi bang quan ly va cac link IDOR demo
     */
    public function index(\Illuminate\Http\Request $request)
    {
        // Filter by department if provided
        $department = $request->input('department');
        $search = $request->input('search');
        
        $query = User::select('id', 'name', 'username', 'email', 'role', 'department', 'status', 'join_date', 'avatar');
        
        if ($department) {
            $query->where('department', $department);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('username', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        $allUsers = $query->get();

        // Basic metrics
        $totalUsers  = User::count();
        $totalPosts  = Post::count();
        $recentPosts = Post::with('user')->latest()->take(5)->get();

        // Advanced metrics for the HR Dashboard UI
        $newEmployees = User::where('join_date', '>=', now()->subDays(30))->count();
        $resignEmployees = User::where('status', 'Inactive')->count();
        $onLeave = 23; // Static data for UI mockup
        $newApplications = 200; // Static data for UI mockup

        // Pass data to view
        return view('dashboard', compact(
            'totalUsers', 'totalPosts', 'recentPosts', 'allUsers',
            'newEmployees', 'resignEmployees', 'onLeave', 'newApplications', 'department'
        ));
    }

    /**
     * Xuat danh sach nhan vien ra file CSV
     */
    public function exportCsv(\Illuminate\Http\Request $request)
    {
        $department = $request->input('department');
        $search = $request->input('search');

        $query = User::select('id', 'name', 'username', 'email', 'role', 'department', 'status', 'join_date');
        
        if ($department) {
            $query->where('department', $department);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('username', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        $users = $query->get();

        $filename = "employees_export_" . date('Ymd_His') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Name', 'Username', 'Email', 'Role', 'Department', 'Status', 'Join Date'];

        $callback = function() use($users, $columns) {
            $file = fopen('php://output', 'w');
            // Ghi BOM de file CSV hien thi tieng Viet tot tren Excel
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->username,
                    $user->email,
                    $user->role,
                    $user->department,
                    $user->status,
                    $user->join_date
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
