CREATE DATABASE garage_parrot;

-- Table Admin
CREATE TABLE admin (
  id INT PRIMARY KEY AUTO_INCREMENT,
  first_name VARCHAR(50),
  last_name VARCHAR(50),
  email VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(50)
);

-- Table Employés
CREATE TABLE employees (
  id INT PRIMARY KEY AUTO_INCREMENT,
  first_name VARCHAR(50),
  last_name VARCHAR(50),
  email VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(50),
  admin_id INT,
  FOREIGN KEY (admin_id) REFERENCES admin(id)
);

-- Table Vehicules
CREATE TABLE vehicles (
  id INT PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(150),
  price DECIMAL(10, 2),
  year INT,
  mileage INT,
  image VARCHAR(50),
  image1 VARCHAR(50),
  image2 VARCHAR(50)
);

-- Table Reviews
CREATE TABLE reviews (
  id INT PRIMARY KEY AUTO_INCREMENT,
  rating INT,
  comment TEXT,
  reviewer_name VARCHAR(50),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  approved BOOLEAN DEFAULT 0
);

-- Table horaires
CREATE TABLE opening_hours (
  id INT(11) NOT NULL AUTO_INCREMENT,
  mon_hours VARCHAR(50) DEFAULT NULL,
  tue_hours VARCHAR(50) DEFAULT NULL,
  wed_hours VARCHAR(50) DEFAULT NULL,
  thu_hours VARCHAR(50) DEFAULT NULL,
  fri_hours VARCHAR(50) DEFAULT NULL,
  sat_hours VARCHAR(50) DEFAULT NULL,
  sun_hours VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (id)
);

-- Table services
CREATE TABLE services (
  id INT PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  image VARCHAR(255) NOT NULL,
  description TEXT NOT NULL
);

-- Table users
CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL UNIQUE,
  phone VARCHAR(20) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table caractéristiques vehicle
CREATE TABLE vehicle_features (
  id INT PRIMARY KEY AUTO_INCREMENT,
  vehicle_id INT,
  feature_name VARCHAR(255),
  feature_value VARCHAR(255),
  FOREIGN KEY (vehicle_id) REFERENCES vehicles (id)
);

-- Table vehicle équipements
CREATE TABLE vehicle_equipment (
  id INT PRIMARY KEY AUTO_INCREMENT,
  vehicle_id INT,
  equipment_name VARCHAR(255),
  FOREIGN KEY (vehicle_id) REFERENCES vehicles (id)
);
