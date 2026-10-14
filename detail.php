
<?php
require 'koneksi.php';

// Fungsi untuk mengamankan output HTML
function h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Fungsi untuk format harga ke Rupiah
function rupiah($value)
{
    return 'Rp ' . number_format((float) $value, 0, ',', '.');
}

// Mengambil ID sepatu dari URL
$id = (int) ($_GET['id'] ?? 0);

// Mengambil data sepatu berdasarkan ID
$stmt = mysqli_prepare(
    $conn,
    'SELECT * FROM sepatu WHERE id = ?'
);

mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$sepatu = mysqli_fetch_assoc($hasil);

// Jika sepatu tidak ditemukan
if (!$sepatu) {
    http_response_code(404);
    exit(
        'Sepatu tidak ditemukan. ' .
        '<a href="index.php">Kembali ke katalog</a>.'
    );
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Detail Sepatu — SoleSpace</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- Header -->
    <header class="topbar">
        <a class="brandmark" href="index.php">
            sole<span>space.</span>
        </a>

        <nav class="navlinks">
            <a href="index.php">Katalog</a>
            <a href="tambah.php">Tambah Sepatu</a>
        </nav>
    </header>

    <!-- Konten utama -->
    <main class="wrap">

        <p class="eyebrow">Sepatu details</p>
        <h1 class="page-title">Detail sepatu</h1>

        <section class="panel">
            <div class="detail-grid">

                <!-- Ilustrasi sepatu -->
                <div class="detail-art" aria-hidden="true">
                    👟
                </div>

                <!-- Informasi sepatu -->
                <div>
                    <span class="pill">
                        <?= h($sepatu['kategori_sepatu']) ?>
                    </span>

                    <h2
                        class="page-title"
                        style="font-size: 30px; margin-top: 12px;"
                    >
                        <?= h($sepatu['nama_sepatu']) ?>
                    </h2>

                    <p class="meta">
                        <?= h($sepatu['merek_sepatu']) ?>
                    </p>

                    <p class="price">
                        <?= rupiah($sepatu['harga_sepatu']) ?>
                    </p>

                    <!-- Detail data sepatu -->
                    <dl class="detail-list">

                        <dt>Kode sepatu</dt>
                        <dd>
                            <?= h($sepatu['kode_sepatu']) ?>
                        </dd>

                        <dt>Kategori sepatu</dt>
                        <dd>
                            <?= h($sepatu['kategori_sepatu']) ?>
                        </dd>

                        <dt>Model sepatu</dt>
                        <dd>
                            <?= h($sepatu['tipe_sepatu']) ?>
                        </dd>

                        <dt>Stok</dt>
                        <dd>
                            <?= (int) $sepatu['stok_sepatu'] ?> pasang
                        </dd>

                        <dt>Deskripsi</dt>
                        <dd>
                            <?= nl2br(h($sepatu['deskripsi_sepatu'])) ?>
                        </dd>

                    </dl>

                    <!-- Tombol aksi -->
                    <div class="actions">
                        <a
                            class="btn"
                            href="edit.php?id=<?= (int) $sepatu['id'] ?>"
                        >
                            Edit sepatu
                        </a>

                        <a
                            class="btn secondary"
                            href="index.php"
                        >
                            Kembali ke katalog
                        </a>

                        <a
                            class="btn secondary"
                            href="hapus.php?id=<?= (int) $sepatu['id'] ?>"
                        >
                            Hapus
                        </a>
                    </div>

                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="footer">
        SoleSpace · Praktikum PAW Modul 2
    </footer>

</body>
</html>
