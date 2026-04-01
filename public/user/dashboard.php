<?php

session_start();
require_once __DIR__.'/../../config/connection.php';
require_once __DIR__.'/../../src/actions.php';
require_once __DIR__.'/../../src/core.php';
require_once __DIR__.'/../../src/auth.php';

require_user(); // Cek login & role user

$pdo = get_db();
$userId = $_SESSION['user']['id'];

// Ambil riwayat peminjaman user ini
$riwayat = get_peminjaman_by_user($pdo, $userId);

// Statistik
$totalPeminjaman = count($riwayat);
$totalPending = count(array_filter($riwayat, fn ($item) => $item['status_pinjam'] === 'pending'));
$totalDipinjam = count(array_filter($riwayat, fn ($item) => $item['status_pinjam'] === 'dipinjam'));
$totalDikembalikan = count(array_filter($riwayat, fn ($item) => $item['status_pinjam'] === 'dikembalikan'));

// Ambil data barang untuk form peminjaman
$barang = get_all_barang($pdo);
$barangTersedia = array_filter($barang, fn ($item) => $item['stok'] > 0);

$content = __DIR__.'/../../views/user/dashboard.php';
require __DIR__.'/../../views/layouts/user_layout.php';
