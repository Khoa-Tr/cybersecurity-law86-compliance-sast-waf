# 📋 SonarQube Setup Guide

## Prerequisites
- Docker & Docker Compose installed
- 4GB+ RAM available
- Port 9000 available

## Step 1: Start SonarQube

```bash
cd C:\Users\ACER\Downloads\files\web-app-security-law86\2_sonarqube-setup
docker-compose up -d

# Wait ~2 minutes for startup
# Check logs
docker-compose logs -f sonarqube-server
```

## Step 2: Access SonarQube

- URL: http://localhost:9000
- Default credentials: **admin / admin**
- You'll be prompted to change password on first login

## Step 3: Create Project

1. Click **"Create Project"** → **"Manually"**
2. Project display name: `Vulnerable Web App`
3. Project key: `vulnerable-web-app`
4. Click **"Set up"**

## Step 4: Generate Token

1. Select **"Locally"**
2. Token name: `web-app-token`
3. Click **"Generate"**
4. **Save the token** - you'll need it for scanning

## Step 5: Install SonarQube Scanner

```bash
# Download scanner
wget https://binaries.sonarsource.com/Distribution/sonar-scanner-cli/sonar-scanner-cli-5.0.1.3006-linux.zip
unzip sonar-scanner-cli-5.0.1.3006-linux.zip
export PATH=$PATH:$(pwd)/sonar-scanner-5.0.1.3006-linux/bin
```

## Step 6: Run Scan

```bash
cd C:\Users\ACER\Downloads\files\web-app-security-law86\1_vulnerable-webapp

# Set your token
export SONAR_TOKEN=your_generated_token_here

# Run scanner
sonar-scanner \
  -Dsonar.projectKey=vulnerable-web-app \
  -Dsonar.sources=app \
  -Dsonar.host.url=http://localhost:9000 \
  -Dsonar.token=$SONAR_TOKEN
```

## Step 7: View Results

Go to http://localhost:9000 → your project

**Expected findings:**
- 🔴 SQL Injection (Critical)
- 🔴 Hardcoded credentials (Critical)
- 🟠 XSS vulnerability (High)
- 🟠 IDOR / Missing authorization (High)
- 🟡 Missing CSRF protection (Medium)
- Total: **27+ issues**

## Troubleshooting

```bash
# SonarQube not starting - increase virtual memory
sudo sysctl -w vm.max_map_count=524288

# Check SonarQube health
curl http://localhost:9000/api/system/health

# Restart services
docker-compose restart sonarqube-server
```
