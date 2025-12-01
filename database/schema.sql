CREATE DATABASE IF NOT EXISTS restaurant_db;
USE restaurant_db;

CREATE TABLE pelanggan (
  id_pelanggan INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100),
  telepon VARCHAR(15)
);

CREATE TABLE meja (
  id_meja INT AUTO_INCREMENT PRIMARY KEY,
  nomor_meja INT NOT NULL UNIQUE,
  kapasitas INT NOT NULL,
  status ENUM('tersedia','dipesan') DEFAULT 'tersedia'
);

CREATE TABLE pemesanan (
  id_pemesanan INT AUTO_INCREMENT PRIMARY KEY,
  id_pelanggan INT NOT NULL,
  id_meja INT NOT NULL,
  tanggal DATE NOT NULL,
  waktu TIME NOT NULL,
  jumlah_orang INT NOT NULL,
  FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan) ON DELETE CASCADE,
  FOREIGN KEY (id_meja) REFERENCES meja(id_meja) ON DELETE CASCADE
);

INSERT INTO meja (nomor_meja, kapasitas, status) VALUES
(1, 10, 'tersedia'),
(2, 10, 'tersedia'),
(3, 10, 'tersedia'),
(4, 10, 'tersedia');