-- ================================
-- BASE DE DONNÉES
-- ================================
CREATE DATABASE IF NOT EXISTS energy_tracker
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE energy_tracker;

-- ================================
-- TABLE USERS
-- ================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ================================
-- TABLE CONSOMMATION ÉLECTRIQUE
-- ================================
CREATE TABLE electricity_consumption (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    date DATE NOT NULL,
    kwh DECIMAL(10,2) NOT NULL CHECK (kwh >= 0),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE,

    CONSTRAINT uniq_user_date
        UNIQUE (user_id, date)
) ENGINE=InnoDB;

-- ================================
-- INDEX (performance)
-- ================================
CREATE INDEX idx_user_date
ON electricity_consumption (user_id, date);
