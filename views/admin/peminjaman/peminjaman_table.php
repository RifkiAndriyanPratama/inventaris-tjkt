<div class="bg-white rounded-xl border border-default shadow-sm overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gradient-to-r from-neutral-secondary-soft to-white border-b border-default">
            <tr>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider">No</th>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider">Peminjam</th>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider">Barang</th>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider">Jumlah</th>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider">Tgl Pinjam</th>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider">Tgl Kembali</th>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider text-center">Approval</th>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider text-center">Data</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-default">
            <?php if (empty($peminjaman)): ?>
            <tr>
                <td colspan="9" class="px-6 py-16 text-center">
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-24 h-24 bg-neutral-secondary-soft rounded-full flex items-center justify-center mb-4">
                            <svg class="w-12 h-12 text-body/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-heading mb-2">Belum Ada Data Peminjaman</h3>
                        <p class="text-sm text-body/60 mb-6">Tidak ada riwayat peminjaman yang ditemukan.</p>
                        <div class="flex gap-3">
                            <button onclick="openModal('tambah')" 
                                class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-white bg-brand hover:bg-brand-strong rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg shadow-brand/25">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Peminjaman Baru
                            </button>
                            <button onclick="window.location.reload()" 
                                class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-body border border-default rounded-xl hover:bg-neutral-secondary-soft transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Refresh
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
            
            <?php else: ?>
            <?php foreach ($peminjaman as $i => $item): ?>
            <tr class="hover:bg-neutral-secondary-soft/50 transition-colors group">
                <td class="px-6 py-4 text-body/70 text-xs font-mono"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></td>
                
                <!-- Kolom Peminjam -->
                <td class="px-6 py-4">
                    <div>
                        <p class="font-medium text-heading"><?= htmlspecialchars($item['nama'] ?? 'Unknown') ?></p>
                        <p class="text-xs text-body/50"><?= htmlspecialchars($item['kelas'] ?? '-') ?></p>
                    </div>
                </td>
                
                <!-- Kolom Barang -->
                <td class="px-6 py-4">
                    <div>
                        <p class="font-medium text-heading"><?= htmlspecialchars($item['nama_barang'] ?? 'Unknown') ?></p>
                        <p class="text-xs text-body/50">ID: BRG-<?= str_pad($item['id_barang'], 4, '0', STR_PAD_LEFT) ?></p>
                    </div>
                </td>
                
                <!-- Kolom Jumlah -->
                <td class="px-6 py-4">
                    <span class="font-medium text-heading"><?= $item['jumlah'] ?></span>
                    <span class="text-xs text-body/50 ml-1">unit</span>
                </td>
                
                <!-- Kolom Tanggal Pinjam -->
                <td class="px-6 py-4">
                    <span class="text-body"><?= date('d/m/Y', strtotime($item['tanggal_pinjam'])) ?></span>
                </td>
                
                <!-- Kolom Tanggal Kembali -->
                <td class="px-6 py-4">
                    <?php if ($item['tanggal_kembali']): ?>
                        <span class="text-body"><?= date('d/m/Y', strtotime($item['tanggal_kembali'])) ?></span>
                    <?php else: ?>
                        <span class="text-body/50 italic">Belum kembali</span>
                    <?php endif; ?>
                </td>
                
                <!-- Kolom Status -->
                <td class="px-6 py-4">
                    <?php
                    $statusConfig = match($item['status_pinjam']) {
                        'pending' => ['class' => 'bg-yellow-100 text-yellow-700 border-yellow-200', 'dot' => 'bg-yellow-500', 'label' => 'Menunggu'],
                        'dipinjam' => ['class' => 'bg-blue-100 text-blue-700 border-blue-200', 'dot' => 'bg-blue-500', 'label' => 'Dipinjam'],
                        'dikembalikan' => ['class' => 'bg-green-100 text-green-700 border-green-200', 'dot' => 'bg-green-500', 'label' => 'Dikembalikan'],
                        'ditolak' => ['class' => 'bg-red-100 text-red-700 border-red-200', 'dot' => 'bg-red-500', 'label' => 'Ditolak'],
                        default => ['class' => 'bg-gray-100 text-gray-700 border-gray-200', 'dot' => 'bg-gray-500', 'label' => ucfirst($item['status_pinjam'] ?? 'Unknown')]
                    };
                    ?>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border <?= $statusConfig['class'] ?>">
                        <span class="w-1.5 h-1.5 rounded-full <?= $statusConfig['dot'] ?> mr-1.5"></span>
                        <?= $statusConfig['label'] ?>
                    </span>
                </td>
                
                <!-- Kolom Approval - Style sama seperti barang -->
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center space-x-2">
                        <?php if ($item['status_pinjam'] === 'pending'): ?>
                        <button onclick="konfirmasiPinjam(<?= $item['id_peminjaman'] ?>)" 
                            class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200 group" 
                            title="Setujui">
                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </button>
                        <button onclick="tolakPinjam(<?= $item['id_peminjaman'] ?>)" 
                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200 group" 
                            title="Tolak">
                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        <?php endif; ?>
                        
                        <?php if ($item['status_pinjam'] === 'dipinjam'): ?>
                        <button onclick="kembalikanBarang(<?= $item['id_peminjaman'] ?>)" 
                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 group" 
                            title="Kembalikan">
                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </button>
                        <?php endif; ?>
                        
                        <?php if ($item['status_pinjam'] !== 'pending' && $item['status_pinjam'] !== 'dipinjam'): ?>
                        <span class="text-xs text-body/30">—</span>
                        <?php endif; ?>
                    </div>
                </td>
                
                <!-- Kolom Data - Style sama seperti barang -->
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center space-x-2">
                        <button onclick='openEditModal(<?= json_encode($item) ?>)' 
                            class="p-2 text-brand hover:bg-brand/10 rounded-lg transition-all duration-200 group" 
                            title="Edit">
                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <button onclick="openHapusModal(<?= $item['id_peminjaman'] ?>, '<?= htmlspecialchars($item['nama_barang']) ?>')" 
                            class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-all duration-200 group" 
                            title="Hapus">
                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    
    <?php if (!empty($peminjaman)): ?>
    <div class="px-6 py-4 bg-neutral-secondary-soft/50 border-t border-default flex items-center justify-between text-sm">
        <p class="text-body/70">
            Menampilkan <span class="font-medium text-heading"><?= count($peminjaman) ?></span> data peminjaman
        </p>
        <p class="text-body/50 text-xs">
            Total: <?= array_sum(array_column($peminjaman, 'jumlah')) ?> unit barang
        </p>
    </div>
    <?php endif; ?>
</div>