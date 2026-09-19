<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul'] ?? '');
    $pengarang = trim($_POST['pengarang'] ?? '');
    $tahun = trim($_POST['tahun'] ?? '');
    $isbn = trim($_POST['isbn'] ?? '');
    $stok = trim($_POST['stok'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');

    if ($judul === '' || $pengarang === '' || $tahun === '' || $stok === '') {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => 'Data wajib diisi dengan lengkap.'
        ];

        header('Location: tambah.php');
        exit;
    }

    if ($isbn !== '' && !preg_match('/^[0-9-]+$/', $isbn)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'ISBN hanya boleh berisi angka dan tanda hubung.'
    ];

    header('Location: tambah.php');
    exit;
}

    $buku = [
        'judul' => $judul,
        'pengarang' => $pengarang,
        'tahun' => $tahun,
        'isbn' => $isbn,
        'stok' => $stok,
        'kategori' => $kategori
    ];

    if (!isset($_SESSION['buku'])) {
        $_SESSION['buku'] = [];
    }

    $_SESSION['buku'][] = $buku;

    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => 'Buku berhasil ditambahkan.'
    ];

    header('Location: list.php');
    exit;
}

header('Location: tambah.php');
exit;