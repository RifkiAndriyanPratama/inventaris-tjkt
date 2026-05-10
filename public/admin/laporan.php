<?php
session_start();
require_once __DIR__ . '/../../src/classes/Peminjaman.php';
require_once __DIR__ . '/../../src/classes/Auth.php';

$auth = new Auth();
$auth->requireAdmin();

$peminjamanModel = new Peminjaman();

// Filter berdasarkan bulan (format: YYYY-MM)
$filter_bulan = $_GET['bulan'] ?? date('Y-m');

// Ambil data peminjaman
$allPeminjaman = $peminjamanModel->getAll();

// Filter berdasarkan bulan
$peminjaman = array_filter($allPeminjaman, function ($item) use ($filter_bulan) {
    return substr($item['tanggal_pinjam'], 0, 7) === $filter_bulan;
});

// Statistik
$totalPeminjaman = count($peminjaman);
$totalBarangDipinjam = array_sum(array_column($peminjaman, 'jumlah'));

// Statistik per status
$pending = count(array_filter($peminjaman, fn($item) => $item['status_pinjam'] === 'pending'));
$dipinjam = count(array_filter($peminjaman, fn($item) => $item['status_pinjam'] === 'dipinjam'));
$dikembalikan = count(array_filter($peminjaman, fn($item) => $item['status_pinjam'] === 'dikembalikan'));
$ditolak = count(array_filter($peminjaman, fn($item) => $item['status_pinjam'] === 'ditolak'));

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

// Daftar bulan untuk dropdown (tahun 2024 sampai tahun ini)
$months = [];
$startYear = 2024;
$currentYear = date('Y');

for ($year = $startYear; $year <= $currentYear; $year++) {
    for ($i = 1; $i <= 12; $i++) {
        $months[] = date('Y-m', strtotime("$year-$i-01"));
    }
}
$months = array_unique($months);
sort($months);

$content = __DIR__ . '/../../views/admin/laporan.php';
require __DIR__ . '/../../views/layouts/main.php';
?>