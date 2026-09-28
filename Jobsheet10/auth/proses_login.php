<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../includes/koneksi.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$errors = [];

if ($username === '') {
    $errors[] = "Username wajib diisi.";
}

if ($password === '') {
    $errors[] = "Password wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => implode(' ', $errors)
    ];

    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare(
    "SELECT * FROM users WHERE username = :username"
);

$stmt->execute([
    'username' => $username
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password'])) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => 'Username atau password salah.'
    ];

    header('Location: login.php');
    exit;
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['nama'] = $user['nama'];
$_SESSION['role'] = $user['role'];

$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => 'Login berhasil.'
];

header('Location: ../index.php');
exit;