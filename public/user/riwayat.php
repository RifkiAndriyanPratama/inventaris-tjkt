<?php

session_start();
require_once __DIR__.'/../../config/connection.php';
require_once __DIR__.'/../../src/actions.php';
require_once __DIR__.'/../../src/core.php';
require_once __DIR__.'/../../src/auth.php';

require_user();

$pdo = get_db();
$userId = $_SESSION['user']['id'];

// Ambil riwayat peminjaman user
$riwayat = get_peminjaman_by_user($pdo, $userId);

// Statistik
$totalPeminjaman = count($riwayat);
$totalPending = count(array_filter($riwayat, fn ($item) => $item['status_pinjam'] === 'pending'));
$totalDipinjam = count(array_filter($riwayat, fn ($item) => $item['status_pinjam'] === 'dipinjam'));
$totalDikembalikan = count(array_filter($riwayat, fn ($item) => $item['status_pinjam'] === 'dikembalikan'));
$totalDitolak = count(array_filter($riwayat, fn ($item) => $item['status_pinjam'] === 'ditolak'));

$content = __DIR__.'/../../views/user/riwayat.php';
require __DIR__.'/../../views/layouts/user_layout.php';
