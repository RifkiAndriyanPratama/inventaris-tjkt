<div class="bg-white rounded-xl border border-default shadow-sm overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gradient-to-r from-neutral-secondary-soft to-white border-b border-default">
            <tr>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider">No</th>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider">Nama Barang</th>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider">Stok</th>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-default">
            <?php if (empty($barang)) { ?>
            <tr>
                <td colspan="5" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center">
                        <svg class="w-16 h-16 text-body/20 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-body/70">Belum ada data barang</p>
                        <button onclick="openModal('modal-tambah')" class="mt-3 text-brand hover:text-brand-strong text-sm font-medium">
                            + Tambah Barang Sekarang
                        </button>
                    </div>
                </td>
            </tr>
            <?php } else { ?>
            <?php foreach ($barang as $i => $item) { ?>
            <tr class="hover:bg-neutral-secondary-soft/50 transition-colors group">
                <td class="px-6 py-4 text-body/70 text-xs font-mono"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></td>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-brand/10 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-heading"><?= htmlspecialchars($item['nama_barang']) ?></p>
                            <p class="text-xs text-body/50 mt-0.5">ID: BRG-<?= str_pad($item['id'], 4, '0', STR_PAD_LEFT) ?></p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-2">
                        <span class="font-medium text-heading"><?= $item['stok'] ?></span>
                        <span class="text-xs text-body/50">unit</span> 
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium 
                        <?= ($item['status'] ?? 'baik') === 'baik'
                            ? 'bg-green-100 text-green-700 border border-green-200'
                            : 'bg-red-100 text-red-700 border border-red-200' ?>">
                        <span class="w-1.5 h-1.5 rounded-full <?= ($item['status'] ?? 'baik') === 'baik' ? 'bg-green-500' : 'bg-red-500' ?> mr-1.5"></span>
                        <?= ucfirst(htmlspecialchars($item['status'] ?? 'baik')) ?>
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center space-x-2">
                        <button onclick="openEditModal(<?= htmlspecialchars(json_encode($item)) ?>)"
                            class="p-2 text-brand hover:bg-brand/10 rounded-lg transition-all duration-200 group" title="Edit">
                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <button onclick="openHapusModal(<?= $item['id'] ?>, '<?= htmlspecialchars($item['nama_barang']) ?>')"
                            class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-all duration-200 group" title="Hapus">
                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
        </tbody>
    </table>
    
    <?php if (! empty($barang)) { ?>
    <div class="px-6 py-4 bg-neutral-secondary-soft/50 border-t border-default flex items-center justify-between text-sm">
        <p class="text-body/70">Menampilkan <span class="font-medium text-heading"><?= count($barang) ?></span> data</p>
    </div>
    <div class="anjay"></div>
    <?php } ?>
</div>
