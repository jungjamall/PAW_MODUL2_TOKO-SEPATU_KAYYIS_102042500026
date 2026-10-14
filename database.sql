CREATE DATABASE IF NOT EXISTS paw_modul2_sepatu CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE paw_modul2_sepatu;

CREATE TABLE sepatu (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode_sepatu VARCHAR(20) NOT NULL UNIQUE,
    nama_sepatu VARCHAR(100) NOT NULL,
    merek_sepatu VARCHAR(50) NOT NULL,
    kategori_sepatu VARCHAR(40) NOT NULL,
    tipe_sepatu VARCHAR(40) NOT NULL,
    harga_sepatu DECIMAL(12,2) NOT NULL,
    stok_sepatu INT UNSIGNED NOT NULL DEFAULT 0,
    deskripsi_sepatu TEXT NOT NULL
);

INSERT INTO sepatu (kode_sepatu,nama_sepatu,merek_sepatu,kategori_sepatu,tipe_sepatu,harga_sepatu,stok_sepatu,deskripsi_sepatu) VALUES
('SPT-001','Sneakers Urban','Stride Co.','Sneakers','Low-top',429000,12,'Sneakers ringan untuk aktivitas harian dengan desain modern.'),
('SPT-002','Running Flex','PaceWear','Running','Trail',589000,8,'Sepatu lari ringan dengan bantalan nyaman untuk latihan.'),
('SPT-003','Classic Loafer','UrbanStep','Formal','Loafer',375000,5,'Loafer klasik untuk tampilan rapi dan acara semi-formal.');
