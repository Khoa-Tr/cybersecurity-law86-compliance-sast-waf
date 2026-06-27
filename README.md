# 🛡️ Web Application Security: Law 86/2025 Compliance

**Project Title:** Bảo vệ Ứng dụng Web tuân thủ Luật 86/2025 bằng SonarQube và WAF  
**Target Audience:** Cybersecurity professionals, Penetration testers, SOC analysts  
**Difficulty Level:** Advanced  
**Estimated Duration:** 6 weeks

---

## 📌 PROJECT OVERVIEW

This comprehensive project demonstrates a complete web application security implementation following Vietnamese Cybersecurity Law 86/2025 requirements. It combines:

- **Vulnerable Web Application** - Intentionally buggy Laravel app for testing
- **Code Analysis** - SonarQube scanning and vulnerability detection
- **Web Application Firewall** - ModSecurity with OWASP rules
- **Compliance Documentation** - Law 86/2025 mapping and controls
- **Penetration Testing** - Complete assessment and remediation

### 🎯 Project Objectives

1. ✅ Identify security vulnerabilities (27 intentional issues)
2. ✅ Analyze code quality (SonarQube scanning)
3. ✅ Implement protective controls (WAF/ModSecurity)
4. ✅ Ensure legal compliance (Law 86/2025)
5. ✅ Document and remediate findings
6. ✅ Create portfolio for security careers

---

## 📊 Kết quả thực tế

| Chỉ số | Kết quả |
|--------|---------|
| Lỗ hổng phát hiện (SonarQube) | 27 findings (2 Blocker, 5 Reliability, 17 Maintainability) |
| WAF block rate | 14/18 attack scenarios blocked |
| Risk Score sau hardening | 9.2 → 2.1 (giảm 77%) |
| Compliance Luật 86/2025 | 16/16 controls ✅ |

> ⚠️ **Known WAF Limitations (documented intentionally):**
> - OS Command Injection (`;` / `|`) → Not blocked — CRS default tránh block do false positive cao
> - SQLMap scanner detection → Not blocked — cần bổ sung bot-detection rules riêng
> - Rate Limiting → Not configured — cần Nginx `limit_req` module

📄 Chi tiết: [PENETRATION_TEST_REPORT.md](.5_penetration-testing/PENETRATION_TEST_REPORT.md) · [LAW_86_2025_COMPLIANCE.md](./LAW_86_2025_COMPLIANCE.md)

---

## 📋 PROJECT STRUCTURE

```
web-app-security-law86/
│
├── 📁 1_vulnerable-webapp/           # Laravel app with 6 intentional vulns
│   ├── app/
│   │   ├── Controllers/
│   │   │   ├── LoginController.php       (SQL Injection)
│   │   │   ├── PostController.php        (XSS + CSRF)
│   │   │   └── ProfileController.php     (IDOR)
│   │   ├── Models/
│   │   ├── Middleware/
│   │   └── Views/
│   ├── docker-compose.yml
│   ├── Dockerfile
│   ├── .env.example
│   └── README.md
│
├── 📁 2_sonarqube-setup/             # Code scanning and analysis
│   ├── docker-compose.yml
│   ├── sonar-project.properties
│   ├── SONAR_SETUP.md
│   └── VULNERABILITY_REPORT.md
│
├── 📁 3_waf-deployment/              # Web Application Firewall
│   ├── docker-compose.yml
│   ├── Dockerfile.waf
│   ├── nginx-config/
│   │   ├── nginx.conf
│   │   ├── modsecurity.conf
│   │   └── rules/
│   ├── WAF_RULES.md
│   └── TEST_CASES.md
│
├── 📁 4_compliance/                  # Law 86/2025 compliance
│   ├── LAW_86_2025_ANALYSIS.md
│   ├── COMPLIANCE_MATRIX.md
│   ├── HARDENING_GUIDE.md
│   └── SECURITY_POLICY.md
│
├── 📁 5_penetration-testing/         # Pentest results
│   ├── PENETRATION_TEST_REPORT.md
│   ├── TEST_CASES.md
│   ├── OWASP_TOP_10.md
│   └── EVIDENCE/
│       └── screenshots/
│
├── 📁 6_automation/                  # Scripts and automation
│   ├── setup.sh
│   ├── run-sonarqube-scan.sh
│   ├── run-waf-tests.sh
│   └── health-check.sh
│
├── 📁 7_demo-video-scripts/          # Demo documentation
│   ├── DEMO_SCENARIOS.md
│   └── VIDEO_TIMELINE.md
│
├── 📁 8_interview-cheatsheets/       # Interview prep
│   ├── TOP_20_QUESTIONS.md
│   └── TECHNICAL_ANSWERS.md
│
├── project_plan.md                   # 6-week detailed plan
├── VULNERABILITIES_GUIDE.md          # Detailed vuln explanations
├── README.md                         # This file
└── .gitignore
```

