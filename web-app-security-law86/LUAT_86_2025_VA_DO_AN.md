# 📜 TỔNG QUAN VỀ LUẬT AN TOÀN THÔNG TIN MẠNG SỐ 86/2025 VÀ SỰ LIÊN QUAN ĐẾN ĐỒ ÁN

Tài liệu này giải thích tóm tắt về Luật 86/2025 và lý do tại sao đồ án này được thiết kế dựa trên tiêu chuẩn của Luật này. Đây là tài liệu rất hữu ích để bạn bảo vệ đồ án hoặc trả lời phỏng vấn.

---

## 1️⃣ LUẬT 86/2025 LÀ GÌ?

**Luật An toàn Thông tin Mạng số 86/2025** là hành lang pháp lý mới nhất của Việt Nam (do Bộ TTTT ban hành, áp dụng từ 2025) nhằm bắt buộc các tổ chức, doanh nghiệp phải có các biện pháp kỹ thuật cụ thể để bảo vệ hệ thống thông tin và dữ liệu người dùng. 

Nếu như trước đây, các công ty chỉ bị phạt khi để mất dữ liệu, thì với Luật 86/2025, họ bắt buộc phải **chứng minh được mình có hệ thống bảo mật đạt chuẩn** (Mã hóa, Tường lửa, Audit Log, Backup) ngay cả khi chưa bị tấn công.

---

## 2️⃣ TẠI SAO LUẬT NÀY LIÊN QUAN ĐẾN ĐỒ ÁN?

Đồ án này không chỉ đơn thuần là "tìm và sửa lỗi web", mà nó là một **Case Study (Bài toán thực tế)** mô phỏng quá trình một doanh nghiệp nâng cấp hệ thống từ mức **"Không tuân thủ pháp luật"** (Vulnerable Web App) lên mức **"Tuân thủ hoàn toàn Luật 86/2025"** bằng cách áp dụng các công cụ bảo mật chuyên nghiệp (WAF, SonarQube, Secure Code).

Việc gắn đồ án với Luật 86/2025 giúp đồ án có giá trị thực tiễn rất cao, chứng minh bạn không chỉ biết hack hay code, mà còn hiểu về quy trình Compliance (Tuân thủ bảo mật) - một kỹ năng cực kỳ đắt giá trong ngành CyberSecurity.

---

## 3️⃣ SỰ LIÊN KẾT CHI TIẾT GIỮA ĐỒ ÁN VÀ LUẬT 86/2025

Đồ án giải quyết trực tiếp 4 điều khoản quan trọng nhất của Luật:

### 🛡️ 1. Điều 23: Bảo vệ Thông tin Cá nhân (Data Privacy)
- **Yêu cầu của Luật:** Không được để lộ thông tin nhạy cảm của người dùng (CMND, SĐT, Email).
- **Cách đồ án giải quyết:** 
  - Khắc phục lỗ hổng **IDOR** trong `ProfileController` để người dùng không thể xem trộm thông tin của nhau.
  - Sử dụng HTTPS/Mã hóa dữ liệu.

### 🔐 2. Điều 24: Bảo vệ Hệ thống Thông tin (System Security)
- **Yêu cầu của Luật:** Hệ thống phải chống lại được các cuộc tấn công mạng cơ bản, phải có cơ chế xác thực an toàn.
- **Cách đồ án giải quyết:**
  - Sửa lỗi **SQL Injection** trong trang đăng nhập (Sử dụng Prepared Statement/Eloquent).
  - Sửa lỗi **XSS** và **CSRF** trong tính năng đăng bài viết.
  - Mã hóa mật khẩu an toàn (thay thế mã hóa yếu hoặc plain-text bằng Bcrypt/Hash an toàn).
  - **Triển khai WAF (Web Application Firewall - ModSecurity):** Chặn đứng các payload tấn công tự động từ bên ngoài.

### 🕵️‍♂️ 3. Điều 25: Kiểm toán và Giám sát An toàn (Audit & Monitoring)
- **Yêu cầu của Luật:** Phải ghi nhận lại (Log) mọi hoạt động truy cập và tấn công để truy vết khi có sự cố.
- **Cách đồ án giải quyết:**
  - Tích hợp **ModSecurity Audit Logs**: Ghi lại toàn bộ các request tấn công độc hại bị WAF chặn.
  - Tích hợp **SonarQube**: Quét mã nguồn tự động để kiểm toán và phát hiện lỗ hổng trước khi triển khai (Shift-left security).

### 🔄 4. Điều 26: Khôi phục và Đề phòng Sự cố (Disaster Recovery)
- **Yêu cầu của Luật:** Phải có cơ chế khôi phục dữ liệu và cô lập hệ thống khi bị tấn công.
- **Cách đồ án giải quyết:**
  - Ứng dụng được đóng gói hoàn toàn bằng **Docker (Containerization)**, giúp cô lập môi trường và dễ dàng khôi phục/khởi động lại toàn bộ hệ thống sạch trong vài giây nếu bị tấn công sập.

---

## 4️⃣ TỔNG KẾT: GIÁ TRỊ CỦA ĐỒ ÁN

Nhờ việc tuân thủ Luật 86/2025, hệ thống trong đồ án đã:
1. Chuyển từ trạng thái **Rủi ro Cao (Critical Risk)** với 27 lỗ hổng (điểm CVSS 9.8).
2. Trở thành một hệ thống **An toàn (Low Risk)**: Bị chặn đứng tấn công bởi WAF từ vòng ngoài, và mã nguồn được fix triệt để ở vòng trong.
3. Có đầy đủ bằng chứng (SonarQube Report, WAF Logs) để chứng minh tính tuân thủ pháp luật.

Đây chính là kịch bản mà mọi doanh nghiệp tại Việt Nam đều sẽ phải thực hiện từ năm 2025!
