CREATE DATABASE IF NOT EXISTS amadon;
USE amadon;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL
);

CREATE TABLE homepage_content (
    id INT PRIMARY KEY,
    content TEXT NOT NULL
);

INSERT INTO homepage_content (id, content)
VALUES (
    1,
    '<p>Bienvenue sur <strong>Amadon</strong>, votre mini boutique en ligne inspirée d’Amazon.</p><p>Découvrez nos produits technologiques à petit prix.</p>'
);

INSERT INTO products (name, description, price, image) VALUES
('Casque audio', 'Casque audio sans fil confortable', 59.99, 'casque.jpg'),
('Clavier gamer', 'Clavier mécanique RGB', 79.90, 'clavier.jpg'),
('Souris gaming', 'Souris précise et ergonomique', 39.50, 'souris.jpg'),
('Webcam HD', 'Webcam pour réunions et streaming', 49.00, 'webcam.jpg'),
('Support PC', 'Support ventilé pour ordinateur portable', 25.00, 'support.jpg');