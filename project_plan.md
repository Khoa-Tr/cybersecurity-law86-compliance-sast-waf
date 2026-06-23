# 📋 DỰ ÁN HOÀN THIỆN: BẢO VỆ ỨNG DỤNG WEB TUÂN THỦ LUẬT 86/2025

## 🎯 MỤC TIÊU DỰ ÁN
- Xây dựng ứng dụng web có lỗ bảo mật (intentional)
- Scan code bằng SonarQube → phát hiện lỗ
- Deploy WAF → bảo vệ app
- Chứng minh tuân thủ Luật 86/2025
- Tạo portfolio cho pentest/SOC/ATTT

---

## 📅 LỊCH TRÌNH THỰC HIỆN (6 TUẦN)

### **TUẦN 1: KHỞI ĐỘNG & SETUP INFRASTRUCTURE**

#### Công việc:
- [ ] Khởi tạo Git repository
- [ ] Cài đặt Docker & công cụ cần thiết
- [ ] Setup SonarQube (local/docker)
- [ ] Tạo cấu trúc folder project
- [ ] Viết README phiên bản v1

#### Deliverables:
```
GitHub repo: /web-app-security-law86
├── docker-compose.yml (SonarQube + PostgreSQL)
├── .gitignore
├── README.md (overview)
└── SETUP.md (cách chạy project)
```

#### Công cụ cài đặt:
- Docker & Docker Compose
- SonarQube Community Edition
- Git
- Postman (API testing)
- OWASP ZAP

---

### **TUẦN 2: PHÁT TRIỂN VULNERABLE WEBAPP**

#### Công việc:
- [ ] Tạo PHP/Laravel app đơn giản
- [ ] Cài đặt lỗ bảo mật intentional (OWASP Top 10)
- [ ] Tạo database mẫu
- [ ] Viết test cases khai thác lỗ

#### Lỗ bảo mật cần có (6 lỗ chính):
1. **SQL Injection** - Login form
2. **XSS (Stored + Reflected)** - Comments/Posts
3. **CSRF** - Form submission
4. **IDOR** - User profile access
5. **Hardcoded Secrets** - Database credentials in code
6. **Insecure Deserialization** - File upload

#### Deliverables:
```
webapp/
├── app/
│   ├── Controllers/
│   │   ├── LoginController.php (SQL Injection)
│   │   ├── PostController.php (XSS)
│   │   └── ProfileController.php (IDOR)
│   ├── Models/
│   ├── Middleware/
│   └── Views/
├── routes/
├── database/
│   ├── migrations/
│   └── seeders/ (sample data)
├── public/
├── docker-compose.yml (app setup)
└── .env.example
```

#### File cần tạo:
- `webapp/docker-compose.yml` (PHP 8 + MySQL)
- `webapp/.env` (với hardcoded secrets)
- `webapp/README.md` (vulnerability guide)

---

### **TUẦN 3: SONARQUBE SCANNING & ANALYSIS**

#### Công việc:
- [ ] Cấu hình SonarQube project
- [ ] Cài sonar-scanner
- [ ] Chạy scan code webapp
- [ ] Phân tích hasil scan
- [ ] Tạo report chi tiết
- [ ] Ghi chú các issues

#### Deliverables:
```
sonarqube-setup/
├── docker-compose.yml (SonarQube setup)
├── sonar-project.properties (scanner config)
├── SONAR_SETUP.md (hướng dẫn)
├── VULNERABILITY_REPORT.md
│   ├── Critical Issues (5)
│   ├── Major Issues (12)
│   ├── Minor Issues (8)
│   └── Remediation plan
└── screenshots/
    ├── sonarqube_dashboard.png
    ├── code_smells.png
    └── vulnerabilities_chart.png
```

#### SonarQube Issues cần capture:
- SQL Injection vulnerability
- XSS vulnerability
- Hardcoded credentials
- Missing input validation
- Insecure cipher algorithms

---

### **TUẦN 4: WAF DEPLOYMENT & CONFIGURATION**

#### Công việc:
- [ ] Chọn WAF (ModSecurity + Apache/Nginx)
- [ ] Config OWASP ModSecurity Core Rule Set (CRS)
- [ ] Deploy WAF trước webapp
- [ ] Test WAF blocks
- [ ] Tune false positives
- [ ] Tạo WAF logs & analytics

