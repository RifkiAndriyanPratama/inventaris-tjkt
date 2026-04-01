<?php
session_start();
require_once __DIR__.'/../../config/connection.php';
require_once __DIR__.'/../../src/actions.php';
require_once __DIR__.'/../../src/core.php';
require_once __DIR__.'/../../src/auth.php';

if (!is_logged_in() || !is_admin()) {
    header('Location: /login.php');
    exit();
}

$pdo = get_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'tambah') {
        $id_user = $_POST['id_user'];
        $id_barang = $_POST['id_barang'];
        $jumlah = $_POST['jumlah'];
        
        $result = save_peminjaman($pdo, $id_user, $id_barang, $jumlah);
        
        $_SESSION['notification'] = [
            'type' => $result['success'] ? 'success' : 'error',
            'message' => $result['message']
        ];
        
        header('Location: /admin/peminjaman.php');
        exit();
        
    } elseif ($action === 'edit') {
        $id = $_POST['id'];
        $jumlah = $_POST['jumlah'];
        
        $result = update_peminjaman($pdo, $id, $jumlah);
        
        $_SESSION['notification'] = [
            'type' => $result['success'] ? 'success' : 'error',
            'message' => $result['message']
        ];
        
        header('Location: /admin/peminjaman.php');
        exit();
        
    } elseif ($action === 'hapus') {
        $id = $_POST['id'];
        $nama_barang = $_POST['nama_barang'] ?? 'peminjaman';
        
        $result = delete_peminjaman($pdo, $id);
        
        $_SESSION['notification'] = [
            'type' => $result['success'] ? 'warning' : 'error',
            'message' => $result['success'] 
                ? 'Peminjaman "' . htmlspecialchars($nama_barang) . '" berhasil dihapus!' 
                : $result['message']
        ];
        
        header('Location: /admin/peminjaman.php');
        exit();
        
    } elseif ($action === 'approve') {
        $id = $_POST['id'];
        $result = update_status_peminjaman($pdo, $id, 'dipinjam');
        
        // return JSON
        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
        
    } elseif ($action === 'tolak') {
        $id = $_POST['id'];
        $result = update_status_peminjaman($pdo, $id, 'ditolak');
        
        // return JSON
        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
        
    } elseif ($action === 'kembali') {
        $id = $_POST['id'];
        
        // Ambil jumlah dari database
        $stmt = $pdo->prepare('SELECT jumlah FROM peminjaman WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $jumlah = $stmt->fetchColumn();
        
        $result = kembalikan_barang($pdo, $id, $jumlah);
        
        // return JSON
        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
    }
}

$peminjaman = get_all_peminjaman($pdo);
$content = __DIR__ . '/../../views/admin/peminjaman/peminjaman_content.php';
require __DIR__ . '/../../views/layouts/main.php';