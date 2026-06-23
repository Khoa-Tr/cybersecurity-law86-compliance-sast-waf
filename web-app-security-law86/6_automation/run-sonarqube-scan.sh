#!/bin/bash

# ===========================================
# SonarQube Scan Automation Script
# ===========================================

set -e

SONAR_URL="${SONAR_URL:-http://localhost:9000}"
SONAR_TOKEN="${SONAR_TOKEN:-}"
PROJECT_KEY="vulnerable-web-app"
SOURCE_DIR="../1_vulnerable-webapp/app"

echo "=== SonarQube Security Scan ==="
echo "URL: $SONAR_URL"
echo "Project: $PROJECT_KEY"

# Check if SonarQube is running
echo "[*] Checking SonarQube status..."
HEALTH=$(curl -s "$SONAR_URL/api/system/health" | python3 -c "import sys,json; d=json.load(sys.stdin); print(d.get('health','UNKNOWN'))" 2>/dev/null || echo "UNKNOWN")

if [ "$HEALTH" != "GREEN" ]; then
    echo "[-] SonarQube not ready (status: $HEALTH)"
    echo "    Start with: cd 2_sonarqube-setup && docker-compose up -d"
    exit 1
fi

echo "[+] SonarQube is healthy!"

# Check sonar-scanner
if ! command -v sonar-scanner &> /dev/null; then
    echo "[*] sonar-scanner not found. Installing..."
    
    SCANNER_VERSION="5.0.1.3006"
    wget -q "https://binaries.sonarsource.com/Distribution/sonar-scanner-cli/sonar-scanner-cli-${SCANNER_VERSION}-linux.zip" \
         -O /tmp/sonar-scanner.zip
    unzip -q /tmp/sonar-scanner.zip -d /tmp/
    export PATH=$PATH:/tmp/sonar-scanner-${SCANNER_VERSION}-linux/bin
    echo "[+] sonar-scanner installed"
fi

# Prompt for token if not set
if [ -z "$SONAR_TOKEN" ]; then
    echo ""
    echo "Enter your SonarQube token (get from http://localhost:9000 → My Account → Security):"
    read -rs SONAR_TOKEN
fi

# Run the scan
echo ""
echo "[*] Starting security scan..."
echo "    Scanning: $SOURCE_DIR"

sonar-scanner \
    -Dsonar.projectKey="$PROJECT_KEY" \
    -Dsonar.projectName="Vulnerable Web App" \
    -Dsonar.sources="$SOURCE_DIR" \
    -Dsonar.host.url="$SONAR_URL" \
    -Dsonar.token="$SONAR_TOKEN" \
    -Dsonar.sourceEncoding=UTF-8 \
    -Dsonar.exclusions="vendor/**,node_modules/**"

echo ""
echo "[+] Scan complete!"
echo "[+] View results at: $SONAR_URL/dashboard?id=$PROJECT_KEY"
echo ""
echo "Expected findings:"
echo "  - Critical: 5 (SQL Injection, Hardcoded Secrets)"
echo "  - High: 8 (XSS, IDOR, Missing Headers)"
echo "  - Medium: 10 (CSRF, Weak Session, etc.)"
echo "  - Low: 4"
echo "  - Total: 27+ issues"
