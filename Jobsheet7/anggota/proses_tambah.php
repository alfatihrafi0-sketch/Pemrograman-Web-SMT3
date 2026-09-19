<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $no_anggota = trim($_POST['no_anggota'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $no_hp = trim($_POST['no_hp'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($nama === '' || $no_anggota === '') {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => 'Nama dan nomor anggota wajib diisi.'
        ];

        header('Location: tambah.php');
        exit;
    }

    if ($no_hp !== '' && !preg_match('/^[0-9+\-\s()]+$/', $no_hp)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'No. HP hanya boleh berisi angka dan karakter nomor telepon yang valid.'
    ];

    header('Location: tambah.php');
    exit;
    }

    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Format email tidak valid.'
    ];

    header('Location: tambah.php');
    exit;
    }

    $anggota = [
        'nama' => $nama,
        'no_anggota' => $no_anggota,
        'alamat' => $alamat,
        'no_hp' => $no_hp,
        'email' => $email
    ];

    if (!isset($_SESSION['anggota'])) {
        $_SESSION['anggota'] = [];
    }

    $_SESSION['anggota'][] = $anggota;

    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => 'Anggota berhasil ditambahkan.'
    ];

    header('Location: list.php');
    exit;
}

header('Location: tambah.php');
exit;