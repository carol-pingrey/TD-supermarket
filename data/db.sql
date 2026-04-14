CREATE DATABASE IF NOT EXISTS market_4072_4287;
USE market_4072_4287;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL,
  prenom VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  telephone VARCHAR(20) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS caisse (
    id_caisse INT AUTO_INCREMENT PRIMARY KEY,
    num_caisse VARCHAR(255),
    montant DECIMAL(10, 2) DEFAULT 0
);

CREATE TABLE IF NOT EXISTS achat (
    id_achat INT AUTO_INCREMENT PRIMARY KEY,
    num_achat VARCHAR(255),
    cloture_achat BOOLEAN DEFAULT FALSE,
    id_caisse INT,
    date_achat DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_caisse) REFERENCES caisse(id_caisse)
);

CREATE TABLE IF NOT EXISTS produit_stock (
    id_produit_stock INT AUTO_INCREMENT PRIMARY KEY,
    designation VARCHAR(255),
    prix_unitaire DECIMAL(10, 2) DEFAULT 0,
    quantite_stock INT
);

CREATE TABLE IF NOT EXISTS produit_achat (
    id_produit_achat INT AUTO_INCREMENT PRIMARY KEY,
    quantite_achat INT,
    montant_achat DECIMAL(10, 2) DEFAULT 0,
    id_achat INT,
    id_produit_stock INT,
    FOREIGN KEY (id_achat) REFERENCES achat(id_achat),
    FOREIGN KEY (id_produit_stock) REFERENCES produit_stock(id_produit_stock)
);

CREATE VIEW v_caisse_achat AS
SELECT 
    c.num_caisse, 
    a.num_achat, 
    a.date_achat
FROM achat a JOIN caisse c ON a.id_caisse = c.id_caisse; 

CREATE VIEW v_produit AS
SELECT 
    ps.designation,
    ps.prix_unitaire,
    pa.montant_achat,
    pa.quantite_achat,
    pa.id_achat
FROM produit_stock ps
JOIN produit_achat pa ON ps.id_produit_stock = pa.id_produit_stock;

CREATE VIEW v_achat_produit AS
SELECT 
    a.num_achat,
    a.date_achat,
    vp.designation,
    vp.montant_achat,
    vp.quantite_achat,
    vp.prix_unitaire
FROM v_produit vp
JOIN achat a ON vp.id_achat = a.id_achat;

INSERT INTO users (nom, prenom, email, password, telephone) VALUES 
('user', 'User', 'user@user.com', '123', '0324737322');

INSERT INTO caisse (num_caisse, montant) VALUES
('CAISSE-01', 0.00),
('CAISSE-02', 0.00),
('CAISSE-03', 0.00);

INSERT INTO achat (num_achat, id_caisse, date_achat) VALUES 
('ACHAT-01', 1, NOW());

INSERT INTO produit_stock (designation, prix_unitaire, quantite_stock) VALUES
('Pomme', 500.00, 80),
('Banane', 300.00, 100),
('Orange', 400.00, 90);
