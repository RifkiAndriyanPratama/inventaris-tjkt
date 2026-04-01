<?php
session_start();
require_once __DIR__ . '/../../config/connection.php';
require_once __DIR__ . '/../../src/actions.php';
require_once __DIR__ . '/../../src/core.php';
require_once __DIR__ . '/../../src/auth.php';

if (!is_logged_in() || !is_admin()) {
    header('Location: /login.php');
    exit();
}

$pdo = get_db();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'tambah') {
        $nama_barang = $_POST['nama_barang'];
        $stok = $_POST['stok'];
        $status = $_POST['status'];
        
        if (save_barang($pdo, $nama_barang, $stok, $status)) {
            $_SESSION['notification'] = [
                'type' => 'success',
                'message' => 'Barang "' . htmlspecialchars($nama_barang) . '" berhasil ditambahkan!'
            ];
        } else {
            $_SESSION['notification'] = [
                'type' => 'error',
                'message' => 'Gagal menambahkan barang. Silakan coba lagi.'
            ];
        }
        header('Location: /admin/barang.php');
        exit();

    } elseif ($action === 'edit') {
        $id = $_POST['id'];
        $nama_barang = $_POST['nama_barang'];
        $stok = $_POST['stok'];
        $status = $_POST['status'];
        
        if (update_barang($pdo, $id, $nama_barang, $stok, $status)) {
            $_SESSION['notification'] = [
                'type' => 'success',
                'message' => 'Barang "' . htmlspecialchars($nama_barang) . '" berhasil diperbarui!'
            ];
        } else {
            $_SESSION['notification'] = [
                'type' => 'error',
                'message' => 'Gagal memperbarui barang. Silakan coba lagi.'
            ];
        }
        header('Location: /admin/barang.php');
        exit();

    } elseif ($action === 'hapus') {
        $id = $_POST['id'];
        $nama_barang = $_POST['nama_barang'] ?? 'Barang';
        
        if (delete_barang($pdo, $id)) {
            $_SESSION['notification'] = [
                'type' => 'warning',
                'message' => 'Barang "' . htmlspecialchars($nama_barang) . '" berhasil dihapus!'
            ];
        } else {
            $_SESSION['notification'] = [
                'type' => 'error',
                'message' => 'Gagal menghapus barang. Silakan coba lagi.'
            ];
        }
        header('Location: /admin/barang.php');
        exit();
    }
}

$barang = get_all_barang($pdo);

$content = __DIR__ . '/../../views/admin/barang/barang_content.php';
require __DIR__ . '/../../views/layouts/main.php';
?>