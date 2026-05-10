<?php
session_start();
require_once __DIR__ . '/../../src/classes/Barang.php';
require_once __DIR__ . '/../../src/classes/Auth.php';

$auth = new Auth();
$auth->requireAdmin();

$barangModel = new Barang();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'tambah') {
        $nama_barang = $_POST['nama_barang'];
        $stok = (int) $_POST['stok'];
        $status = $_POST['status'];
        
        $result = $barangModel->save($nama_barang, $stok, $status);
        
        $_SESSION['notification'] = [
            'type' => $result['success'] ? 'success' : 'error',
            'message' => $result['message']
        ];
        header('Location: /admin/barang.php');
        exit();

    } elseif ($action === 'edit') {
        $id = (int) $_POST['id'];
        $nama_barang = $_POST['nama_barang'];
        $stok = (int) $_POST['stok'];
        $status = $_POST['status'];
        
        $result = $barangModel->update($id, $nama_barang, $stok, $status);
        
        $_SESSION['notification'] = [
            'type' => $result['success'] ? 'success' : 'error',
            'message' => $result['message']
        ];
        header('Location: /admin/barang.php');
        exit();

    } elseif ($action === 'hapus') {
        $id = (int) $_POST['id'];
        $nama_barang = $_POST['nama_barang'] ?? 'Barang';
        
        $result = $barangModel->delete($id);
        
        if ($result['success']) {
            $_SESSION['notification'] = [
                'type' => 'warning',
                'message' => 'Barang "' . htmlspecialchars($nama_barang) . '" berhasil dihapus!'
            ];
        } else {
            $_SESSION['notification'] = [
                'type' => 'error',
                'message' => $result['message']
            ];
        }
        header('Location: /admin/barang.php');
        exit();
    }
}

$barang = $barangModel->getAll();

$content = __DIR__ . '/../../views/admin/barang/barang_content.php';
require __DIR__ . '/../../views/layouts/main.php';
?>