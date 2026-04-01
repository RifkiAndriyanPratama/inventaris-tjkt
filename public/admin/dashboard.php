<?php

session_start();
require_once __DIR__.'/../../config/connection.php';
require_once __DIR__.'/../../src/actions.php';
require_once __DIR__.'/../../src/core.php';
require_once __DIR__.'/../../src/auth.php';

require_admin();

$pdo = get_db();

// Statistik
$totalUsers = count(get_all_users($pdo));
$totalBarang = count(get_all_barang($pdo));
$totalPeminjaman = count(get_all_peminjaman($pdo));

// Peminjaman berdasarkan status
$peminjaman = get_all_peminjaman($pdo);
$pending = count(array_filter($peminjaman, fn ($item) => $item['status_pinjam'] === 'pending'));
$dipinjam = count(array_filter($peminjaman, fn ($item) => $item['status_pinjam'] === 'dipinjam'));
$dikembalikan = count(array_filter($peminjaman, fn ($item) => $item['status_pinjam'] === 'dikembalikan'));
$ditolak = count(array_filter($peminjaman, fn ($item) => $item['status_pinjam'] === 'ditolak'));

// Peminjaman terbaru (5 data)
$peminjamanTerbaru = array_slice($peminjaman, 0, 5);

// Barang dengan stok menipis (stok <= 5)
$barang = get_all_barang($pdo);
$stokMenipis = array_filter($barang, fn ($item) => $item['stok'] <= 5 && $item['stok'] > 0);
$stokHabis = array_filter($barang, fn ($item) => $item['stok'] == 0);

$content = __DIR__.'/../../views/admin/dashboard.php';
require __DIR__.'/../../views/layouts/main.php';

