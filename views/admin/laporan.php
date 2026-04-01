<?php
// Fungsi untuk konversi bulan ke bahasa Indonesia
function bulanIndonesia($bulanInggris)
{
    $bulan = [
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember',
    ];

    return str_replace(array_keys($bulan), array_values($bulan), $bulanInggris);
}
?>

<!-- Laporan -->
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-heading">Laporan Peminjaman</h1>
        <p class="text-sm text-body/70 mt-1">Lihat laporan peminjaman barang per bulan</p>
    </div>

    <!-- Filter Bulan -->
    <div class="bg-white rounded-xl border border-default p-5">
        <div class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-heading mb-1.5">Pilih Bulan</label>
                <select name="bulan" id="bulanSelect" class="w-full border border-default rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand/20 focus:border-brand">
                    <?php foreach ($months as $month) { ?>
                    <option value="<?= $month ?>" <?= $filter_bulan === $month ? 'selected' : '' ?>>
                        <?= bulanIndonesia(date('F Y', strtotime($month.'-01'))) ?>
                    </option>
                    <?php } ?>
                </select>
            </div>

            <div class="flex gap-2">
                <button onclick="applyFilter()" class="px-4 py-2 text-sm font-medium text-white bg-brand hover:bg-brand-strong rounded-lg transition">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Tampilkan
                </button>
                <a href="/admin/laporan.php" class="px-4 py-2 text-sm font-medium text-body border border-default rounded-lg hover:bg-neutral-secondary-soft transition">
                    Reset
                </a>
            </div>
        </div>
    </div>

    <!-- Info Bulan -->
    <div class="bg-brand/5 rounded-xl p-4 border border-brand/20">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-brand/20 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-body/70">Laporan Bulan</p>
                <p class="text-lg font-semibold text-heading"><?= bulanIndonesia(date('F Y', strtotime($filter_bulan.'-01'))) ?></p>
            </div>
        </div>
    </div>

    <!-- Statistik Ringkas -->
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
                    <p class="text-sm text-body/70">Total Unit Dipinjam</p>
                    <p class="text-2xl font-bold text-heading mt-1"><?= $totalBarangDipinjam ?></p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-default p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-body/70">Barang Terpopuler</p>
                    <p class="text-lg font-bold text-heading mt-1 truncate"><?= htmlspecialchars((string) $topBarang) ?></p>
                </div>
                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-default p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-body/70">Peminjam Aktif</p>
                    <p class="text-lg font-bold text-heading mt-1 truncate"><?= htmlspecialchars((string) $topPeminjam) ?></p>
                </div>
                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Status -->
    <div class="bg-white rounded-xl border border-default p-5">
        <h3 class="text-base font-semibold text-heading mb-4">Statistik Berdasarkan Status</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="text-center p-3 bg-yellow-50 rounded-xl">
                <p class="text-2xl font-bold text-yellow-600"><?= $pending ?></p>
                <p class="text-xs text-body/70">Menunggu</p>
            </div>
            <div class="text-center p-3 bg-blue-50 rounded-xl">
                <p class="text-2xl font-bold text-blue-600"><?= $dipinjam ?></p>
                <p class="text-xs text-body/70">Dipinjam</p>
            </div>
            <div class="text-center p-3 bg-green-50 rounded-xl">
                <p class="text-2xl font-bold text-green-600"><?= $dikembalikan ?></p>
                <p class="text-xs text-body/70">Dikembalikan</p>
            </div>
            <div class="text-center p-3 bg-red-50 rounded-xl">
                <p class="text-2xl font-bold text-red-600"><?= $ditolak ?></p>
                <p class="text-xs text-body/70">Ditolak</p>
            </div>
        </div>
    </div>

    <!-- Tabel Laporan -->
    <div class="bg-white rounded-xl border border-default overflow-hidden">
        <div class="px-6 py-4 border-b border-default flex items-center justify-between">
            <h3 class="text-base font-semibold text-heading">Detail Peminjaman Bulan <?= bulanIndonesia(date('F Y', strtotime($filter_bulan.'-01'))) ?></h3>
            <button onclick="exportToExcel()" class="px-3 py-1.5 text-xs font-medium text-green-600 bg-green-50 hover:bg-green-100 rounded-lg transition">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export Excel
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left" id="laporanTable">
                <thead class="bg-neutral-secondary-soft">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">No</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Tanggal</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Peminjam</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Kelas</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Barang</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Jumlah</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Tgl Kembali</th>
                        <th class="px-6 py-3 text-xs font-medium text-body/70">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-default">
                    <?php if (empty($peminjaman)) { ?>
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-body/50">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-body/30 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p>Tidak ada data peminjaman pada bulan ini</p>
                            </div>
                        </td>
                    </tr>
                    <?php } else { ?>
                    <?php foreach (array_values($peminjaman) as $i => $item) { ?>
                    <tr class="hover:bg-neutral-secondary-soft/50">
                        <td class="px-6 py-3 text-body/70"><?= $i + 1 ?></td>
                        <td class="px-6 py-3 text-body"><?= date('d/m/Y', strtotime($item['tanggal_pinjam'])) ?></td>
                        <td class="px-6 py-3">
                            <p class="font-medium text-heading"><?= htmlspecialchars($item['nama']) ?></p>
                        </td>
                        <td class="px-6 py-3 text-body"><?= htmlspecialchars($item['kelas']) ?></td>
                        <td class="px-6 py-3">
                            <p class="text-heading"><?= htmlspecialchars($item['nama_barang']) ?></p>
                            <p class="text-xs text-body/50">ID: BRG-<?= str_pad($item['id_barang'], 4, '0', STR_PAD_LEFT) ?></p>
                        </td>
                        <td class="px-6 py-3">
                            <span class="font-medium"><?= $item['jumlah'] ?></span> unit
                        </td>
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

<script>
function applyFilter() {
    const bulan = document.getElementById('bulanSelect').value;
    window.location.href = '/admin/laporan.php?bulan=' + bulan;
}

function exportToExcel() {
    let table = document.getElementById('laporanTable');
    let html = table.outerHTML;
    
    html = '<html><head><meta charset="UTF-8"><title>Laporan Peminjaman</title></head><body>' + html + '</body></html>';
    
    let blob = new Blob([html], { type: 'application/vnd.ms-excel' });
    let link = document.createElement('a');
    let url = URL.createObjectURL(blob);
    
    let bulanSelect = document.getElementById('bulanSelect');
    let bulanText = bulanSelect.options[bulanSelect.selectedIndex].text;
    link.href = url;
    link.download = 'laporan_peminjaman_' + bulanText + '.xls';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
}
</script>
