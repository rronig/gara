-- InvestKosovo Hub Database Schema
-- MySQL Script

CREATE DATABASE IF NOT EXISTS investkosovo;
USE investkosovo;

-- Users Table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    user_type ENUM('investor','admin','expert') DEFAULT 'investor',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_login DATETIME,
    address VARCHAR(255),
    phone VARCHAR(50),
    city VARCHAR(100),
    country VARCHAR(100),
    profile_picture VARCHAR(255),
    total_value DECIMAL(15,2),
    total_invested DECIMAL(15,2),
    risk_profile VARCHAR(50),
    investments_made INT DEFAULT 0,
    email_verified TINYINT(1) DEFAULT 0
);

-- Sectors Table
CREATE TABLE sectors (
    sector_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
);

-- Investment Opportunities Table
CREATE TABLE investment_opportunities (
    opportunity_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    sector_id INT,
    capital_min DECIMAL(15,2) NOT NULL,
    capital_max DECIMAL(15,2) NOT NULL,
    risk_level ENUM('low','medium','high') NOT NULL,
    timeline_months INT NOT NULL,
    description TEXT NOT NULL,
    contact_email VARCHAR(150) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sector_id) REFERENCES sectors(sector_id)
);

CREATE TABLE success_stories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    description TEXT NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 0 AND 5),
    CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Analytics Data Table
CREATE TABLE analytics_data (
    data_id INT AUTO_INCREMENT PRIMARY KEY,
    sector_id INT,
    source VARCHAR(100),
    data_type VARCHAR(100),
    value DECIMAL(10,2) NOT NULL,
    year YEAR NOT NULL,
    region VARCHAR(100),
    fetched_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sector_id) REFERENCES sectors(sector_id)
);

-- Legal Frameworks Table
CREATE TABLE legal_frameworks (
    legal_id INT AUTO_INCREMENT PRIMARY KEY,
    country VARCHAR(100) NOT NULL,
    sector_id INT,
    tax_summary TEXT NOT NULL,
    investment_procedures TEXT NOT NULL,
    legal_notes TEXT,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sector_id) REFERENCES sectors(sector_id)
);

-- Incentives Table
CREATE TABLE incentives (
    incentive_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    sector_id INT,
    eligibility_criteria TEXT NOT NULL,
    description TEXT NOT NULL,
    FOREIGN KEY (sector_id) REFERENCES sectors(sector_id)
);

-- Company Profiles Table
CREATE TABLE company_profiles (
    company_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(150) NOT NULL,
    size ENUM('micro','small','medium','large') NOT NULL,
    investment_type VARCHAR(100) NOT NULL,
    location VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Locations Table
CREATE TABLE locations (
    location_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    type ENUM('tech_park', 'industrial_zone', 'renewable_site', 'financial_center') NOT NULL,
    latitude DECIMAL(10,6) NOT NULL,
    longitude DECIMAL(10,6) NOT NULL,
    infrastructure TEXT,
    description TEXT
);

-- Leads Table
CREATE TABLE leads (
    lead_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    source VARCHAR(100),
    message TEXT,
    status ENUM('new','contacted','closed') DEFAULT 'new',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- CMS Content Table
CREATE TABLE cms_content (
    content_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    slug VARCHAR(150) UNIQUE,
    content TEXT NOT NULL,
    type ENUM('news','report','legal','guide') NOT NULL,
    published_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    author_id INT,
    FOREIGN KEY (author_id) REFERENCES users(user_id)
);