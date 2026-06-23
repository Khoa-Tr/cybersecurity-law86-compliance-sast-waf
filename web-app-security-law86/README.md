# 🛡️ Đồ án Bảo mật Ứng dụng Web & Tuân thủ Luật 86/2025

**Tên đề tài:** Bảo vệ Ứng dụng Web tuân thủ Luật An toàn thông tin mạng 86/2025 bằng SonarQube và Web Application Firewall (WAF)  
**Đối tượng hướng đến:** Sinh viên ngành An toàn thông tin, Kỹ sư bảo mật, Penetration Testers  
**Mức độ:** Nâng cao (Advanced)

---

## 📌 1. TỔNG QUAN ĐỒ ÁN (PROJECT OVERVIEW)

Đồ án này là một hệ thống mô phỏng toàn diện quy trình bảo mật một ứng dụng Web trong thực tế, đặc biệt nhấn mạnh vào việc tuân thủ các quy định khắt khe của **Luật An toàn thông tin mạng 86/2025** của Việt Nam. 

Dự án bao gồm sự kết hợp của nhiều thành phần:
1. **NexusHR Enterprise SaaS:** Một ứng dụng web nhân sự (HRM) mô phỏng môi trường doanh nghiệp viết bằng Laravel cố tình chứa các lỗ hổng bảo mật phổ biến (SQLi, XSS, CSRF, IDOR).
2. **Code Analysis (SonarQube):** Quét mã nguồn tự động để phát hiện sớm lỗ hổng (Shift-left security).
3. **Web Application Firewall (WAF):** Triển khai ModSecurity với bộ rule OWASP CRS để chặn tấn công từ bên ngoài.
4. **Luật 86/2025 Compliance:** Hệ thống tài liệu chứng minh sự tuân thủ pháp luật về bảo mật dữ liệu và an toàn hệ thống.

### 🎯 Mục tiêu đồ án:
- ✅ **Tấn công (Red Team):** Tìm và khai thác thành công các lỗ hổng OWASP Top 10.
- ✅ **Phòng thủ (Blue Team):** Khắc phục lỗi trong mã nguồn (Secure Code) và triển khai WAF.
- ✅ **Kiểm toán (Audit):** Sử dụng SonarQube để quét và đánh giá chất lượng code.
- ✅ **Tuân thủ pháp luật (Compliance):** Áp dụng trực tiếp Luật 86/2025 vào thực tế doanh nghiệp.

---

## 📋 2. CẤU TRÚC THƯ MỤC (PROJECT STRUCTURE)

Dự án được chia thành các phân hệ rõ ràng:

```text
web-app-security-law86/
├── 📁 1_vulnerable-webapp/     # Source code Laravel chứa lỗ hổng bảo mật (SQLi, XSS, IDOR...)
├── 📁 2_sonarqube-setup/       # Cấu hình SonarQube để quét mã nguồn tự động
├── 📁 3_waf-deployment/        # Cấu hình Web Application Firewall (Nginx + ModSecurity)
├── 📁 4_compliance/            # Các tài liệu phân tích và chứng minh tuân thủ Luật 86/2025
├── 📁 5_penetration-testing/   # Kịch bản tấn công (Pentest) và báo cáo đánh giá
├── 📁 6_automation/            # Các bash script tự động hóa (setup, scan, test)
├── 📁 7_demo-video-scripts/    # Kịch bản quay video demo/thuyết trình
├── 📁 8_interview-cheatsheets/ # Bộ câu hỏi Q&A dùng để bảo vệ đồ án/phỏng vấn
├── LUAT_86_2025_VA_DO_AN.md    # Tài liệu giải thích chi tiết Luật 86/2025
└── README.md                   # Tài liệu tổng quan (file này)
```

---

## 🚀 3. HƯỚNG DẪN CÀI ĐẶT NHANH (QUICK START)

### Yêu cầu hệ thống (Prerequisites)
- Docker & Docker Compose
- Hệ điều hành: Linux/macOS hoặc Windows (sử dụng WSL2)
- RAM: Tối thiểu 8GB (khuyên dùng để chạy SonarQube mượt mà)

### Các bước khởi chạy
**Bước 1:** Di chuyển vào thư mục ứng dụng web và khởi chạy
```bash
cd C:\Users\ACER\Downloads\files\web-app-security-law86\1_vulnerable-webapp
docker-compose up -d --build
```

