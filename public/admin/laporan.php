<?php

session_start();
require_once __DIR__.'/../../config/connection.php';
require_once __DIR__.'/../../src/actions.php';
require_once __DIR__.'/../../src/core.php';
require_once __DIR__.'/../../src/auth.php';

require_admin();

$pdo = get_db();

// Filter berdasarkan bulan (format: YYYY-MM)
$filter_bulan = $_GET['bulan'] ?? date('Y-m');

// Ambil data peminjaman
$peminjaman = get_all_peminjaman($pdo);

// Filter berdasarkan bulan
if (! empty($filter_bulan)) {
    $peminjaman = array_filter($peminjaman, function ($item) use ($filter_bulan) {
        return substr($item['tanggal_pinjam'], 0, 7) === $filter_bulan;
    });
}

// Statistik
$totalPeminjaman = count($peminjaman);
$totalBarangDipinjam = array_sum(array_column($peminjaman, 'jumlah'));

// Statistik per status
$pending = count(array_filter($peminjaman, fn ($item) => $item['status_pinjam'] === 'pending'));
$dipinjam = count(array_filter($peminjaman, fn ($item) => $item['status_pinjam'] === 'dipinjam'));
$dikembalikan = count(array_filter($peminjaman, fn ($item) => $item['status_pinjam'] === 'dikembalikan'));
$ditolak = count(array_filter($peminjaman, fn ($item) => $item['status_pinjam'] === 'ditolak'));

// Barang terpopuler
$barangPopuler = [];
foreach ($peminjaman as $p) {
    $nama = $p['nama_barang'];
    $barangPopuler[$nama] = ($barangPopuler[$nama] ?? 0) + $p['jumlah'];
}
arsort($barangPopuler);
$topBarang = key($barangPopuler) ?? '-';

// Peminjam aktif
$peminjamAktif = [];
foreach ($peminjaman as $p) {
    $nama = $p['nama'];
    $peminjamAktif[$nama] = ($peminjamAktif[$nama] ?? 0) + 1;
}
arsort($peminjamAktif);
$topPeminjam = key($peminjamAktif) ?? '-';

// Daftar bulan untuk dropdown
$months = [];
for ($i = 1; $i <= 12; $i++) {
    $months[] = date('Y-m', strtotime("2024-$i-01"));
}
// Tambah tahun ini juga
$currentYear = date('Y');
for ($i = 1; $i <= 12; $i++) {
    $months[] = date('Y-m', strtotime("$currentYear-$i-01"));
}
$months = array_unique($months);
sort($months);

$content = __DIR__.'/../../views/admin/laporan.php';
require __DIR__.'/../../views/layouts/main.php';
