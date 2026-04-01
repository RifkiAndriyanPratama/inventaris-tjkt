<?php
// Statistik
$totalPeminjaman = count($peminjaman);
?>

<!-- Breadcrumb -->
<div class="flex items-center text-sm text-body/70 mb-4">
    <a href="/admin/dashboard.php" class="hover:text-brand transition-colors">Dashboard</a>
    <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-heading font-medium">Manajemen Peminjaman</span>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-heading">Manajemen Peminjaman</h1>
        <p class="text-sm text-body/70 mt-1">Kelola data peminjaman barang TJKT</p>
    </div>
    <button onclick="openModal('tambah')"
        class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-brand hover:bg-brand-strong rounded-xl transition-all duration-200 transform hover:scale-105 focus:ring-4 focus:ring-brand/30 shadow-lg shadow-brand/25">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Peminjaman Baru
    </button>
</div>

<!-- Statistik Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-default p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-body/70">Total Peminjaman</p>
                <p class="text-2xl font-bold text-heading mt-1"><?= $totalPeminjaman ?></p>
            </div>
            <div class="w-10 h-10 bg-brand/10 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Table -->
<?php require 'peminjaman_table.php'; ?>

<!-- Modals -->
<?php require 'modals/tambah.php'; ?>
<?php require 'modals/edit.php'; ?>
<?php require 'modals/hapus.php'; ?>

<!-- Notification -->
<?php require 'notification.php'; ?>

<!-- Scripts -->
<?php require 'scripts/script.php'; ?>