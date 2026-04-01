<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-heading">Dashboard Siswa</h1>
        <p class="text-sm text-body/70 mt-1">Selamat datang, <?= htmlspecialchars($_SESSION['user']['nama']) ?>! 👋</p>
        <p class="text-xs text-body/50 mt-0.5">Kelas: <?= htmlspecialchars($_SESSION['user']['kelas']) ?></p>
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
                    <p class="text-sm text-body/70">Menunggu Persetujuan</p>
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
                    <p class="text-sm text-body/70">Sedang Dipinjam</p>
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
                    <p class="text-sm text-body/70">Sudah Dikembalikan</p>
                    <p class="text-2xl font-bold text-green-600 mt-1"><?= $totalDikembalikan ?></p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Peminjaman -->
    <div class="bg-white rounded-xl border border-default overflow-hidden">
        <div class="px-6 py-4 border-b border-default bg-neutral-secondary-soft/50">
            <h3 class="text-base font-semibold text-heading">Ajukan Peminjaman Barang</h3>
            <p class="text-xs text-body/50 mt-0.5">Pilih barang dan jumlah yang ingin dipinjam</p>
        </div>
        <div class="p-6">
            <form id="formPinjam" action="/user/pinjam.php" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-heading mb-1.5">Pilih Barang <span class="text-red-500">*</span></label>
                    <select name="id_barang" id="selectBarang" required class="w-full border border-default rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand/20 focus:border-brand">
                        <option value="">-- Pilih Barang --</option>
                        <?php foreach ($barangTersedia as $b) { ?>
                        <option value="<?= $b['id'] ?>" data-stok="<?= $b['stok'] ?>">
                            <?= htmlspecialchars($b['nama_barang']) ?> (Stok: <?= $b['stok'] ?>)
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-heading mb-1.5">Jumlah <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah" id="inputJumlah" min="1" required
                        class="w-full border border-default rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand/20 focus:border-brand"
                        placeholder="Jumlah">
                </div>
                <div class="flex items-end">
                    <button type="submit" id="btnPinjam"
                        class="w-full px-4 py-2 text-sm font-medium text-white bg-brand hover:bg-brand-strong rounded-lg transition">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Ajukan Peminjaman
                    </button>
                </div>
            </form>
            <div id="errorJumlah" class="hidden text-xs text-red-600 mt-2"></div>
            <div id="infoStok" class="hidden text-xs text-blue-600 mt-2"></div>
        </div>
    </div>

    <!-- Riwayat Peminjaman -->
    <div class="bg-white rounded-xl border border-default overflow-hidden">
        <div class="px-6 py-4 border-b border-default bg-neutral-secondary-soft/50 flex items-center justify-between">
            <div>
                <h3 class="text-base font-semibold text-heading">Riwayat Peminjaman</h3>
                <p class="text-xs text-body/50 mt-0.5">Status peminjaman barang Anda</p>
            </div>
            <a href="/user/riwayat.php" class="text-xs text-brand hover:text-brand-strong">Lihat semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-neutral-secondary-soft">
                    实践
                        <th class="px-6 py-3 text-xs font-medium text-body/70">No</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Barang</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Jumlah</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Tgl Pinjam</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Tgl Kembali</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Status</th>
                     \\
                </thead>
                <tbody class="divide-y divide-default">
                    <?php if (empty($riwayat)) { ?>
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-body/50">
                            <div class="flex flex-col items-center">
                                <svg class="w-10 h-10 text-body/30 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p>Belum ada riwayat peminjaman</p>
                            </div>
                        </td>
                    </tr>
                    <?php } else { ?>
                    <?php foreach (array_slice($riwayat, 0, 5) as $i => $item) { ?>
                    <tr class="hover:bg-neutral-secondary-soft/50">
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

<!-- Script untuk validasi -->
<?php require __DIR__.'/scripts/script.php'; ?>
