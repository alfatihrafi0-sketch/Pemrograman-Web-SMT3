<?php
$page_title = "Daftar Buku";

require_once __DIR__ . '/../includes/koneksi.php';

$perPage = 5;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM buku WHERE judul ILIKE :kw");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = $hitung->fetchColumn();

    $stmt = $pdo->prepare(
        "SELECT * FROM buku
         WHERE judul ILIKE :kw
         ORDER BY id DESC
         LIMIT :limit OFFSET :offset"
    );

    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $totalRows = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();

    $stmt = $pdo->prepare(
        "SELECT * FROM buku
         ORDER BY id DESC
         LIMIT :limit OFFSET :offset"
    );
}

$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$buku_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalPages = max(1, (int) ceil($totalRows / $perPage));


include __DIR__ . '/../includes/header.php';
?>

<section>
    <h2>Daftar Buku</h2>
    
<?php if (!empty($_SESSION['flash'])): ?>
    <p>
        <?php echo htmlspecialchars($_SESSION['flash']['pesan']); ?>
    </p>

    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<form method="get" action="list.php">
    <span>
        <label for="search-input">Cari Judul Buku</label><br>
        <input
            type="text"
            id="search-input"
            name="q"
            value="<?php echo $keyword; ?>"
            placeholder="Ketik judul buku..."
        >
    </span>

    <button type="submit">Cari</button>
</form>

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
               <?php foreach ($buku_list as $buku): ?>
     <tr>
        <td><?php echo htmlspecialchars($buku['judul']); ?></td>
        <td><?php echo htmlspecialchars($buku['pengarang']); ?></td>
        <td><?php echo htmlspecialchars($buku['tahun']); ?></td>
        <td><?php echo htmlspecialchars($buku['stok']); ?></td>
        <td><?php echo htmlspecialchars($buku['kategori']); ?></td>
        <td>
            <a href="edit.php?id=<?php echo $buku['id']; ?>" class="btn-edit">Edit</a>
            
        <form class="form-hapus" method="post" action="hapus.php" style="display:inline;">
             <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
             <button type="submit">Hapus</button>
        </form>
        </td>
    </tr>
<?php endforeach; ?>
            </tbody>
        </table>

<nav class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a
            href="list.php?page=<?php echo $i; ?><?php echo $keyword !== '' ? '&q=' . urlencode($keyword) : ''; ?>"
            class="<?php echo $i === $page ? 'active' : ''; ?>"
        >
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
</nav>

    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>