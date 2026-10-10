<?php

require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

$page_title = "Peminjaman Baru";

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarAnggota = $pdo->query(
    "SELECT * FROM anggota ORDER BY nama"
)->fetchAll(PDO::FETCH_ASSOC);

$daftarBukuTersedia = $pdo->query(
    "SELECT * FROM buku WHERE stok > 0 ORDER BY judul"
)->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/../includes/header.php';
?>

<h1>Peminjaman Baru</h1>

<?php if ($flash): ?>
    <p class="flash flash-<?php echo e($flash['type']); ?>">
        <?php echo e($flash['pesan']); ?>
    </p>
<?php endif; ?>

<?php if (empty($daftarAnggota)): ?>

    <p class="flash flash-error">
        Belum ada data anggota. Tambahkan anggota terlebih dahulu.
    </p>

<?php elseif (empty($daftarBukuTersedia)): ?>

    <p class="flash flash-error">
        Tidak ada buku dengan stok tersedia saat ini.
    </p>

<?php else: ?>

    <form method="post" action="proses_tambah.php">

        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label for="anggota_id">Anggota</label>

            <select name="anggota_id" id="anggota_id" required>
                <option value="">-- Pilih Anggota --</option>

                <?php foreach ($daftarAnggota as $anggota): ?>
                    <option value="<?php echo (int) $anggota['id']; ?>">
                        <?php echo e($anggota['nama']); ?>
                        (<?php echo e($anggota['no_anggota']); ?>)
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div class="form-group">
            <label for="buku_id">Buku</label>

            <select name="buku_id" id="buku_id" required>
                <option value="">-- Pilih Buku --</option>

                <?php foreach ($daftarBukuTersedia as $buku): ?>
                    <option value="<?php echo (int) $buku['id']; ?>">
                        <?php echo e($buku['judul']); ?>
                        (Stok: <?php echo (int) $buku['stok']; ?>)
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <button type="submit">Simpan Peminjaman</button>

    </form>

<?php endif; ?>

<?php
include __DIR__ . '/../includes/footer.php';
?>