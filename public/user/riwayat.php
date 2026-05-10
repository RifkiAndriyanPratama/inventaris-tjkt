<?php
session_start();
require_once __DIR__ . '/../../src/classes/Peminjaman.php';
require_once __DIR__ . '/../../src/classes/Auth.php';

$auth = new Auth();
$auth->requireUser();

$userId = (int) $_SESSION['user']['id'];

$peminjamanModel = new Peminjaman();

// Ambil riwayat peminjaman user
$riwayat = $peminjamanModel->getByUser($userId);

// Statistik
$totalPeminjaman = count($riwayat);
$totalPending = count(array_filter($riwayat, fn($item) => $item['status_pinjam'] === 'pending'));
$totalDipinjam = count(array_filter($riwayat, fn($item) => $item['status_pinjam'] === 'dipinjam'));
$totalDikembalikan = count(array_filter($riwayat, fn($item) => $item['status_pinjam'] === 'dikembalikan'));
$totalDitolak = count(array_filter($riwayat, fn($item) => $item['status_pinjam'] === 'ditolak'));

$content = __DIR__ . '/../../views/user/riwayat.php';
require __DIR__ . '/../../views/layouts/user_layout.php';
?>