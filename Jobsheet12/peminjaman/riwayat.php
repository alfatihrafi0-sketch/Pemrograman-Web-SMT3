<?php

require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

$page_title = "Riwayat Peminjaman";

$anggotaId = $_GET['anggota_id'] ?? '';

$daftarAnggota = $pdo->query(
    "SELECT * FROM anggota ORDER BY nama"
)->fetchAll(PDO::FETCH_ASSOC);

$riwayat = [];

if ($anggotaId !== '') {

    $stmt = $pdo->prepare(
        "SELECT b.judul,
                p.tanggal_pinjam,
                p.tanggal_kembali,
                p.status
         FROM peminjaman p
         JOIN buku b ON b.id = p.buku_id
         WHERE p.anggota_id = :id
         ORDER BY p.tanggal_pinjam DESC"
    );

    $stmt->execute([
        'id' => $anggotaId
    ]);

    $riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

include __DIR__ . '/../includes/header.php';
?>

<h1>Riwayat Peminjaman</h1>

<form method="get">

    <div class="form-group">

        <label for="anggota_id">Pilih Anggota</label>

        <select name="anggota_id" id="anggota_id">

            <option value="">-- Pilih Anggota --</option>

            <?php foreach ($daftarAnggota as $anggota): ?>

                <option
                    value="<?php echo (int) $anggota['id']; ?>"
                    <?php echo (string) $anggotaId === (string) $anggota['id'] ? 'selected' : ''; ?>
                >
                    <?php echo e($anggota['nama']); ?>
                    (<?php echo e($anggota['no_anggota']); ?>)
                </option>

            <?php endforeach; ?>

        </select>

    </div>

    <button type="submit">Lihat Riwayat</button>

</form>

<?php if ($anggotaId !== ''): ?>

    <?php if (empty($riwayat)): ?>

        <p class="flash flash-info">
            Belum ada riwayat peminjaman untuk anggota ini.
        </p>

    <?php else: ?>

        <table>

            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($riwayat as $r): ?>

                    <tr>

                        <td>
                            <?php echo e($r['judul']); ?>
                        </td>

                        <td>
                            <?php echo e($r['tanggal_pinjam']); ?>
                        </td>

                        <td>
                            <?php echo e($r['tanggal_kembali'] ?? '-'); ?>
                        </td>

                        <td>
                            <?php
                            echo $r['status'] === 'dipinjam'
                                ? 'Dipinjam'
                                : 'Selesai';
                            ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>

<?php endif; ?>

<?php
include __DIR__ . '/../includes/footer.php';
?>