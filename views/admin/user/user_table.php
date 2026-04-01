<div class="bg-white rounded-xl border border-default shadow-sm overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gradient-to-r from-neutral-secondary-soft to-white border-b border-default">
            <tr>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider">No</th>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider">NIS</th>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider">Nama</th>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider">Kelas</th>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider">Role</th>
                <th class="px-6 py-4 font-semibold text-heading/80 text-xs uppercase tracking-wider text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-default">
            <?php if (empty($users)) { ?>
            <tr>
                <td colspan="5" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center">
                        <svg class="w-16 h-16 text-body/20 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-body/70">Belum ada data user</p>
                        <button onclick="openModal('modal-tambah')" class="mt-3 text-brand hover:text-brand-strong text-sm font-medium">
                            + Tambah User Sekarang
                        </button>
                    </div>
                </td>
            </tr>
            <?php } else { ?>
            <?php foreach ($users as $i => $item) { ?>
            <tr data-kelas="<?= htmlspecialchars($item['kelas']) ?>" class="hover:bg-neutral-secondary-soft/50 transition-colors group">
                <td class="px-6 py-4 text-body/70 text-xs font-mono"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></td>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                            <p class="font-medium text-heading"><?= htmlspecialchars($item['nis']) ?></p>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                            <p class="font-medium text-heading"><?= htmlspecialchars($item['nama']) ?></p>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-2">
                        <span class="font-medium text-heading"><?= $item['kelas'] ?></span>
                    </div>
                </td>
                <td class="px-6 py-4"> 
                        <p class="font-medium text-heading"><?= htmlspecialchars($item['role']) ?></p>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center space-x-2">
                        <button onclick="openEditModal(<?= htmlspecialchars(json_encode($item)) ?>)"
                            class="p-2 text-brand hover:bg-brand/10 rounded-lg transition-all duration-200 group" title="Edit">
                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <button onclick="openHapusModal(<?= $item['id'] ?>, '<?= htmlspecialchars($item['nama']) ?>')"
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
    
    <?php if (! empty($users)) { ?>
    <div class="px-6 py-4 bg-neutral-secondary-soft/50 border-t border-default flex items-center justify-between text-sm">
        <p class="text-body/70">Menampilkan <span class="font-medium text-heading"><?= count($users) ?></span> data</p>
    </div>
    <?php } ?>
</div>
