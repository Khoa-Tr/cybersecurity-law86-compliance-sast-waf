-- =========================================
-- Vulnerable Web Application Database Schema
-- For Educational Purposes Only
-- =========================================

CREATE DATABASE IF NOT EXISTS vulnerable_db;
USE vulnerable_db;

-- Users table (with sensitive data for IDOR demo)
CREATE TABLE users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(100) NOT NULL UNIQUE,
    email       VARCHAR(255) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    phone       VARCHAR(20),
    ssn_last4   VARCHAR(4),      -- Last 4 of SSN (sensitive!)
    role        ENUM('user','admin') DEFAULT 'user',
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Posts table (vulnerable to XSS)
CREATE TABLE posts (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT NOT NULL,
    title       VARCHAR(500),
    content     TEXT,           -- No sanitization - XSS vulnerable
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Sessions table
CREATE TABLE user_sessions (
    id          VARCHAR(128) PRIMARY KEY,
    user_id     INT,
    ip_address  VARCHAR(45),
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at  TIMESTAMP
);