**Bước 2:** Truy cập ứng dụng
- **Web App Chính:** `http://localhost:8000`
- **phpMyAdmin:** `http://localhost:8080` (Tài khoản: root/root123)
- **Tài khoản test Web:** 
  - Admin: `admin` / `AdminPass2024!`
  - User: `john` / `JohnPass123`

---

## 🔐 4. DANH SÁCH LỖ HỔNG (VULNERABILITIES)

Ứng dụng chứa sẵn các lỗ hổng cực kỳ nguy hiểm để bạn thử nghiệm tấn công (Pentest).

| ID | Tên lỗ hổng | File chứa lỗi | Mức độ | CWE |
|----|-------------|---------------|--------|-----|
| 1 | **SQL Injection** | `LoginController.php` | CRITICAL | CWE-89 |
| 2 | **Stored XSS** | `PostController.php` | HIGH | CWE-79 |
| 3 | **IDOR** | `ProfileController.php` | HIGH | CWE-639 |
| 4 | **Missing CSRF Token** | `bootstrap/app.php` | MEDIUM | CWE-352 |

> ⚠️ **CẢNH BÁO:** Đây là các lỗ hổng **CỐ Ý** được tạo ra cho mục đích giáo dục. Tuyệt đối không bê mã nguồn này deploy lên môi trường Production thực tế nếu chưa fix lỗi.

---

## 🛡️ 5. QUY TRÌNH KHẮC PHỤC & BẢO VỆ (REMEDIATION)

Đồ án đưa ra giải pháp bảo vệ **"Phòng thủ chiều sâu" (Defense in Depth)** với 2 lớp:

### Lớp 1: Bảo vệ vòng ngoài bằng WAF (ModSecurity)
- Chặn đứng các payload tấn công độc hại ngay từ khi chạm đến server (chưa kịp vào code).
- Ghi log chi tiết lại toàn bộ IP và kịch bản của kẻ tấn công (Phục vụ Điều 25 - Luật 86).

### Lớp 2: Bảo vệ vòng trong bằng Secure Code
- **Sửa SQLi:** Chuyển sang sử dụng ORM (Eloquent) / Prepared Statements.
- **Sửa XSS:** Dùng Blade tags `{{ }}` để tự động escape ký tự HTML.
- **Sửa IDOR:** Thêm kiểm tra phân quyền (Authorization Checks) trong các controller nhạy cảm.

---

## ⚖️ 6. TUÂN THỦ LUẬT 86/2025 (COMPLIANCE MATRIX)

Hệ thống được thiết kế khớp hoàn toàn với các điều khoản của **Luật 86/2025**:

- **✅ Điều 23 (Bảo mật dữ liệu cá nhân):** Sửa lỗi IDOR, ẩn thông tin PII, dùng HTTPS.
- **✅ Điều 24 (Bảo vệ hệ thống):** Ngăn chặn SQLi/XSS, thiết lập WAF, băm mật khẩu chuẩn (Bcrypt).
- **✅ Điều 25 (Kiểm toán An toàn thông tin):** Quét mã nguồn bằng SonarQube, thu thập Audit Logs từ WAF.
- **✅ Điều 26 (Khôi phục sự cố):** Đóng gói Docker Compose cho phép khôi phục toàn bộ hệ thống sau thảm họa (Disaster Recovery).

---

## 🎬 7. CÁC KỊCH BẢN DEMO ĐỀ XUẤT (USAGE SCENARIOS)

Khi thuyết trình đồ án, bạn có thể demo theo các luồng sau:
1. **Demo Tấn công SQL Injection:** Bypass màn hình đăng nhập hệ thống nội bộ bằng kịch bản `admin' OR '1'='1' --` trên trường Corporate Employee ID.
2. **Demo Tấn công XSS & IDOR:** Ăn cắp cookie người dùng thông qua form "Employee Feedback" hoặc xem trộm hồ sơ lương (Payslip) cực kỳ nhạy cảm của Giám đốc (Admin) bằng IDOR.
3. **Demo SonarQube:** Show báo cáo quét mã nguồn của SonarQube chỉ ra chính xác dòng code bị lỗi.
4. **Demo WAF Blocking:** Bật WAF lên và thực hiện lại bước 1 & 2 thông qua cổng 80. Show cho Hội đồng thấy Web Server trả về lỗi `403 Forbidden` và payload độc hại đã bị chặn ngay lập tức.
