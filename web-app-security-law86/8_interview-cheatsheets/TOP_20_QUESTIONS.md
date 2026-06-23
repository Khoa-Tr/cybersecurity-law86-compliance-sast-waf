# 🎤 TOP 20 INTERVIEW QUESTIONS
# Web Application Security & Law 86/2025

---

## PHẦN 1: VULNERABILITIES (OWASP Top 10)

### Q1: SQL Injection là gì? Làm sao detect và fix?

**A:** SQL Injection xảy ra khi user input được đưa trực tiếp vào SQL query không qua sanitization.

**Detect:**
- SonarQube rule: php:S3649
- Manual: Test với payload `admin' OR '1'='1' --`
- Tools: SQLMap, Burp Suite

**Fix:**
```php
// ❌ Vulnerable
$query = "SELECT * FROM users WHERE username = '$username'";

// ✅ Fixed - Parameterized query
$user = DB::table('users')->where('username', $username)->first();
```

**Law 86/2025 mapping:** Điều 24 - Bảo vệ hệ thống thông tin

---

### Q2: XSS là gì? Phân biệt Stored vs Reflected?

**A:**
- **Stored XSS**: Script lưu vào DB, execute khi người khác xem
- **Reflected XSS**: Script trong URL, execute ngay lập tức
- **DOM XSS**: Script thao túng DOM client-side

**Fix:**
```php
// Blade template - auto-escaped
{{ $content }}  // ✅ Safe

// PHP
$safe = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
```

---

### Q3: CSRF là gì? WAF có block được không?

**A:** CSRF (Cross-Site Request Forgery) - kẻ tấn công lừa browser gửi request thay mặt user.

**WAF không đủ** - vì CSRF request có credentials hợp lệ.

**Fix đúng:**
```blade
<form method="POST">
    @csrf  {{-- Laravel CSRF token --}}
</form>
```

---

### Q4: IDOR là gì? Ví dụ thực tế?

**A:** IDOR (Insecure Direct Object Reference) - ứng dụng expose reference đến internal object mà không verify authorization.

**Ví dụ:**
- `/profile/1` → thay thành `/profile/999` → xem admin profile!
- `/api/orders/1234` → thay ID → xem đơn hàng của người khác

**Fix:** Always verify ownership before returning data.

---

### Q5: Hardcoded Secrets nguy hiểm thế nào?

**A:** Nếu code lên GitHub public:
- Attackers có thể tìm secrets bằng Google Dork hoặc tools như `truffleHog`
- Compromise database, AWS, payment processor
- CRITICAL severity vì impact cao và detection dễ

**Fix:** Environment variables + `.gitignore .env`

---

## PHẦN 2: TOOLS & TECHNOLOGIES

### Q6: SonarQube làm gì? Tại sao dùng?

**A:** SonarQube là Static Application Security Testing (SAST) tool:
- Phân tích source code để tìm vulnerabilities
- Rules: 2000+ security rules
- Báo cáo: Critical/High/Medium/Low
- CI/CD integration

**Trong project:** Phát hiện 27 issues, 5 Critical

---

### Q7: ModSecurity WAF hoạt động thế nào?

**A:** ModSecurity là open-source WAF:
1. Kiểm tra mọi HTTP request/response
2. So sánh với OWASP CRS rules
3. Block nếu match rule
4. Log attack attempts

**Block rate trong project:** 93.75% (30/32 attacks)

---

### Q8: OWASP CRS là gì?

**A:** Core Rule Set - bộ rules bảo vệ chống:
- SQLi (Rule 941xxx)
- XSS (Rule 941xxx)
- Path traversal (Rule 930xxx)
- PHP injection (Rule 932xxx)
- Remote file inclusion (Rule 931xxx)

---

## PHẦN 3: PENETRATION TESTING

### Q9: Penetration Testing methodology của bạn là gì?

**A:** Theo PTES (Penetration Testing Execution Standard):
1. **Reconnaissance** - Thu thập thông tin
2. **Scanning** - Nmap, vulnerability scanners
3. **Exploitation** - Khai thác lỗ
4. **Post-exploitation** - Lateral movement
5. **Reporting** - Viết báo cáo chi tiết

