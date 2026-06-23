#!/bin/bash

# ===========================================
# Health Check Script
# ===========================================

echo "=== Service Health Check ==="
echo ""

check_service() {
    local name="$1"
    local url="$2"
    
    STATUS=$(curl -s -o /dev/null -w "%{http_code}" --max-time 5 "$url" 2>/dev/null)
    
    if [ "$STATUS" = "200" ] || [ "$STATUS" = "302" ] || [ "$STATUS" = "301" ]; then
        echo "✅ $name: HEALTHY ($url)"
    else
        echo "❌ $name: UNHEALTHY (HTTP $STATUS) - $url"
    fi
}

check_service "Vulnerable App" "http://localhost:8000"
check_service "SonarQube" "http://localhost:9000"
check_service "WAF/Nginx" "http://localhost:80"
check_service "phpMyAdmin" "http://localhost:8080"

echo ""
echo "=== Docker Containers ==="
docker ps --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}" 2>/dev/null || echo "Docker not available"
