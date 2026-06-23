# 🔧 HARDENING GUIDE / HƯỤNG DẪN TĂNG CƯỜNG BẢO MẬT
# Web Application Security - Law 86/2025
# Bảo mật Ứng dụng Web - Luật 86/2025

## Phase 1: Code-Level Fixes / Khắc phục mức mã nguồn

### 1.1 Fix SQL Injection

```php
// ❌ VULNERABLE
$query = "SELECT * FROM users WHERE username = '$username'";

// ✅ FIXED - Use Eloquent ORM
$user = User::where('username', $username)->first();

// ✅ FIXED - Raw with bindings
$user = DB::select('SELECT * FROM users WHERE username = ?', [$username]);
```

### 1.2 Fix XSS

```php
// ❌ VULNERABLE (in Blade template)
{!! $post->content !!}

// ✅ FIXED - Auto-escaped
{{ $post->content }}

// ✅ FIXED - Explicit sanitization
$content = strip_tags($request->input('content'));
$content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
```

### 1.3 Fix IDOR

```php
// ❌ VULNERABLE
public function show($userId) {
    return User::find($userId);
}

// ✅ FIXED
public function show($userId) {
    $user = User::findOrFail($userId);
    if (auth()->id() !== $user->id && !auth()->user()->isAdmin()) {
        abort(403, 'Unauthorized');
    }
    return view('profile', ['user' => $user->only(['name', 'email'])]);
}
```

### 1.4 Fix Hardcoded Secrets

```php
// ❌ VULNERABLE
'password' => 'RootPass123!',

// ✅ FIXED
'password' => env('DB_PASSWORD'),
```

### 1.5 Enable CSRF

```blade
{{-- In every form --}}
<form method="POST" action="/posts">
    @csrf
    <input type="text" name="content">
    <button type="submit">Submit</button>
</form>
```

---

## Phase 2: WAF Configuration / Cấu hình Tường lửa WAF

```bash
# Deploy WAF / Triển khai WAF
cd C:\Users\ACER\Downloads\files\web-app-security-law86\3_waf-deployment
docker-compose up -d

# Verify WAF is blocking attacks / Kiểm tra WAF đang chặn tấn công
bash 6_automation/run-waf-tests.sh

# Expected / Kết quả mong đợi: 90%+ block rate
```

---

## Phase 3: Infrastructure Hardening / Gia cố hạ tầng

### Security Headers (Nginx) / Tiêu đề bảo mật (Nginx)

```nginx
add_header X-Frame-Options "SAMEORIGIN" always;
add_header X-Content-Type-Options "nosniff" always;
add_header X-XSS-Protection "1; mode=block" always;
add_header Content-Security-Policy "default-src 'self'" always;
add_header Strict-Transport-Security "max-age=31536000" always;
```

### Session Security (Laravel)

```php
// config/session.php
'lifetime'  => 30,
'secure'    => true,     // HTTPS only
'http_only' => true,     // No JS access
'same_site' => 'lax',   // CSRF protection
```

### Password Policy

```php
$request->validate([
    'password' => [
        'required',
        'min:12',
        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])/',
        'confirmed',
    ]
]);
```

---

## Phase 4: Monitoring & Logging

```php
// Log all authentication attempts
Log::info('Login attempt', [
    'username'   => $request->input('username'),
    'ip'         => $request->ip(),
    'user_agent' => $request->userAgent(),
    'success'    => $loginSuccess,
    'timestamp'  => now()->toISOString(),
]);
```

---

## Verification Checklist / Danh sách kiểm tra xác nhập

- [ ] SonarQube: 0 Critical issues / 0 vấn đề nghiêm trọng
- [ ] WAF: 90%+ block rate / Tỷ lệ chặn 90%+
- [ ] SSL: HTTPS enabled / Bật HTTPS
- [ ] Headers: All security headers present / Đủ các tiêu đề bảo mật
- [ ] Logging: Audit trail active / Log kiểm toán hoạt động
- [ ] CSRF: Tokens in all forms / Token CSRF trong mọi form
- [ ] IDOR: Authorization checks on all endpoints / Kiểm tra quyền trên mọi endpoint
- [ ] Secrets: No hardcoded credentials / Không có credentials cứng trong code
