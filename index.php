
<?php
require 'koneksi.php';

// Mengambil kata kunci pencarian
$cari = trim($_GET['cari'] ?? '');
$kata = mysqli_real_escape_string($conn, $cari);

// Query untuk mencari data sepatu
$sql = "
    SELECT *
    FROM sepatu
    WHERE nama_sepatu LIKE '%$kata%'
        OR merek_sepatu LIKE '%$kata%'
        OR kategori_sepatu LIKE '%$kata%'
    ORDER BY id DESC
";

$hasil = mysqli_query($conn, $sql);

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

// Menghitung jumlah hasil pencarian
$jumlah = mysqli_num_rows($hasil);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SoleSpace — Katalog Sepatu</title>

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

        <!-- Bagian pembuka -->
        <section class="hero">
            <p class="eyebrow">Find your everyday fit</p>

            <h1>
                Temukan langkahmu,<br>
                mulai dari sepatu yang tepat.
            </h1>

            <p>
                Kelola katalog sepatu rumah tangga dalam satu tempat.
                Cari produk, cek stok, dan perbarui informasi dengan mudah.
            </p>
        </section>

        <!-- Notifikasi perubahan data -->
        <?php if (isset($_GET['pesan'])): ?>
            <div class="notice">
                Perubahan data sepatu berhasil disimpan.
            </div>
        <?php endif; ?>

        <!-- Toolbar dan pencarian -->
        <div class="toolbar">

            <div>
                <p class="eyebrow">Sepatu collection</p>
                <h2>Katalog sepatu</h2>
            </div>

            <form class="search" method="get">

                <input
                    type="search"
                    name="cari"
                    placeholder="Cari nama, merek, kategori..."
                    value="<?= h($cari) ?>"
                >

                <button class="btn" type="submit">
                    Cari
                </button>

                <?php if ($cari !== ''): ?>
                    <a class="btn secondary" href="index.php">
                        Reset
                    </a>
                <?php endif; ?>

            </form>

        </div>

        <!-- Jumlah hasil pencarian -->
        <p class="meta">
            Jumlah hasil: <?= $jumlah ?> produk
        </p>

        <!-- Kondisi ketika data tidak ditemukan -->
        <?php if ($jumlah === 0): ?>

            <div class="empty">
                <h3>Sepatu belum ditemukan</h3>

                <p>
                    Coba kata kunci lain atau tambahkan sepatu baru.
                </p>

                <a class="btn" href="tambah.php">
                    + Tambah Sepatu
                </a>
            </div>

        <?php else: ?>

            <!-- Daftar katalog sepatu -->
            <div class="cards">

                <?php while ($sepatu = mysqli_fetch_assoc($hasil)): ?>

                    <article class="product-card">

                        <!-- Ilustrasi sepatu -->
                        <div class="product-art" aria-hidden="true">
                            👟
                        </div>

                        <!-- Informasi produk -->
                        <span class="pill">
                            <?= h($sepatu['kategori_sepatu']) ?>
                        </span>

                        <h3>
                            <?= h($sepatu['nama_sepatu']) ?>
                        </h3>

                        <p class="meta">
                            <?= h($sepatu['merek_sepatu']) ?>
                            ·
                            <?= h($sepatu['tipe_sepatu']) ?>
                        </p>

                        <p class="price">
                            <?= rupiah($sepatu['harga_sepatu']) ?>
                        </p>

                        <p class="stock">
                            Stok tersedia:
                            <?= (int) $sepatu['stok_sepatu'] ?>
                        </p>

                        <!-- Tombol aksi produk -->
                        <div class="card-actions">

                            <a href="detail.php?id=<?= (int) $sepatu['id'] ?>">
                                Lihat detail
                            </a>

                            <a href="edit.php?id=<?= (int) $sepatu['id'] ?>">
                                Edit
                            </a>

                            <a href="hapus.php?id=<?= (int) $sepatu['id'] ?>">
                                Hapus
                            </a>

                        </div>

                    </article>

                <?php endwhile; ?>

            </div>

        <?php endif; ?>

    </main>

    <!-- Footer -->
    <footer class="footer">
        SoleSpace · Praktikum PAW Modul 2 · PHP & MySQL
    </footer>

</body>
</html>
