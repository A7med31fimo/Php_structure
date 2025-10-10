CREATE DATABASE cv_builder CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE cv_builder;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(150) UNIQUE,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