---

## 🚀 QUICK START (5 Minutes)

### Prerequisites

```bash
# Required
- Docker & Docker Compose
- Git
- Bash shell
- curl/wget

# Recommended
- 8GB+ RAM
- 20GB+ disk space
- Linux/macOS or WSL2 (Windows)
```

### Installation

**Step 1: Clone/Initialize Project**
```bash
mkdir web-app-security-law86
cd web-app-security-law86
git init
```

**Step 2: Copy All Files**
```bash
# Copy all provided files into project directory
# Including docker-compose files, configs, scripts, controllers
```

**Step 3: Make Scripts Executable**
```bash
chmod +x setup.sh run-sonarqube-scan.sh run-waf-tests.sh
```

**Step 4: Run Setup**
```bash
./setup.sh
```

**Step 5: Start Services**
```bash
# Start SonarQube
cd 2_sonarqube-setup
docker-compose up -d

# In new terminal - Start vulnerable app
cd 1_vulnerable-webapp
docker-compose up -d

# In another terminal - Start WAF
cd 3_waf-deployment
docker-compose up -d
```

**Step 6: Access Services**
```
Vulnerable App: http://localhost:8000
SonarQube:      http://localhost:9000 (admin/admin)
WAF (Nginx):    http://localhost:80
Database:       localhost:3306
```

---

## 📚 DETAILED DOCUMENTATION

### Week 1: Project Setup
**Files:** `setup.sh`, `project_plan.md`, `docker-compose.yml`  
**Duration:** 2-3 hours

- ✅ Initialize project structure
- ✅ Setup Docker containers
- ✅ Configure SonarQube
- ✅ Initialize Git repository

### Week 2: Vulnerable Application
**Files:** `LoginController.php`, `PostController.php`, `ProfileController.php`  
**Duration:** 4-5 hours

6 Intentional Vulnerabilities:
1. **SQL Injection** - LoginController (CRITICAL)
2. **XSS - Stored** - PostController (HIGH)
3. **CSRF** - PostController (MEDIUM)
4. **IDOR** - ProfileController (HIGH)
5. **Hardcoded Secrets** - Config files (CRITICAL)
6. **Insecure Deserialization** - File upload (CRITICAL)

### Week 3: SonarQube Scanning
**Files:** `run-sonarqube-scan.sh`, `VULNERABILITY_REPORT.md`  
**Duration:** 3-4 hours

- ✅ Configure SonarQube project
- ✅ Run security scans
- ✅ Analyze 27+ findings
- ✅ Generate compliance report

### Week 4: WAF Deployment
**Files:** `modsecurity.conf`, `nginx.conf`, `run-waf-tests.sh`  
**Duration:** 4-5 hours

- ✅ Configure ModSecurity
- ✅ Deploy OWASP CRS rules
- ✅ Tune WAF for application
- ✅ Test protection (14/18 attack scenarios blocked)

### Week 5: Compliance & Documentation
**Files:** `LAW_86_2025_COMPLIANCE.md`, `COMPLIANCE_MATRIX.md`  
**Duration:** 4-5 hours

- ✅ Law 86/2025 analysis
- ✅ Compliance matrix
- ✅ Hardening guide
- ✅ Security policies

### Week 6: Penetration Testing
**Files:** `PENETRATION_TEST_REPORT.md`, `VULNERABILITIES_GUIDE.md`  
**Duration:** 5-6 hours

- ✅ Professional pentest report
- ✅ Case study (2000+ words)
- ✅ Interview Q&A
- ✅ Presentation slides

---

## 🔐 VULNERABILITIES OVERVIEW

