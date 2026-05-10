<?php
session_start();
require_once __DIR__ . '/../../src/classes/Peminjaman.php';
require_once __DIR__ . '/../../src/classes/Auth.php';

$auth = new Auth();
$auth->requireUser();

$peminjamanModel = new Peminjaman();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_barang = (int) $_POST['id_barang'];
    $jumlah = (int) $_POST['jumlah'];
    $id_user = (int) $_SESSION['user']['id'];

    $result = $peminjamanModel->save($id_user, $id_barang, $jumlah);

    $_SESSION['notification'] = [
        'type' => $result['success'] ? 'success' : 'error',
        'message' => $result['message'],
    ];

    header('Location: /user/dashboard.php');
    exit();
}
?>