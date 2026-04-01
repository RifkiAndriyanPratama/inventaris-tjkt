<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-heading">Riwayat Peminjaman</h1>
        <p class="text-sm text-body/70 mt-1">Lihat semua riwayat peminjaman barang Anda</p>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-xl border border-default p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-body/70">Total Peminjaman</p>
                    <p class="text-2xl font-bold text-heading mt-1"><?= $totalPeminjaman ?></p>
                </div>
                <div class="w-10 h-10 bg-brand/10 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-default p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-body/70">Menunggu</p>
                    <p class="text-2xl font-bold text-yellow-600 mt-1"><?= $totalPending ?></p>
                </div>
                <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-default p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-body/70">Dipinjam</p>
                    <p class="text-2xl font-bold text-blue-600 mt-1"><?= $totalDipinjam ?></p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-default p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-body/70">Selesai</p>
                    <p class="text-2xl font-bold text-green-600 mt-1"><?= $totalDikembalikan + $totalDitolak ?></p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-xl border border-default p-4">
        <div class="flex flex-wrap items-center gap-4">
            <div class="relative flex-1 max-w-xs">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-body/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" id="searchInput" placeholder="Cari barang..." 
                    class="w-full pl-9 pr-3 py-2 border border-default rounded-lg text-sm focus:ring-2 focus:ring-brand/20 focus:border-brand">
            </div>
            <div>
                <select id="filterStatus" class="px-3 py-2 border border-default rounded-lg text-sm focus:ring-2 focus:ring-brand/20 focus:border-brand">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="dipinjam">Dipinjam</option>
                    <option value="dikembalikan">Dikembalikan</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
            <button onclick="resetFilter()" class="px-3 py-2 text-sm text-body hover:text-heading border border-default rounded-lg hover:bg-neutral-secondary-soft transition">
                Reset
            </button>
        </div>
    </div>

    <!-- Tabel Riwayat -->
    <div class="bg-white rounded-xl border border-default overflow-hidden">
        <div class="px-6 py-4 border-b border-default bg-neutral-secondary-soft/50">
            <h3 class="text-base font-semibold text-heading">Daftar Peminjaman</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-neutral-secondary-soft">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">No</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Barang</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Jumlah</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Tgl Pinjam</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Tgl Kembali</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-default" id="riwayatTable">
                    <?php if (empty($riwayat)) { ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-body/50">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-body/30 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p>Belum ada riwayat peminjaman</p>
                                <a href="/user/dashboard.php" class="mt-3 text-sm text-brand hover:text-brand-strong">Ajukan peminjaman sekarang →</a>
                            </div>
                        </td>
                    </tr>
                    <?php } else { ?>
                    <?php foreach (array_values($riwayat) as $i => $item) { ?>
                    <tr class="hover:bg-neutral-secondary-soft/50 transition-colors" data-status="<?= $item['status_pinjam'] ?>" data-barang="<?= strtolower($item['nama_barang']) ?>">
                        <td class="px-6 py-3 text-body/70"><?= $i + 1 ?></td>
                        <td class="px-6 py-3">
                            <p class="font-medium text-heading"><?= htmlspecialchars($item['nama_barang']) ?></p>
                        </td>
                        <td class="px-6 py-3">
                            <span class="font-medium"><?= $item['jumlah'] ?></span> unit
                        </td>
                        <td class="px-6 py-3"><?= date('d/m/Y', strtotime($item['tanggal_pinjam'])) ?></td>
                        <td class="px-6 py-3">
                            <?= $item['tanggal_kembali'] ? date('d/m/Y', strtotime($item['tanggal_kembali'])) : '-' ?>
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
</div>

<?php require __DIR__.'/scripts/script.php'; ?>