### Critical (5)

| ID | Name | File | CWE | Severity | CVSS |
|----|------|------|-----|----------|------|
| 1 | SQL Injection | LoginController.php | 89 | CRITICAL | 9.8 |
| 2 | XSS - Stored | PostController.php | 79 | HIGH | 7.5 |
| 4 | IDOR | ProfileController.php | 639 | HIGH | 7.3 |
| 5 | Hardcoded Secrets | Config files | 798 | CRITICAL | 9.1 |
| 6 | Insecure Deser. | File upload | 502 | CRITICAL | 9.8 |

**See:** `VULNERABILITIES_GUIDE.md` for detailed explanations and exploitation methods

---

## 🛡️ REMEDIATION SUMMARY

### Before Remediation
- ❌ 27 vulnerabilities found
- ❌ 5 Critical issues
- ❌ Risk Score: 9.2/10
- ❌ Law compliance: FAIL

### After Remediation
- ✅ All critical issues fixed
- ✅ 80%+ vulnerability reduction
- ✅ Risk Score: 2.1/10 (77% reduction)
- ✅ Law 86/2025: PASS

---

## 📊 COMPLIANCE MATRIX

**Law 86/2025 Coverage:**

| Article | Title | Control | Status |
|---------|-------|---------|--------|
| 23 | Data Protection | IDOR fixes, field hiding | ✅ |
| 24 | System Security | SQLi prevention, CSRF tokens | ✅ |
| 25 | Audit Logging | Centralized logs, monitoring | ✅ |
| 26 | Incident Response | IRP, backups, disaster recovery | ✅ |

---

## 🎬 USAGE SCENARIOS

### Scenario 1: Exploit SQL Injection
```bash
# Test vulnerable login endpoint
curl -X POST http://localhost:8000/login \
  -d "username=admin' OR '1'='1' --&password=anything"

# Expected: Login bypass
```

### Scenario 2: Test XSS Protection
```bash
# Send malicious content
curl -X POST http://localhost:8000/posts \
  -d "content=<script>alert('XSS')</script>"

# Before WAF: Content stored and executed
# After WAF: Request blocked with HTTP 403
```

### Scenario 3: Test IDOR Vulnerability
```bash
# Access other user's profile
curl http://localhost:8000/profile/2
# Returns user 2's full profile (email, phone, SSN)

# After fix + WAF: Access denied or data hidden
```

### Scenario 4: Run Security Scans
```bash
# SonarQube scan
cd 6_automation
bash run-sonarqube-scan.sh

# WAF testing
bash run-waf-tests.sh

# View results at http://localhost:9000
```

---

## 📈 METRICS & RESULTS

### Code Quality (SonarQube)
```
Lines of Code:      ~744
Security Blockers:  2
Reliability:        5 issues
Maintainability:    17 issues
```

### WAF Effectiveness
```
Total Tests:             18
Passed (Blocked):        14 (77.8%)
Failed (Not Blocked):    4 (22.2%)
False Positives:         1
```

**Known Limitations:**
- **OS Command Injection** (semicolon/pipe) → Not blocked — CRS default rules avoid blocking `;` and `|` due to high false positive risk
- **SQLMap Scanner Detection** → Not blocked — requires additional bot-detection rules
- **Rate Limiting** → Not configured — needs separate Nginx `limit_req` module setup

### Compliance Status
```
Requirements Met:   16/16 (100%)
Control Coverage:   100%
Risk Reduction:     77%
Audit Ready:        YES
```

---

## 🎓 LEARNING OUTCOMES

### Technical Skills
✅ Web application security (OWASP Top 10)  
✅ Code vulnerability analysis (SonarQube)  
✅ Web Application Firewall configuration  
✅ Secure coding practices  
✅ Penetration testing methodology

### Compliance Knowledge
✅ Vietnamese Cybersecurity Law (86/2025)  
✅ Security controls implementation  
✅ Audit logging and monitoring  
✅ Incident response planning  
✅ Risk assessment and remediation

### Tools & Technologies
✅ Docker & containerization  
✅ SonarQube code analysis  
✅ ModSecurity WAF  
✅ Nginx web server  
✅ Laravel PHP framework  
✅ MySQL database  
✅ CURL & HTTP testing

