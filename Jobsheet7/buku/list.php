<?php
$page_title = "Daftar Buku";
include __DIR__ . '/../includes/header.php';
?>

<section>
    <h2>Daftar Buku</h2>
    
<?php if (!empty($_SESSION['flash'])): ?>
    <p>
        <?php echo htmlspecialchars($_SESSION['flash']['message']); ?>
    </p>

    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

    <div class="search-box">
        <label for="search-input">Cari Judul Buku</label>
        <input type="text" id="search-input" placeholder="Ketik judul buku...">
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($_SESSION['buku'] ?? [] as $buku): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($buku['judul']); ?></td>
                        <td><?php echo htmlspecialchars($buku['pengarang']); ?></td>
                        <td><?php echo htmlspecialchars($buku['tahun']); ?></td>
                        <td><?php echo htmlspecialchars($buku['stok']); ?></td>
                        <td><?php echo htmlspecialchars($buku['kategori']); ?></td>
                        <td>-</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>