# 🎯 OWASP Top 10 - 2021 Coverage
# 🎯 Phạm vi OWASP Top 10 - 2021
# Mapping project vulnerabilities to OWASP categories
# Ánh xạ các lỗ hổng dự án vào các danh mục OWASP

## OWASP Top 10 2021 Coverage Matrix / Bảng phủ sóng

| OWASP Category / Danh mục | Covered / Đã phủ | Vulnerability / Lỗ hổng | Status / Trạng thái |
|----------------|---------|---------------|--------|
| A01: Broken Access Control / Kiểm soát truy cập bị phá | ✅ | IDOR in ProfileController | Đã sửa (Fixed) |
| A02: Cryptographic Failures / Lỗi mã hóa | ✅ | Hardcoded secrets, Weak hash | Đã sửa (Fixed) |
| A03: Injection / Chèn mã độc | ✅ | SQL Injection (Login), XSS (Posts) | Đã sửa (Fixed) |
| A04: Insecure Design / Thiết kế không an toàn | ✅ | Missing auth checks, no rate limiting | Đã ghi chú (Documented) |
| A05: Security Misconfiguration / Cấu hình sai | ✅ | DEBUG=true, exposed DB port | Đã sửa (Fixed) |
| A06: Vulnerable Components / Thành phần lỗi thời | ⚠️ | Dependency scanning not included | Một phần (Partial) |
| A07: Auth & Session Failures / Xác thực thất bại | ✅ | CSRF, Weak session management | Đã sửa (Fixed) |
| A08: Integrity Failures / Vi phạm toàn vẹn | ✅ | Insecure deserialization | Đã ghi chú (Documented) |
| A09: Logging Failures / Lỗi ghi log | ✅ | No audit logs → WAF logging | Đã sửa (Fixed) |
| A10: SSRF | ⚠️ | Not tested in this scope | Một phần (Partial) |

**Coverage: 8/10 fully covered, 2/10 partially / Phủ sóng: 8/10 đầy đủ, 2/10 một phần**

---

## Detailed Analysis

### A01: Broken Access Control (IDOR)

**Vulnerability:**
```
GET /profile/2    → Returns user 2's data (your own - OK)
GET /profile/999  → Returns admin data (IDOR - NOT OK!)
```

**Fix:**
```php
if (auth()->id() !== $user->id) abort(403);
```

**WAF rule:** ModSecurity rule 7001 - Missing auth headers detection

---

### A02: Cryptographic Failures

**Vulnerability:**
- Hardcoded API keys in source code
- Passwords stored with MD5 (not bcrypt)
- HTTP instead of HTTPS

**Fix:**
- Use environment variables for secrets
- `password_hash($pwd, PASSWORD_BCRYPT, ['cost' => 12])`
- Force HTTPS via Nginx + HSTS header

---

### A03: Injection (SQL + XSS)

**SQL Injection:**
- Payload: `admin' OR '1'='1' --`
- Impact: Auth bypass, data extraction

**XSS:**
- Payload: `<script>alert('XSS')</script>`
- Impact: Session hijacking, data theft

---

### A07: Auth & Session Failures (CSRF)

**Vulnerability:** POST requests without CSRF token
**Exploit:** Malicious site auto-submits form with victim's cookies
**Fix:** `@csrf` in all Laravel forms

---

### A08: Insecure Deserialization

**Potential vulnerability:**
```php
$data = unserialize($userInput);  // Remote Code Execution!
```

**Fix:**
```php
$data = json_decode($userInput, true);  // Safe alternative
```

---

## Test Evidence / Bằng chứng kiểm tra

### SQL Injection Test / Kiểm tra SQL Injection
```
Công cụ: OWASP ZAP (Active Scan) + Burp Suite Repeater
Request: POST /login username=admin' OR '1'='1' --
Before WAF / Trước WAF: HTTP 200 (Login bypass success! / Bỏ qua đăng nhập thành công!)
After WAF / Sau WAF:  HTTP 403 (Blocked by ModSecurity rule 1001 / Bị chặn bởi luật 1001)
```

### XSS Test / Kiểm tra XSS
```
Công cụ: OWASP ZAP (Active Scan) + Burp Suite Repeater
Request: POST /posts content=<script>alert(1)</script>
Before WAF / Trước WAF: HTTP 201 (Stored in DB - executes on view / Lưu vào DB - thực thi khi xem)
After WAF / Sau WAF:  HTTP 403 (Blocked by ModSecurity rule 2001 / Bị chặn bởi luật 2001)
```

### IDOR Test / Kiểm tra IDOR
```
Công cụ: Burp Suite Repeater (thay ID thủ công)
Request: GET /profile/1 (as user ID: 5 / với user ID: 5)
Before fix / Trước sửa: HTTP 200 (Returns admin profile! / Trả về profile admin!)
After fix / Sau sửa:  HTTP 403 (Unauthorized access / Truy cập không được phép)
```
