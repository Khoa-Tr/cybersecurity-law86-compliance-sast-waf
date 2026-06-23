# 🏢 SECURITY POLICY / CHÍNH SÁCH BẢO MẬT
# Web Application Security - Law 86/2025 Compliance
# Bảo mật Ứng dụng Web - Tuân thủ Luật 86/2025

**Version / Phiên bản:** 1.0  
**Effective Date / Ngày hiệu lực:** 2024-12-15  
**Review Date / Ngày đánh giá lại:** 2025-06-15  

---

## 1. DATA PROTECTION POLICY / CHÍNH SÁCH BẢO VỆ DỬ LIỆU (Điều 23)

### 1.1 Data Classification / Phân loại dữ liệu
- **Confidential / Bí mật:** SSN, passwords, API keys, encryption keys
- **Sensitive / Nhạy cảm:** Email, phone, financial data / dữ liệu tài chính
- **Internal / Nội bộ:** User IDs, roles, session data
- **Public / Công khai:** Published posts, public profiles

### 1.2 Data Access Controls / Kiểm soát truy cập dữ liệu
- Access granted on least-privilege basis / Cấp quyền theo nguyên tắc ít đặc quyền nhất
- Data access logged with user ID, timestamp, action / Ghi log truy cập dữ liệu
- Regular access reviews every 90 days / Đánh giá quyền truy cập 90 ngày/lần
- Sensitive data masked in logs / Ẩn dữ liệu nhạy cảm trong log

### 1.3 Data Breach Notification / Thông báo vi phạm dữ liệu
- Detection → Confirmation: < 1 hour / < 1 giờ
- Internal escalation: < 2 hours / < 2 giờ
- Regulatory notification: < 24 hours / < 24 giờ (Luật 86/2025)
- User notification: < 72 hours / < 72 giờ

---

## 2. SYSTEM SECURITY POLICY (Điều 24)

### 2.1 Authentication Requirements
- Minimum password length: 12 characters
- Must contain: uppercase, lowercase, numbers, symbols
- Maximum age: 90 days
- Account lockout: 5 failed attempts → 15 minute lockout
- MFA: Required for admin accounts

### 2.2 Session Management
- Session timeout: 30 minutes of inactivity
- Secure cookie flags: HttpOnly, Secure, SameSite=Lax
- Session invalidation on logout
- One session per user (optional)

### 2.3 Vulnerability Management
- Weekly automated scans (SonarQube)
- Monthly penetration tests
- Critical patches: 24 hours
- High patches: 7 days
- Medium patches: 30 days

---

## 3. AUDIT LOGGING POLICY (Điều 25)

### 3.1 Events to Log
All of the following MUST be logged:
- Authentication attempts (success/failure)
- Password changes
- Profile modifications
- Admin actions
- Data exports
- WAF rule violations
- System errors

### 3.2 Log Format
```json
{
  "timestamp": "2024-12-15T10:30:45.123Z",
  "event_type": "LOGIN_ATTEMPT",
  "user_id": "12345",
  "username": "john.doe",
  "ip_address": "192.168.1.100",
  "user_agent": "Mozilla/5.0...",
  "status": "SUCCESS|FAILURE",
  "resource": "/login",
  "details": {}
}
```

### 3.3 Log Retention
- Hot storage (searchable): 3 months
- Cold storage (archived): 12 months minimum
- Audit logs MUST NOT be deleted
- Tamper-evident storage required

---

## 4. INCIDENT RESPONSE POLICY (Điều 26)

### 4.1 Incident Classification
| Level | Description | Response Time |
|-------|-------------|---------------|
| Critical | Active breach, data exposed | 1 hour |
| High | Potential compromise | 4 hours |
| Medium | Suspicious activity | 24 hours |
| Low | Policy violation | 72 hours |

### 4.2 Incident Response Steps
1. **Detect** - Identify and alert
2. **Contain** - Isolate affected systems
3. **Eradicate** - Remove threat
4. **Recover** - Restore services
5. **Document** - Write incident report
6. **Review** - Post-incident analysis

### 4.3 Backup & Recovery
- **RTO** (Recovery Time Objective): 4 hours
- **RPO** (Recovery Point Objective): 1 hour
- Daily incremental backups
- Weekly full backups
- Monthly recovery testing

---

## 5. ACCEPTABLE USE POLICY / CHÍNH SÁCH SỬ DỤNG HỢP LỆ

Users must NOT / Người dùng KHÔNG được:
- Attempt to bypass authentication / Cố gắng vượt qua xác thực
- Access other users' data / Truy cập dữ liệu người dùng khác
- Upload malicious code / Tải lên mã độc hại
- Perform unauthorized testing / Thực hiện kiểm tra không được ủy quyền
- Share credentials / Chia sẻ thông tin đăng nhập

Violations result in immediate account suspension. / Vi phạm sẽ dẫn đến đình chỉ tài khoản ngay lập tức.

---

**Approved by:** Security Team  
**Last Review:** 2024-12-15