#### Deliverables:
```
waf-deployment/
├── docker-compose.yml (Nginx + ModSecurity)
├── nginx-config/
│   ├── nginx.conf
│   ├── modsecurity.conf
│   └── rules/ (OWASP CRS)
├── WAF_RULES.md
│   ├── SQL Injection Rules
│   ├── XSS Protection Rules
│   ├── Bot Detection Rules
│   └── Rate Limiting
├── TEST_CASES.md
│   ├── Payload test results
│   ├── Before/After WAF
│   └── Bypass attempts
└── logs/
    └── waf_access.log
```

#### WAF Rules config:
```
- Rule 981176: SQLi detection
- Rule 941150: XSS prevention  
- Rule 930100: Path traversal
- Rule 932100: PHP injection
- Custom rules for compliance
```

---

### **TUẦN 5: COMPLIANCE & DOCUMENTATION**

#### Công việc:
- [ ] Nghiên cứu Luật 86/2025
- [ ] Tạo compliance matrix
- [ ] Map lỗ ↔ Luật yêu cầu
- [ ] Tạo hardening guide
- [ ] Viết security policy document
- [ ] Tạo incident response plan

#### Deliverables:
```
compliance/
├── LAW_86_2025_ANALYSIS.md
│   ├── Article 23: Bảo vệ dữ liệu cá nhân
│   ├── Article 24: Xác thực, mã hóa
│   ├── Article 25: Kiểm toán, log
│   └── Article 26: Sẵn sàng sự cố
├── COMPLIANCE_MATRIX.xlsx
│   ├── Requirement ↔ Controls
│   ├── SonarQube issues mapping
│   └── WAF rules mapping
├── HARDENING_GUIDE.md
│   ├── Code-level fixes
│   ├── WAF rule tuning
│   └── Infrastructure hardening
├── SECURITY_POLICY.md
│   ├── Data protection policy
│   ├── Incident response
│   └── Audit logging policy
└── RISK_ASSESSMENT.md
    ├── Before remediation
    └── After remediation
```

---

### **TUẦN 6: PENETRATION TESTING & FINAL POLISH**

#### Công việc:
- [ ] Thực hiện pentest (OWASP Top 10)
- [ ] Tạo pentest report chuyên nghiệp
- [ ] Viết case study dài
- [ ] Tạo presentation/demo video
- [ ] Final documentation polish
- [ ] Tạo cheat sheets cho interview

#### Deliverables:
```
penetration-testing/
├── PENTEST_REPORT.md (chuyên nghiệp)
│   ├── Executive Summary
│   ├── Findings (Critical/High/Medium)
│   ├── Remediation recommendations
│   └── Re-test results
├── TEST_CASES.md
│   ├── SQL Injection tests
│   ├── XSS tests
│   ├── CSRF tests
│   ├── IDOR tests
│   ├── Authentication bypass
│   └── WAF bypass attempts
├── EVIDENCE.md
│   ├── Screenshots of findings
│   ├── Curl command examples
│   └── Burp Suite exports
└── OWASP_TOP_10_COVERAGE.md
    ├── A01 - Injection
    ├── A02 - Broken authentication
    ├── A03 - Sensitive data exposure
    ├── A04 - XML External Entities
    ├── A05 - Broken access control
    ├── A06 - Security misconfiguration
    ├── A07 - XSS
    ├── A08 - Insecure deserialization
    ├── A09 - Vulnerable components
    └── A10 - Insufficient logging
```

#### Case Study viết:
- Tình huống: Công ty A cần bảo vệ web app theo Luật 86/2025
- Phát hiện: Xác định 27 lỗ bảo mật
- Giải pháp: SonarQube + WAF
- Kết quả: Giảm risk từ High → Medium
- Kinh nghiệm rút ra

---

## 🏗️ KIẾN TRÚC TECHNICAL

```
┌─────────────────────────────────────────────┐
│            End User / Attacker              │
└────────────────────┬────────────────────────┘
                     │
┌─────────────────────┴────────────────────────┐
│         WAF (ModSecurity + Nginx)            │
│  - OWASP CRS Rules                           │
│  - Rate Limiting                             │
│  - Bot Detection                             │
│  - Logging & Alerting                        │
└────────────────────┬────────────────────────┘
                     │
┌─────────────────────┴────────────────────────┐
│      Laravel Web Application                 │
│  - Controllers                               │
│  - Models                                    │
│  - Middleware                                │
│  - Database (MySQL)                          │
└────────────────────┬────────────────────────┘
                     │
┌─────────────────────┴────────────────────────┐
│      SonarQube Scanner (CI/CD)               │
│  - Code Quality Analysis                     │
│  - Vulnerability Detection                   │
│  - Security Hotspots                         │
│  - Reports & Dashboard                       │
└─────────────────────────────────────────────┘
```

