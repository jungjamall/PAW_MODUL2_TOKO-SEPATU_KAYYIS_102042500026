
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

// Menyimpan data sepatu ke variabel
$kode = $sepatu['kode_sepatu'];
$nama = $sepatu['nama_sepatu'];
$brand = $sepatu['merek_sepatu'];
$kategori = $sepatu['kategori_sepatu'];
$jenis = $sepatu['tipe_sepatu'];
$harga = $sepatu['harga_sepatu'];
$stok = $sepatu['stok_sepatu'];
$deskripsi = $sepatu['deskripsi_sepatu'];

$pesan = '';

// Proses ketika tombol simpan ditekan
if (isset($_POST['simpan'])) {

    // Mengambil data dari form
    $kode = trim($_POST['kode_sepatu'] ?? '');
    $nama = trim($_POST['nama_sepatu'] ?? '');
    $brand = trim($_POST['merek_sepatu'] ?? '');
    $kategori = trim($_POST['kategori_sepatu'] ?? '');
    $jenis = trim($_POST['tipe_sepatu'] ?? '');
    $harga = trim($_POST['harga_sepatu'] ?? '');
    $stok = trim($_POST['stok_sepatu'] ?? '');
    $deskripsi = trim($_POST['deskripsi_sepatu'] ?? '');

    // Validasi kolom wajib
    if (
        $kode === '' ||
        $nama === '' ||
        $brand === '' ||
        $kategori === '' ||
        $jenis === '' ||
        $deskripsi === ''
    ) {
        $pesan = 'Semua kolom wajib diisi.';
    }

    // Validasi harga
    elseif (
        !is_numeric($harga) ||
        $harga <= 0 ||
        $harga > 9999999999
    ) {
        $pesan = 'Harga harus berupa angka positif tanpa Rp atau titik.';
    }

    // Validasi stok
    elseif (
        filter_var($stok, FILTER_VALIDATE_INT) === false ||
        $stok < 0
    ) {
        $pesan = 'Stok harus berupa bilangan bulat nol atau lebih.';
    }

    else {

        // Memeriksa apakah kode sepatu sudah digunakan
        $stmt = mysqli_prepare(
            $conn,
            'SELECT id FROM sepatu
             WHERE kode_sepatu = ? AND id <> ?'
        );

        mysqli_stmt_bind_param($stmt, 'si', $kode, $id);
        mysqli_stmt_execute($stmt);

        $cek = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($cek) > 0) {
            $pesan = 'Kode sepatu sudah digunakan sepatu lain.';
        }

        else {

            // Memperbarui data sepatu
            $stmt = mysqli_prepare(
                $conn,
                'UPDATE sepatu SET
                    kode_sepatu = ?,
                    nama_sepatu = ?,
                    merek_sepatu = ?,
                    kategori_sepatu = ?,
                    tipe_sepatu = ?,
                    harga_sepatu = ?,
                    stok_sepatu = ?,
                    deskripsi_sepatu = ?
                 WHERE id = ?'
            );

            mysqli_stmt_bind_param(
                $stmt,
                'sssssdisi',
                $kode,
                $nama,
                $brand,
                $kategori,
                $jenis,
                $harga,
                $stok,
                $deskripsi,
                $id
            );

            // Mengecek hasil pembaruan data
            if (mysqli_stmt_execute($stmt)) {
                header('Location: detail.php?id=' . $id . '&pesan=1');
                exit;
            }

            $pesan = 'Sepatu gagal diperbarui. Periksa kembali data.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Edit Produk — SoleSpace</title>

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

        <p class="eyebrow">Sepatu management</p>

        <h1 class="page-title">Edit sepatu</h1>

        <p class="meta">
            Perbarui informasi sepatu di bawah ini.
        </p>

        <section class="panel">

            <!-- Menampilkan pesan kesalahan -->
            <?php if ($pesan !== ''): ?>
                <div class="error">
                    <?= h($pesan) ?>
                </div>
            <?php endif; ?>

            <!-- Form edit sepatu -->
            <form method="post">

                <div class="form-grid">

                    <div>
                        <label for="kode">Kode sepatu</label>
                        <input
                            id="kode"
                            name="kode_sepatu"
                            maxlength="20"
                            required
                            value="<?= h($kode) ?>"
                        >
                    </div>

                    <div>
                        <label for="nama">Nama sepatu</label>
                        <input
                            id="nama"
                            name="nama_sepatu"
                            maxlength="100"
                            required
                            value="<?= h($nama) ?>"
                        >
                    </div>

                    <div>
                        <label for="brand">Merek</label>
                        <input
                            id="brand"
                            name="merek_sepatu"
                            maxlength="50"
                            required
                            value="<?= h($brand) ?>"
                        >
                    </div>

                    <div>
                        <label for="kategori">Kategori sepatu</label>

                        <select
                            id="kategori"
                            name="kategori_sepatu"
                            required
                        >
                            <option value="">Pilih kategori sepatu</option>

                            <?php
                            foreach (
                                ['Sneakers', 'Running', 'Casual', 'Formal', 'Sandals', 'Boots']
                                as $opt
                            ):
                            ?>
                                <option
                                    value="<?= h($opt) ?>"
                                    <?= $kategori === $opt ? 'selected' : '' ?>
                                >
                                    <?= h($opt) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div>
                        <label for="jenis">Model sepatu</label>

                        <select
                            id="jenis"
                            name="tipe_sepatu"
                            required
                        >
                            <option value="">Pilih model sepatu</option>

                            <?php
                            foreach (
                                ['Low-top', 'High-top', 'Slip-on', 'Loafer', 'Trail', 'Court']
                                as $opt
                            ):
                            ?>
                                <option
                                    value="<?= h($opt) ?>"
                                    <?= $jenis === $opt ? 'selected' : '' ?>
                                >
                                    <?= h($opt) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div>
                        <label for="harga">Harga (angka saja)</label>
                        <input
                            id="harga"
                            name="harga_sepatu"
                            type="number"
                            min="1"
                            step="1"
                            required
                            value="<?= h($harga) ?>"
                        >
                    </div>

                    <div>
                        <label for="stok">Stok</label>
                        <input
                            id="stok"
                            name="stok_sepatu"
                            type="number"
                            min="0"
                            step="1"
                            required
                            value="<?= h($stok) ?>"
                        >
                    </div>

                    <div class="full">
                        <label for="deskripsi">Deskripsi sepatu</label>
                        <textarea
                            id="deskripsi"
                            name="deskripsi_sepatu"
                            required
                        ><?= h($deskripsi) ?></textarea>
                    </div>

                </div>

                <!-- Tombol aksi -->
                <div class="actions">
                    <button
                        class="btn"
                        name="simpan"
                        type="submit"
                    >
                        Simpan perubahan
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
