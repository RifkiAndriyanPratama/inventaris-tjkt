<?php
session_start();
require_once __DIR__ . '/../../src/classes/Peminjaman.php';
require_once __DIR__ . '/../../src/classes/Auth.php';

$auth = new Auth();
$auth->requireAdmin();

$peminjamanModel = new Peminjaman(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'tambah') {
        $id_user = (int) $_POST['id_user'];
        $id_barang = (int) $_POST['id_barang'];
        $jumlah = (int) $_POST['jumlah'];
        
        $result = $peminjamanModel->save($id_user, $id_barang, $jumlah);
        
        $_SESSION['notification'] = [
            'type' => $result['success'] ? 'success' : 'error',
            'message' => $result['message']
        ];
        
        header('Location: /admin/peminjaman.php');
        exit();
        
    } elseif ($action === 'edit') {
        $id = (int) $_POST['id'];
        $jumlah = (int) $_POST['jumlah'];
        
        $result = $peminjamanModel->update($id, $jumlah);
        
        $_SESSION['notification'] = [
            'type' => $result['success'] ? 'success' : 'error',
            'message' => $result['message']
        ];
        
        header('Location: /admin/peminjaman.php');
        exit();
        
    } elseif ($action === 'hapus') {
        $id = (int) $_POST['id'];
        $nama_barang = $_POST['nama_barang'] ?? 'peminjaman';
        
        $result = $peminjamanModel->delete($id);
        
        $_SESSION['notification'] = [
            'type' => $result['success'] ? 'warning' : 'error',
            'message' => $result['success'] 
                ? 'Peminjaman "' . htmlspecialchars($nama_barang) . '" berhasil dihapus!' 
                : $result['message']
        ];
        
        header('Location: /admin/peminjaman.php');
        exit();
        
    } elseif ($action === 'approve') {
        $id = (int) $_POST['id'];
        $result = $peminjamanModel->updateStatus($id, 'dipinjam');
        
        // return JSON untuk AJAX
        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
        
    } elseif ($action === 'tolak') {
        $id = (int) $_POST['id'];
        $result = $peminjamanModel->updateStatus($id, 'ditolak');
        
        // return JSON untuk AJAX
        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
        
    } elseif ($action === 'kembali') {
        $id = (int) $_POST['id'];
        
        // Ambil jumlah dari database
        $data = $peminjamanModel->getById($id);
        $jumlah = $data['jumlah'] ?? 0;
        
        $result = $peminjamanModel->kembalikan($id, $jumlah);
        
        // return JSON untuk AJAX
        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
    }
}

$peminjaman = $peminjamanModel->getAll(); 

$content = __DIR__ . '/../../views/admin/peminjaman/peminjaman_content.php';
require __DIR__ . '/../../views/layouts/main.php';
?>