---

## 📊 FOLDER STRUCTURE CUỐI CÙNG

```
web-app-security-law86/
│
├── 📁 1_vulnerable-webapp/
│   ├── docker-compose.yml
│   ├── app/
│   │   ├── Controllers/ (LoginController, PostController, ProfileController)
│   │   ├── Models/
│   │   ├── Middleware/
│   │   └── Views/
│   ├── routes/web.php
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   ├── .env.example
│   ├── README.md (lỗ bảo mật guide)
│   └── VULNERABILITIES.md (chi tiết từng lỗ)
│
├── 📁 2_sonarqube-setup/
│   ├── docker-compose.yml
│   ├── sonar-project.properties
│   ├── SONAR_SETUP.md (step-by-step)
│   ├── VULNERABILITY_REPORT.md
│   ├── REMEDIATION_PLAN.md
│   └── screenshots/
│       ├── dashboard.png
│       ├── issues.png
│       └── code_smells.png
│
├── 📁 3_waf-deployment/
│   ├── docker-compose.yml
│   ├── nginx-config/
│   │   ├── nginx.conf
│   │   ├── modsecurity.conf
│   │   └── rules/
│   │       ├── 900-exceptions.conf
│   │       ├── 901-rules.conf
│   │       └── custom-rules.conf
│   ├── WAF_RULES.md
│   ├── TEST_CASES.md
│   ├── PERFORMANCE_TEST.md
│   └── logs/
│
├── 📁 4_compliance/
│   ├── LAW_86_2025_ANALYSIS.md
│   ├── COMPLIANCE_MATRIX.xlsx
│   ├── HARDENING_GUIDE.md
│   ├── SECURITY_POLICY.md
│   ├── RISK_ASSESSMENT.md
│   └── CONTROLS_MAPPING.md
│
├── 📁 5_penetration-testing/
│   ├── PENTEST_REPORT.md
│   ├── TEST_CASES.md
│   ├── EVIDENCE.md
│   ├── OWASP_TOP_10_COVERAGE.md
│   ├── Burp_exports/
│   └── screenshots/
│
├── 📁 6_automation/
│   ├── run-sonarqube-scan.sh
│   ├── run-waf-tests.sh
│   ├── run-pentest.sh
│   └── health-check.sh
│
├── 📁 7_demo-video-scripts/
│   ├── DEMO_1_VULNERABLE_APP.md
│   ├── DEMO_2_SONARQUBE_SCAN.md
│   ├── DEMO_3_WAF_PROTECTION.md
│   ├── DEMO_4_COMPLIANCE.md
│   └── VIDEO_EDITING_NOTES.md
│
├── 📁 8_interview-cheatsheets/
│   ├── TOP_20_QUESTIONS.md
│   ├── TECHNICAL_ANSWERS.md
│   ├── ARCHITECTURE_DIAGRAM.md
│   └── LIVE_DEMO_SCENARIOS.md
│
├── .gitignore
├── README.md (project overview)
├── SETUP.md (how to run everything)
├── PROJECT_PLAN.md (this file)
└── TIMELINE.md (week-by-week status)
```

---

## ✅ DELIVERABLES CHÍNH

### **Tuần 1:**
- ✅ GitHub repo + Docker setup
- ✅ Project structure ready
- ✅ SonarQube running

### **Tuần 2:**
- ✅ Vulnerable webapp (6 intentional vulnerabilities)
- ✅ Database with sample data
- ✅ Exploitation guide

### **Tuần 3:**
- ✅ SonarQube scan report (27+ issues)
- ✅ Vulnerability analysis document
- ✅ Remediation roadmap

### **Tuần 4:**
- ✅ WAF (ModSecurity) deployed
- ✅ OWASP CRS rules configured
- ✅ Test cases passing

### **Tuần 5:**
- ✅ Compliance matrix (Luật 86/2025)
- ✅ Hardening guide (code + config)
- ✅ Security policy documents

