<?php

require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

$page_title = "Pengembalian Buku";

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$sqlDasar = "SELECT p.id, b.judul, a.nama,
                    p.tanggal_pinjam, p.tanggal_jatuh_tempo
             FROM peminjaman p
             JOIN buku b ON b.id = p.buku_id
             JOIN anggota a ON a.id = p.anggota_id
             WHERE p.status = 'dipinjam'";

$stmt = $pdo->query($sqlDasar);
$peminjamanAktif = $stmt->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/../includes/header.php';
?>

<h1>Pengembalian Buku</h1>

<?php if ($flash): ?>
    <p class="flash flash-<?php echo e($flash['type']); ?>">
        <?php echo e($flash['pesan']); ?>
    </p>
<?php endif; ?>

<?php if (empty($peminjamanAktif)): ?>

    <p class="flash flash-info">
        Tidak ada buku yang sedang dipinjam.
    </p>

<?php else: ?>

    <table>
        <thead>
    <tr>
        <th>ID</th>
        <th>Nama Anggota</th>
        <th>Judul Buku</th>
        <th>Tanggal Pinjam</th>
        <th>Tanggal Jatuh Tempo</th>
        <th>Aksi</th>
    </tr>
        </thead>

        <tbody>
            <?php foreach ($peminjamanAktif as $peminjaman): ?>
                <tr>
                    <td><?php echo (int) $peminjaman['id']; ?></td>

                    <td>
                        <?php echo e($peminjaman['nama']); ?>
                    </td>

                    <td>
                        <?php echo e($peminjaman['judul']); ?>
                    </td>

                    <td>
                        <?php echo e($peminjaman['tanggal_pinjam']); ?>
                    </td>

                    <td>
                        <?php echo e($peminjaman['tanggal_jatuh_tempo'] ?? '-'); ?>
                    </td>

                    <td>
                        <form
                            method="post"
                            action="proses_kembali.php"
                            style="display: inline;"
                        >
                            <?php echo csrf_field(); ?>

                            <input
                                type="hidden"
                                name="id"
                                value="<?php echo (int) $peminjaman['id']; ?>"
                            >

                            <button type="submit">
                                Kembalikan
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>

<?php
include __DIR__ . '/../includes/footer.php';
?>