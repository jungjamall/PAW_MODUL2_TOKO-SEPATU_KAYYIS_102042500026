
<?php
require 'koneksi.php';

// Fungsi untuk mengamankan output HTML
function h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
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

// Proses penghapusan sepatu
if (isset($_POST['hapus'])) {

    $stmt = mysqli_prepare(
        $conn,
        'DELETE FROM sepatu WHERE id = ?'
    );

    mysqli_stmt_bind_param($stmt, 'i', $id);

    // Mengecek hasil penghapusan
    if (mysqli_stmt_execute($stmt)) {
        header('Location: index.php?pesan=1');
        exit;
    }

    $pesan = 'Sepatu gagal dihapus. Silakan coba kembali.';
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hapus Produk — SoleSpace</title>

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

        <p class="eyebrow">Konfirmasi tindakan</p>

        <h1 class="page-title">Hapus sepatu?</h1>

        <section class="panel">

            <!-- Ilustrasi produk -->
            <div class="product-art" aria-hidden="true">
                👟
            </div>

            <!-- Informasi sepatu -->
            <h2>
                <?= h($sepatu['nama_sepatu']) ?>
            </h2>

            <p class="meta">
                <?= h($sepatu['merek_sepatu']) ?>
                ·
                <?= h($sepatu['kode_sepatu']) ?>
            </p>

            <p>
                Produk ini akan dihapus dari katalog.
                Data yang sudah dihapus tidak bisa dikembalikan.
            </p>

            <!-- Menampilkan pesan kesalahan -->
            <?php if (isset($pesan)): ?>
                <div class="error">
                    <?= h($pesan) ?>
                </div>
            <?php endif; ?>

            <!-- Form konfirmasi penghapusan -->
            <form method="post">

                <div class="actions">

                    <button
                        class="btn danger"
                        type="submit"
                        name="hapus"
                    >
                        Ya, hapus sepatu
                    </button>

                    <a
                        class="btn secondary"
                        href="detail.php?id=<?= $id ?>"
                    >
                        Batal
                    </a>

                </div>

            </form>

        </section>

    </main>

    <!-- Footer -->
    <footer class="footer">
        SoleSpace · Praktikum PAW Modul 2
    </footer>

</body>
</html>
