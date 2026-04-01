<?php

session_start();
require_once __DIR__.'/../../config/connection.php';
require_once __DIR__.'/../../src/actions.php';
require_once __DIR__.'/../../src/core.php';
require_once __DIR__.'/../../src/auth.php';

require_user();

$pdo = get_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];
    $id_user = $_SESSION['user']['id'];

    $result = save_peminjaman($pdo, $id_user, $id_barang, $jumlah);

    $_SESSION['notification'] = [
        'type' => $result['success'] ? 'success' : 'error',
        'message' => $result['message'],
    ];

    header('Location: /user/dashboard.php');
    exit();
}
