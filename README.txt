PROJECT PRAKTIKUM PAW MODUL 2 — TEMA TOKO SEPATU
Nama aplikasi: SoleSpace

FILE PROJECT
- database.sql : membuat database paw_modul2_sepatu, tabel sepatu, dan 3 data awal.
- koneksi.php  : koneksi PHP ke MySQL/MariaDB.
- style.css    : tampilan katalog sepatu.
- index.php    : daftar dan pencarian sepatu (READ).
- tambah.php   : form tambah sepatu (CREATE).
- detail.php   : informasi lengkap satu produk.
- edit.php     : form ubah produk (UPDATE).
- hapus.php    : konfirmasi dan hapus produk (DELETE).

CARA MENJALANKAN (LARAGON)
1. Ekstrak folder project ke C:\laragon\www\toko_sepatu_paw
2. Jalankan Start All di Laragon.
3. Buka http://localhost/phpmyadmin
4. Pilih tab Import dan import file database.sql.
5. Konfigurasi default koneksi: host 127.0.0.1, user root, password kosong.
6. Buka http://localhost/toko_sepatu_paw/index.php

CARA MENJALANKAN (XAMPP)
1. Ekstrak folder project ke htdocs/toko_sepatu_paw.
2. Jalankan Apache dan MySQL.
3. Import database.sql melalui phpMyAdmin.
4. Buka http://localhost/toko_sepatu_paw/index.php

CATATAN
- Data produk awal merupakan data contoh untuk latihan.
- Jika nama folder diubah, URL localhost juga perlu disesuaikan.
