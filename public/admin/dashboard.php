<?php
session_start();
require_once __DIR__ . '/../../src/classes/User.php';
require_once __DIR__ . '/../../src/classes/Barang.php';
require_once __DIR__ . '/../../src/classes/Peminjaman.php';
require_once __DIR__ . '/../../src/classes/Auth.php';

$auth = new Auth();
$auth->requireAdmin();

$userModel = new User();
$barangModel = new Barang();
$peminjamanModel = new Peminjaman();

// Statistik
$totalUsers = count($userModel->getAll());
$totalBarang = count($barangModel->getAll());
$totalPeminjaman = count($peminjamanModel->getAll());

// Peminjaman berdasarkan status
$allPeminjaman = $peminjamanModel->getAll();
$pending = count(array_filter($allPeminjaman, fn($item) => $item['status_pinjam'] === 'pending'));
$dipinjam = count(array_filter($allPeminjaman, fn($item) => $item['status_pinjam'] === 'dipinjam'));
$dikembalikan = count(array_filter($allPeminjaman, fn($item) => $item['status_pinjam'] === 'dikembalikan'));
$ditolak = count(array_filter($allPeminjaman, fn($item) => $item['status_pinjam'] === 'ditolak'));

// Peminjaman terbaru (5 data)
$peminjamanTerbaru = array_slice($allPeminjaman, 0, 5);

// Barang dengan stok menipis (stok <= 5)
$allBarang = $barangModel->getAll();
$stokMenipis = array_filter($allBarang, fn($item) => $item['stok'] <= 5 && $item['stok'] > 0);
$stokHabis = array_filter($allBarang, fn($item) => $item['stok'] == 0);

$content = __DIR__ . '/../../views/admin/dashboard.php';
require __DIR__ . '/../../views/layouts/main.php';
?>