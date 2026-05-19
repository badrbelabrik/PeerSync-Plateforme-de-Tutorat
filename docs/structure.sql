CREATE DATABASE peersync;
USE peersync;
CREATE TABLE roles(
    id INT PRIMARY KEY AUTO_INCREMENT,
    label ENUM('admin','student')
);
CREATE TABLE users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    points INT DEFAULT 0,
    id_role INT NOT NULL,
    FOREIGN KEY (id_role) REFERENCES roles(id) ON DELETE CASCADE
);
CREATE TABLE badges(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL
);
CREATE TABLE skills(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL
);
CREATE TABLE user_badges(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    id_badge INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_badge) REFERENCES badges(id) ON DELETE CASCADE
);
CREATE TABLE user_skills(
    id INT PRIMARY KEY AUTO_INCREMENT,
    level ENUM('learn','master'),
    id_user INT NOT NULL,
    id_skill INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_skill) REFERENCES skills(id) ON DELETE CASCADE
);
CREATE TABLE help_requests(
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('pending','assigned','resolved') NOT NULL DEFAULT 'pending',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_learner INT,
    id_tutor INT,
    FOREIGN KEY (id_learner) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (id_tutor) REFERENCES users(id) ON DELETE SET NULL
);
CREATE TABLE reviews(
    id INT PRIMARY KEY AUTO_INCREMENT,
    comment TEXT NOT NULL,
    rating INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_help_request INT NOT NULL,
    FOREIGN KEY (id_help_request) REFERENCES help_requests(id) ON DELETE CASCADE
);
CREATE TABLE sessions(
    id INT PRIMARY KEY AUTO_INCREMENT,
    started_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ended_at DATETIME,
    id_help_request INT,
    FOREIGN KEY (id_help_request) REFERENCES help_requests(id) ON DELETE SET NULL
);