---

### Q10: Khác biệt giữa Black/White/Gray box testing?

**A:**
- **Black box**: Không có source code → thực tế nhất
- **White box**: Có full source code → thorough nhất
- **Gray box**: Có partial knowledge → balanced

**Project này:** White box (có source code để hiểu vulnerabilities)

---

## PHẦN 4: LAW 86/2025 COMPLIANCE

### Q11: Luật 86/2025 yêu cầu gì về bảo mật web app?

**A:**
- **Điều 23**: Bảo vệ dữ liệu cá nhân (PII protection, encryption)
- **Điều 24**: Bảo vệ hệ thống (authentication, input validation)
- **Điều 25**: Audit logging (12 months retention)
- **Điều 26**: Incident response (24h notification)

---

### Q12: Tại sao project đạt 100% compliance?

**A:** Vì đã implement đủ controls:
- IDOR fix → Điều 23 (data protection)
- SQLi/XSS fix + WAF → Điều 24 (system security)
- ModSecurity + Laravel logs → Điều 25 (audit)
- IRP document + backups → Điều 26 (incident response)

---

## PHẦN 5: TECHNICAL DEEP DIVE

### Q13: Explain defense in depth trong context này?

**A:** Multiple layers:
1. **Network layer**: Firewall, VPN
2. **WAF layer**: ModSecurity blocks attacks
3. **Application layer**: Input validation, output escaping
4. **Database layer**: Parameterized queries, encryption
5. **Logging layer**: Audit trails for detection

---

### Q14: Giải thích SameSite cookie?

**A:**
- `SameSite=Strict`: Cookie không gửi trong cross-site requests (an toàn nhất)
- `SameSite=Lax`: Cookie gửi khi navigate to site (default Chrome)
- `SameSite=None`: Cookie gửi trong tất cả requests (cần Secure flag)

Prevents CSRF attacks.

---

### Q15: Tại sao không dùng MD5/SHA1 cho password?

**A:**
- MD5/SHA1: Fast hash → dễ brute force
- **bcrypt/Argon2**: Slow hash + salt → resistant to rainbow tables
- Cost factor trong bcrypt: tăng computational cost
- PHP: `password_hash($password, PASSWORD_BCRYPT)`

---

### Q16: Giải thích Content Security Policy (CSP)?

**A:** HTTP header chỉ định nguồn content được phép load:
```
Content-Security-Policy: 
  default-src 'self';
  script-src 'self' cdn.example.com;
  img-src 'self' data:;
```
Prevents XSS vì inline scripts bị block.

---

### Q17: HSTS là gì và tại sao cần thiết?

**A:** HTTP Strict Transport Security:
```
Strict-Transport-Security: max-age=31536000; includeSubDomains
```
- Browser tự động dùng HTTPS
- Prevents SSL stripping attacks
- Cached 1 năm (max-age)

---

### Q18: Session Fixation vs Session Hijacking?

**A:**
- **Session Fixation**: Attacker set session ID trước khi auth
- **Session Hijacking**: Attacker steal session ID sau khi auth

**Fix:**
```php
session_regenerate_id(true);  // After successful login
```

---

### Q19: Giải thích JWT và các vấn đề bảo mật?

**A:** JSON Web Token gồm header.payload.signature

**Vấn đề:**
- Không expire → stolen token valid forever → dùng short expiry
- Algorithm confusion: alg=none attack → always validate algorithm
- Sensitive data in payload → payload không encrypt

---

### Q20: Describe WAF bypass techniques và cách mitigate?

**A:** Common bypasses:
- Encoding: `%3Cscript%3E` URL-encode
- Case mixing: `<ScRiPt>`
- Double encoding: `%253Cscript%253E`
- Null bytes: `<?php/**/system()`

**Mitigate:** Enable URL decode + normalize rules in ModSecurity + depth scanning

---

## 🎯 Key Numbers to Remember

| Metric | Value |
|--------|-------|
| Vulnerabilities found | 27 |
| Critical issues | 5 |
| WAF block rate | 93.75% |
| Risk reduction | 86.9% |
| Compliance coverage | 100% |
| Risk score before | 9.2/10 |
| Risk score after | 2.1/10 |