### **Tuần 6:**
- ✅ Professional pentest report
- ✅ Case study (2000+ words)
- ✅ Presentation + demo video
- ✅ Interview Q&A cheat sheet

---

## 🎤 CÁCH GIỚI THIỆU TRONG INTERVIEW

**Kịch bản:**
> "Mình xây dựng project bảo vệ web application theo Luật 86/2025. 
> 
> Đầu tiên, mình tạo một Laravel app với 6 lỗ bảo mật (SQL Injection, XSS, CSRF, IDOR, hardcoded secrets, insecure deserialization).
> 
> Sau đó, mình dùng SonarQube scan code → phát hiện 27 issues, từ Critical tới Minor.
> 
> Rồi mình deploy WAF (ModSecurity + OWASP CRS) để bảo vệ app → WAF block được 95% attacks.
> 
> Cuối cùng, mình map tất cả controls với Luật 86/2025 requirements → chứng minh compliance.
> 
> Kinh nghiệm rút ra: code-level security (SonarQube) + runtime protection (WAF) + compliance framework = defense in depth."

---

## 📚 RESOURCES CẦN CÓ

### **Code & Tools:**
- PHP 8.1+
- Laravel 9+
- Docker & Docker Compose
- SonarQube Community
- ModSecurity
- Nginx
- Postman
- OWASP ZAP
- Burp Suite Community

### **Documentation:**
- [OWASP Top 10 2021](https://owasp.org/Top10/)
- [OWASP API Security](https://owasp.org/www-project-api-security/)
- [Luật 86/2025 (nguồn chính phủ)](https://moit.gov.vn/)
- [ModSecurity Documentation](https://modsecurity.org/)
- [SonarQube Documentation](https://docs.sonarqube.org/)

### **Learning:**
- PentesterLab courses
- HackTheBox labs
- TryHackMe paths
- PortSwigger Web Security Academy

---

## 🎯 KEY METRICS FOR CV

Sau dự án, bạn sẽ có:

✅ **Portfolio pieces:**
- 1 working vulnerable webapp
- 1 SonarQube report (27 issues fixed)
- 1 WAF configuration (protecting real application)
- 1 Compliance documentation (Luật 86/2025)
- 1 Professional pentest report
- 1 Case study

✅ **Technical skills demonstrated:**
- Web application security (OWASP Top 10)
- Code analysis & security scanning (SonarQube)
- Web application firewall (ModSecurity)
- Compliance & regulations (Luật 86/2025)
- Penetration testing methodology
- Docker & containerization
- CI/CD security

✅ **Interview talking points:**
- 6+ specific vulnerabilities fixed
- 27+ security issues identified & remediated
- 95%+ attack detection rate (WAF)
- Full compliance with Vietnamese cybersecurity law
- End-to-end security approach

---

## 🚀 QUICK START (Tuần 1)

```bash
# 1. Init repo
git init web-app-security-law86
cd web-app-security-law86

# 2. Create basic structure
mkdir -p 1_vulnerable-webapp 2_sonarqube-setup 3_waf-deployment 4_compliance 5_penetration-testing 6_automation 7_demo-video-scripts 8_interview-cheatsheets

# 3. Setup SonarQube
cd 2_sonarqube-setup
# (docker-compose.yml tạo ở tuần 1)

# 4. Setup Vulnerable App
cd ../1_vulnerable-webapp
# (Laravel app tạo ở tuần 2)

# 5. Start tracking
git add .
git commit -m "Initial project structure - Week 1"
```

---

## ✨ BONUS: MARKETING FOR CV/LINKEDIN

**Title idea:**
"Web Application Security & Compliance: Law 86/2025 Implementation with SonarQube & WAF"

**Description:**
"End-to-end security project implementing Vietnamese cybersecurity law requirements. Demonstrated vulnerability assessment, secure code analysis, and runtime protection using industry-standard tools."

**Tags:**
#WebSecurity #Cybersecurity #SonarQube #WAF #ModSecurity #OWASP #PenetrationTesting #ComplianceSecurity #Law86_2025 #AppSec

---

**NEXT STEP: Hãy cho mình biết bạn muốn bắt đầu với cái nào (tuần 1 hay tuần 2), mình sẽ tạo code + scripts chi tiết!**
