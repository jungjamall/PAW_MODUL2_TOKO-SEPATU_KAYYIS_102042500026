
<?php

// Konfigurasi koneksi database
$host = '127.0.0.1';
$username = 'root';
$password = 'Kbfizvo@1402';
$database = 'paw_modul2_sepatu';

// Menghubungkan PHP ke database MySQL
$conn = mysqli_connect(
    $host,
    $username,
    $password,
    $database
);

// Memeriksa koneksi database
if (!$conn) {
    exit(
        'Koneksi database gagal. ' .
        'Periksa layanan MySQL dan konfigurasi koneksi.php.'
    );
}

// Mengatur karakter agar mendukung UTF-8
mysqli_set_charset($conn, 'utf8mb4');

?>
