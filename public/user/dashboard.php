<?php
session_start();
require_once __DIR__ . '/../../src/classes/Peminjaman.php';
require_once __DIR__ . '/../../src/classes/Barang.php';
require_once __DIR__ . '/../../src/classes/Auth.php';

$auth = new Auth();
$auth->requireUser();

$userId = $_SESSION['user']['id'];

$peminjamanModel = new Peminjaman();
$barangModel = new Barang();

// Ambil riwayat peminjaman user ini
$riwayat = $peminjamanModel->getByUser($userId);

// Statistik
$totalPeminjaman = count($riwayat);
$totalPending = count(array_filter($riwayat, fn($item) => $item['status_pinjam'] === 'pending'));
$totalDipinjam = count(array_filter($riwayat, fn($item) => $item['status_pinjam'] === 'dipinjam'));
$totalDikembalikan = count(array_filter($riwayat, fn($item) => $item['status_pinjam'] === 'dikembalikan'));

// Ambil data barang untuk form peminjaman
$allBarang = $barangModel->getAll();
$barangTersedia = array_filter($allBarang, fn($item) => $item['stok'] > 0);

$content = __DIR__ . '/../../views/user/dashboard.php';
require __DIR__ . '/../../views/layouts/user_layout.php';
?>