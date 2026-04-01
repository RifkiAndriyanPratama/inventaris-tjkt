<!-- Dashboard Admin -->
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-heading">Dashboard Admin</h1>
        <p class="text-sm text-body/70 mt-1">Selamat datang, <?= htmlspecialchars($_SESSION['user']['nama'] ?? 'Admin') ?>! 👋</p>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total User -->
        <div class="bg-white rounded-xl border border-default p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-body/70">Total User</p>
                    <p class="text-2xl font-bold text-heading mt-1"><?= $totalUsers ?></p>
                </div>
                <div class="w-10 h-10 bg-brand/10 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <a href="/admin/user.php" class="inline-flex items-center text-xs text-brand hover:text-brand-strong mt-3">
                Lihat detail
                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <!-- Total Barang -->
        <div class="bg-white rounded-xl border border-default p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-body/70">Total Barang</p>
                    <p class="text-2xl font-bold text-heading mt-1"><?= $totalBarang ?></p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
            <a href="/admin/barang.php" class="inline-flex items-center text-xs text-brand hover:text-brand-strong mt-3">
                Lihat detail
                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <!-- Total Peminjaman -->
        <div class="bg-white rounded-xl border border-default p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-body/70">Total Peminjaman</p>
                    <p class="text-2xl font-bold text-heading mt-1"><?= $totalPeminjaman ?></p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <a href="/admin/peminjaman.php" class="inline-flex items-center text-xs text-brand hover:text-brand-strong mt-3">
                Lihat detail
                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <!-- Pending Approval -->
        <div class="bg-white rounded-xl border border-default p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-body/70">Menunggu Persetujuan</p>
                    <p class="text-2xl font-bold text-yellow-600 mt-1"><?= $pending ?></p>
                </div>
                <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <a href="/admin/peminjaman.php" class="inline-flex items-center text-xs text-brand hover:text-brand-strong mt-3">
                Proses sekarang
                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>

    <!-- Statistik Peminjaman -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chart Peminjaman per Status -->
        <div class="bg-white rounded-xl border border-default p-5">
            <h3 class="text-base font-semibold text-heading mb-4">Statistik Peminjaman</h3>
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-body">Dipinjam</span>
                        <span class="text-heading font-medium"><?= $dipinjam ?></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: <?= $totalPeminjaman > 0 ? ($dipinjam / $totalPeminjaman) * 100 : 0 ?>%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-body">Dikembalikan</span>
                        <span class="text-heading font-medium"><?= $dikembalikan ?></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: <?= $totalPeminjaman > 0 ? ($dikembalikan / $totalPeminjaman) * 100 : 0 ?>%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-body">Menunggu</span>
                        <span class="text-heading font-medium"><?= $pending ?></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-500 h-2 rounded-full" style="width: <?= $totalPeminjaman > 0 ? ($pending / $totalPeminjaman) * 100 : 0 ?>%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-body">Ditolak</span>
                        <span class="text-heading font-medium"><?= $ditolak ?></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: <?= $totalPeminjaman > 0 ? ($ditolak / $totalPeminjaman) * 100 : 0 ?>%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stok Barang -->
        <div class="bg-white rounded-xl border border-default p-5">
            <h3 class="text-base font-semibold text-heading mb-4">Status Stok Barang</h3>
            <div class="space-y-4">
                <?php if (! empty($stokMenipis)) { ?>
                <div>
                    <p class="text-sm font-medium text-yellow-600 mb-2">⚠️ Stok Menipis (≤ 5)</p>
                    <div class="space-y-1">
                        <?php foreach (array_slice($stokMenipis, 0, 3) as $b) { ?>
                        <div class="flex justify-between text-sm">
                            <span class="text-body"><?= htmlspecialchars($b['nama_barang']) ?></span>
                            <span class="text-yellow-600 font-medium"><?= $b['stok'] ?> unit</span>
                        </div>
                        <?php } ?>
                        <?php if (count($stokMenipis) > 3) { ?>
                        <p class="text-xs text-body/50">+<?= count($stokMenipis) - 3 ?> barang lainnya</p>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>

                <?php if (! empty($stokHabis)) { ?>
                <div>
                    <p class="text-sm font-medium text-red-600 mb-2">❌ Stok Habis</p>
                    <div class="space-y-1">
                        <?php foreach (array_slice($stokHabis, 0, 3) as $b) { ?>
                        <div class="flex justify-between text-sm">
                            <span class="text-body"><?= htmlspecialchars($b['nama_barang']) ?></span>
                            <span class="text-red-600 font-medium">0 unit</span>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>

                <?php if (empty($stokMenipis) && empty($stokHabis)) { ?>
                <p class="text-sm text-green-600">✅ Semua stok aman!</p>
                <?php } ?>
            </div>
            <a href="/admin/barang.php" class="inline-flex items-center text-xs text-brand hover:text-brand-strong mt-4">
                Kelola stok barang
                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>

    <!-- Peminjaman Terbaru -->
    <div class="bg-white rounded-xl border border-default overflow-hidden">
        <div class="px-6 py-4 border-b border-default flex items-center justify-between">
            <h3 class="text-base font-semibold text-heading">Peminjaman Terbaru</h3>
            <a href="/admin/peminjaman.php" class="text-xs text-brand hover:text-brand-strong">Lihat semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-neutral-secondary-soft">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Peminjam</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Barang</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Jumlah</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Tgl Pinjam</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-default">
                    <?php if (empty($peminjamanTerbaru)) { ?>
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-body/50">Belum ada peminjaman</td>
                    </tr>
                    <?php } else { ?>
                    <?php foreach ($peminjamanTerbaru as $item) { ?>
                    <tr class="hover:bg-neutral-secondary-soft/50">
                        <td class="px-6 py-3">
                            <p class="font-medium text-heading"><?= htmlspecialchars($item['nama']) ?></p>
                            <p class="text-xs text-body/50"><?= htmlspecialchars($item['kelas']) ?></p>
                        </td>
                        <td class="px-6 py-3">
                            <p class="text-heading"><?= htmlspecialchars($item['nama_barang']) ?></p>
                            <p class="text-xs text-body/50">ID: BRG-<?= str_pad($item['id_barang'], 4, '0', STR_PAD_LEFT) ?></p>
                        </td>
                        <td class="px-6 py-3">
                            <span class="font-medium"><?= $item['jumlah'] ?></span> unit
                        </td>
                        <td class="px-6 py-3">
                            <?= date('d/m/Y', strtotime($item['tanggal_pinjam'])) ?>
                        </td>
                        <td class="px-6 py-3">
                            <?php
                            $statusClass = match ($item['status_pinjam']) {
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'dipinjam' => 'bg-blue-100 text-blue-700',
                                'dikembalikan' => 'bg-green-100 text-green-700',
                                'ditolak' => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-700'
                            };
                        ?>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium <?= $statusClass ?>">
                                <?= ucfirst($item['status_pinjam']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <a href="/admin/barang.php" class="bg-white rounded-xl border border-default p-4 hover:shadow-md transition-all group">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-heading">Tambah Barang</p>
                    <p class="text-xs text-body/50">Tambah stok barang baru</p>
                </div>
            </div>
        </a>
        <a href="/admin/user.php" class="bg-white rounded-xl border border-default p-4 hover:shadow-md transition-all group">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-brand/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-heading">Tambah User</p>
                    <p class="text-xs text-body/50">Tambah pengguna baru</p>
                </div>
            </div>
        </a>
        <a href="/admin/peminjaman.php" class="bg-white rounded-xl border border-default p-4 hover:shadow-md transition-all group">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-heading">Peminjaman Baru</p>
                    <p class="text-xs text-body/50">Ajukan peminjaman barang</p>
                </div>
            </div>
        </a>
    </div>
</div>
