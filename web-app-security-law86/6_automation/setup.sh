#!/bin/bash

# ===========================================
# PROJECT SETUP SCRIPT
# Web Application Security - Law 86/2025
# ===========================================

set -e

echo "╔════════════════════════════════════════╗"
echo "║  Web App Security - Law 86/2025 Setup  ║"
echo "╚════════════════════════════════════════╝"
echo ""

# Check prerequisites
check_prerequisites() {
    echo "[*] Checking prerequisites..."
    
    if ! command -v docker &> /dev/null; then
        echo "[-] ERROR: Docker not found. Please install Docker first."
        exit 1
    fi
    
    if ! command -v docker-compose &> /dev/null; then
        echo "[-] ERROR: docker-compose not found."
        exit 1
    fi
    
    echo "[+] Docker: $(docker --version)"
    echo "[+] Docker Compose: $(docker-compose --version)"
    echo "[+] All prerequisites met!"
}

# Create project structure
setup_structure() {
    echo ""
    echo "[*] Creating project structure..."
    
    mkdir -p 1_vulnerable-webapp/{app/{Controllers,Models,Middleware,Views},routes,database/{migrations,seeders},public}
    mkdir -p 2_sonarqube-setup/screenshots
    mkdir -p 3_waf-deployment/{nginx-config/rules,logs}
    mkdir -p 4_compliance
    mkdir -p 5_penetration-testing/{Burp_exports,screenshots,EVIDENCE}
    mkdir -p 6_automation
    mkdir -p 7_demo-video-scripts
    mkdir -p 8_interview-cheatsheets
    
    echo "[+] Directory structure created!"
}

# Start SonarQube
start_sonarqube() {
    echo ""
    echo "[*] Starting SonarQube..."
    
    # Set required sysctl for Elasticsearch
    sudo sysctl -w vm.max_map_count=524288 2>/dev/null || true
    
    cd 2_sonarqube-setup
    docker-compose up -d
    cd ..
    
    echo "[+] SonarQube starting... (wait ~2 minutes)"
    echo "[+] Access at: http://localhost:9000 (admin/admin)"
}

# Start vulnerable webapp
start_webapp() {
    echo ""
    echo "[*] Starting vulnerable web application..."
    
    cd 1_vulnerable-webapp
    
    # Copy .env if not exists
    if [ ! -f .env ]; then
        cp .env.example .env
        echo "[+] Created .env from example"
    fi
    
    docker-compose up -d
    cd ..
    
    echo "[+] Vulnerable app starting..."
    echo "[+] Access at: http://localhost:8000"
}

# Start WAF
start_waf() {
    echo ""
    echo "[*] Starting WAF (ModSecurity + Nginx)..."
    
    cd 3_waf-deployment
    docker-compose up -d
    cd ..
    
    echo "[+] WAF starting..."
    echo "[+] Proxied access at: http://localhost:80"
}

# Initialize git
init_git() {
    echo ""
    echo "[*] Initializing Git repository..."
    
    if [ ! -d .git ]; then
        git init
        
        # Create .gitignore
        cat > .gitignore << 'GITIGNORE'
# Environment files - NEVER COMMIT
.env
.env.backup
.env.local
.env.production

# Dependencies
vendor/
node_modules/

# Logs
*.log
logs/
storage/logs/

# Docker volumes
mysql-data/
sonarqube-data/
postgresql_data/

# OS
.DS_Store
Thumbs.db

# IDE
.vscode/
.idea/
*.swp

# Test results
waf-test-results.txt
coverage/

# Secrets
*.key
*.pem
secrets/
GITIGNORE
        
        git add .
        git commit -m "Initial commit: Web Application Security Project - Week 1"
        echo "[+] Git repository initialized!"
    else
        echo "[+] Git repository already exists"
    fi
}

# Health check
health_check() {
    echo ""
    echo "[*] Running health checks..."
    sleep 5
    
    # Check webapp
    if curl -s http://localhost:8000 > /dev/null 2>&1; then
        echo "[+] ✅ Vulnerable webapp: RUNNING (http://localhost:8000)"
    else
        echo "[-] ⚠️  Vulnerable webapp: NOT READY yet (may need more time)"
    fi
    
    # Check SonarQube
    if curl -s http://localhost:9000/api/system/health > /dev/null 2>&1; then
        echo "[+] ✅ SonarQube: RUNNING (http://localhost:9000)"
    else
        echo "[-] ⚠️  SonarQube: NOT READY yet (may take ~2 minutes)"
    fi
    
    # Check WAF
    if curl -s http://localhost:80 > /dev/null 2>&1; then
        echo "[+] ✅ WAF/Nginx: RUNNING (http://localhost:80)"
    else
        echo "[-] ⚠️  WAF: NOT READY yet"
    fi
}

# Main execution
main() {
    check_prerequisites
    setup_structure
    start_sonarqube
    start_webapp
    # start_waf  # Uncomment when ready for WAF
    init_git
    health_check
    
    echo ""
    echo "╔═══════════════════════════════════╗"
    echo "║           SETUP COMPLETE!          ║"
    echo "╠═══════════════════════════════════╣"
    echo "║ Vulnerable App: localhost:8000     ║"
    echo "║ SonarQube:      localhost:9000     ║"
    echo "║ WAF (Nginx):    localhost:80       ║"
    echo "║ phpMyAdmin:     localhost:8080     ║"
    echo "╚═══════════════════════════════════╝"
    echo ""
    echo "Next steps:"
    echo "  1. Read VULNERABILITIES_GUIDE.md"
    echo "  2. Test vulnerabilities at localhost:8000"
    echo "  3. Run SonarQube scan: bash 6_automation/run-sonarqube-scan.sh"
    echo "  4. Run WAF tests: bash 6_automation/run-waf-tests.sh"
}

main "$@"