### Career Preparation
✅ Portfolio for pentest positions  
✅ Case study for interviews  
✅ Compliance knowledge for SOC roles  
✅ OWASP expertise for AppSec jobs

---

## 🔗 ADDITIONAL RESOURCES

### OWASP & Security Standards
- [OWASP Top 10 2021](https://owasp.org/Top10/)
- [OWASP API Security](https://owasp.org/www-project-api-security/)
- [CWE/SANS Top 25](https://cwe.mitre.org/top25/)
- [NIST Cybersecurity Framework](https://www.nist.gov/cyberframework/)

### Learning Platforms
- [PortSwigger Web Security Academy](https://portswigger.net/web-security)
- [HackTheBox](https://www.hackthebox.com/)
- [TryHackMe](https://tryhackme.com/)
- [PentesterLab](https://pentesterlab.com/)

### Tools Documentation
- [SonarQube Docs](https://docs.sonarqube.org/)
- [ModSecurity Documentation](https://modsecurity.org/)
- [OWASP ModSecurity CRS](https://coreruleset.org/)
- [Laravel Security](https://laravel.com/docs/security)

### Vietnamese Cybersecurity
- [Bộ TTTT - Law 86/2025](https://moit.gov.vn/)
- [VNICS - Vietnam Info Security](https://vnics.gov.vn/)

---

## 🎯 PORTFOLIO PRESENTATION

### For Resume/CV
```
PROJECT: Web Application Security & Compliance (Law 86/2025)
• Triển khai môi trường Vulnerable Web App (6 lỗ hổng OWASP) bằng Docker + Nginx
• Tích hợp SonarQube (SAST): phát hiện 27 security findings từ giai đoạn phát triển
• Triển khai ModSecurity WAF: blocked 14/18 attack scenarios; phân tích root cause cho 4 case còn lại
• Xây dựng Compliance Matrix & Hardening Guide theo Luật ATTTM số 86/2025 (16/16 controls)
• Risk Score giảm 77% sau hardening (9.2 → 2.1)

TECHNOLOGIES: Laravel, Docker, SonarQube, ModSecurity, Nginx, MySQL
SKILLS: Penetration Testing, WAF, SAST, Compliance, AppSec
```

### For Interview
> *"Tôi xây dựng một project bảo mật web hoàn chỉnh theo chu trình Red/Blue Team: tự tạo ứng dụng chứa lỗ hổng có chủ đích, pentest thủ công, phân tích bằng SonarQube, triển khai WAF ModSecurity và lập Compliance Matrix theo Luật 86/2025. WAF block được 14/18 attack scenario — 4 case còn lại tôi đã phân tích và document rõ nguyên nhân kỹ thuật (false positive risk, thiếu bot-detection rules). Kết quả: risk score giảm 77% và đầy đủ báo cáo theo chuẩn doanh nghiệp."*

---

## ⚠️ IMPORTANT NOTES

### Educational Use Only

This project contains **intentionally vulnerable code** for educational and testing purposes.

```
🚫 DO NOT use this code in production
🚫 DO NOT expose this application to the internet
🚫 DO NOT use in commercial environments without modification
✅ DO use for learning, training, and portfolio development
✅ DO document all testing activities
✅ DO respect applicable laws and regulations
```

### Legal Compliance
- Ensure all penetration testing complies with local laws
- Obtain written authorization before testing
- Document all findings confidentially
- Never access unauthorized data
- Report vulnerabilities responsibly

---

## 📞 SUPPORT & TROUBLESHOOTING

### Common Issues

**Q: Docker containers not starting**
```bash
docker-compose logs -f
docker-compose down && docker-compose up -d --build
```

**Q: Port already in use**
```bash
lsof -i :8000
kill -9 <PID>
```

**Q: SonarQube not accessible**
```bash
curl http://localhost:9000/api/system/health
docker-compose restart sonarqube-server
```

**Q: Database connection error**
```bash
docker-compose exec app-db mysqladmin ping -h localhost
docker-compose down
docker volume rm <volume_name>
docker-compose up -d
```

---

## 📄 LICENSE & ATTRIBUTION

**Author:** Trần Đăng Khoa  
**Created:** 2026  
**Updated:** 2026-06  
**License:** Educational Use Only
