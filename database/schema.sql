-- Import into MAMP/XAMPP phpAdmin database
CREATE DATABASE IF NOT EXISTS dolphin_crm;
USE dolphin_crm;

CREATE TABLE IF NOT EXISTS Users (
                                     id INT AUTO_INCREMENT PRIMARY KEY,
                                     firstname VARCHAR(100),
                                     lastname VARCHAR(100),
                                     password VARCHAR(255),
                                     email VARCHAR(100) UNIQUE,
                                     role VARCHAR(100),
                                     created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Contacts (
                                        id INT AUTO_INCREMENT PRIMARY KEY,
                                        title VARCHAR(100),
                                        firstname VARCHAR(100),
                                        lastname VARCHAR(100),
                                        email VARCHAR(100),
                                        telephone VARCHAR(25),
                                        company VARCHAR(100),
                                        type VARCHAR(12),
                                        assigned_to INT,
                                        created_by INT,
                                        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                                        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Notes (
                                     id INT AUTO_INCREMENT PRIMARY KEY,
                                     contact_id INT,
                                     comment TEXT,
                                     created_by INT,
                                     created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- the Password is hashed (password123) use the password_verify() to un-hash when logging in.
INSERT INTO Users (firstname, lastname, password, email, role)
    VALUE(
          'ADMIN',
          'INFO2180_Project2',
          '$2y$10$/hxj/.zLNpIuwahEyaHRXOu1dVkfFE1pLGLw1t3A8ko5bG.akhmh.',
          'admin@project2.com',
          'Admin'
    );