<?php
$page_title = "Daftar Anggota";
include __DIR__ . '/../includes/header.php';
?>

<section>
    <h2>Daftar Anggota</h2>

    <?php if (!empty($_SESSION['flash'])): ?>
    <p>
        <?php echo htmlspecialchars($_SESSION['flash']['message']); ?>
    </p>

    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

    <div class="search-box">
        <label for="search-input">Cari Nama Anggota</label>
        <input type="text" id="search-input" placeholder="Ketik nama anggota...">
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No. Anggota</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No. HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($_SESSION['anggota'] ?? [] as $anggota): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($anggota['no_anggota']); ?></td>
                        <td><?php echo htmlspecialchars($anggota['nama']); ?></td>
                        <td><?php echo htmlspecialchars($anggota['alamat']); ?></td>
                        <td><?php echo htmlspecialchars($anggota['no_hp']); ?></td>
                        <td>-</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>