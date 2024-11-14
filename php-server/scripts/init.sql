-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    salt VARCHAR(32) NOT NULL
);

-- Create user_scores table to store best scores for each game mode
CREATE TABLE user_scores (
    user_id INT NOT NULL,
    best_score_short INT DEFAULT 0,
    best_score_normal INT DEFAULT 0,
    best_score_long INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Trigger to automatically add a record to user_scores when a new user is added
DELIMITER //

CREATE TRIGGER after_user_insert
AFTER INSERT ON users
FOR EACH ROW
BEGIN
    INSERT INTO user_scores (user_id) VALUES (NEW.id);
END //

DELIMITER ;

-- Seeding script for users table
INSERT INTO users (username, password, salt) VALUES 
('admin', '$2y$10$kKRWcuYJcfA7G4qsSvkXuO6sUDbq1bcuywt/LIyE9BoZEVa7Lewma', 'e69e253c4fdc7db7a97a15a953729ad0'),
('Mohamed', '$2y$10$T6Hs3KiTbT4GzL.YckQzw.6UAZd71bT0IJqzdtHuafv3lUd2ke65u', 'ac70acc5645d4025d14b56b534ab479c');
-- For logging in:
-- Mohamed (regular user) password: 12345678
-- admin (admin user) password: password