<?php
// Statistik
$totalBarang = count($barang);
$totalStok = array_sum(array_column($barang, 'stok'));
$barangBaik = count(array_filter($barang, fn($item) => ($item['status'] ?? 'baik') === 'baik'));
$barangRusak = count(array_filter($barang, fn($item) => ($item['status'] ?? '') === 'rusak'));
?>

<!-- Breadcrumb -->
<div class="flex items-center text-sm text-body/70 mb-4">
    <a href="/admin/dashboard.php" class="hover:text-brand transition-colors">Dashboard</a>
    <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-heading font-medium">Manajemen Barang</span>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-heading">Manajemen Barang</h1>
        <p class="text-sm text-body/70 mt-1">Kelola data inventaris barang TJKT</p>
    </div>
    <button onclick="openModal('modal-tambah')"
        class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-brand hover:bg-brand-strong rounded-xl transition-all duration-200 transform hover:scale-105 focus:ring-4 focus:ring-brand/30 shadow-lg shadow-brand/25">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Barang Baru
    </button>
</div>

<!-- Statistik Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-default p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-body/70">Total Barang</p>
                <p class="text-2xl font-bold text-heading mt-1"><?= $totalBarang ?></p>
            </div>
            <div class="w-10 h-10 bg-brand/10 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-default p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-body/70">Total Stok</p>
                <p class="text-2xl font-bold text-heading mt-1"><?= $totalStok ?></p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-default p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-body/70">Barang Baik</p>
                <p class="text-2xl font-bold text-green-600 mt-1"><?= $barangBaik ?></p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-default p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-body/70">Barang Rusak</p>
                <p class="text-2xl font-bold text-red-600 mt-1"><?= $barangRusak ?></p>
            </div>
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Search -->
<div class="bg-white rounded-xl border border-default p-4 mb-6">
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="w-5 h-5 text-body/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <input type="text" id="searchInput" placeholder="Cari barang..." 
            class="w-full pl-10 pr-4 py-2.5 border border-default rounded-lg text-sm focus:ring-2 focus:ring-brand/20 focus:border-brand transition">
    </div>
</div>

<!-- Table -->
<?php require 'barang_table.php'; ?>

<!-- Modals -->
<?php require 'modals/tambah.php'; ?>
<?php require 'modals/edit.php'; ?>
<?php require 'modals/hapus.php'; ?>

<!-- Notification -->
<?php require 'notification.php'; ?>

<!-- Scripts -->
<?php require 'scripts/script.php'; ?>