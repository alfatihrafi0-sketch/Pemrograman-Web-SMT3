<?php

session_start();

require __DIR__ . '/../includes/koneksi.php';

$id = $_POST['id'] ?? null;
$judul = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun = trim($_POST['tahun'] ?? '');
$isbn = trim($_POST['isbn'] ?? '');
$stok = trim($_POST['stok'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');

$errors = [];

if (!$id) {
    header('Location: list.php');
    exit;
}

if ($judul === '') {
    $errors[] = 'Judul wajib diisi.';
}

if ($pengarang === '') {
    $errors[] = 'Pengarang wajib diisi.';
}

if ($tahun === '' || !is_numeric($tahun)) {
    $errors[] = 'Tahun harus berupa angka.';
}

if ($stok === '' || !is_numeric($stok)) {
    $errors[] = 'Stok harus berupa angka.';
}

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'pesan' => implode(' ', $errors)
    ];

    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE buku SET
        judul = :judul,
        pengarang = :pengarang,
        tahun = :tahun,
        isbn = :isbn,
        stok = :stok,
        kategori = :kategori
     WHERE id = :id"
);

$stmt->execute([
    'judul' => $judul,
    'pengarang' => $pengarang,
    'tahun' => (int) $tahun,
    'isbn' => $isbn,
    'stok' => (int) $stok,
    'kategori' => $kategori,
    'id' => $id
]);

$_SESSION['flash'] = [
    'pesan' => 'Data buku berhasil diperbarui.'
];

header('Location: list.php');
exit;