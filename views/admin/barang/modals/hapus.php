<div id="modal-hapus" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('modal-hapus')"></div>
    <div class="relative bg-white rounded-2xl w-full max-w-sm mx-4 shadow-2xl">
        <div class="p-8 text-center">
            <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4 animate-pulse">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-heading mb-2">Konfirmasi Hapus</h3>
            <p class="text-sm text-body/70 mb-2">Anda yakin ingin menghapus barang:</p>
            <p class="text-lg font-semibold text-red-500 mb-6" id="hapus-nama"></p>
            <p class="text-xs text-body/50 mb-6">Tindakan ini tidak dapat dibatalkan!</p>
            
            <form id="formHapus" action="/admin/barang.php" method="POST" class="flex space-x-3">
                <input type="hidden" name="action" value="hapus">
                <input type="hidden" name="id" id="hapus-id">
                <input type="hidden" name="nama_barang" id="hapus-nama-input">
                <button type="button" onclick="closeModal('modal-hapus')"
                    class="flex-1 px-4 py-3 text-sm font-medium text-body border border-default rounded-xl hover:bg-neutral-secondary-soft transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-3 text-sm font-medium text-white bg-red-500 hover:bg-red-600 rounded-xl transition-all duration-200 shadow-lg shadow-red-500/25">
                    Ya, Hapus!
                </button>
            </form>
        </div>
    </div>
</div>