<div id="modal-tambah" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('modal-tambah')"></div>
    <div class="relative bg-white rounded-2xl w-full max-w-md mx-4 shadow-2xl transform transition-all">
        <div class="flex items-center justify-between p-6 border-b border-default">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-brand/10 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-heading">Tambah Barang</h3>
                    <p class="text-xs text-body/70 mt-0.5">Isi form untuk menambah barang baru</p>
                </div>
            </div>
            <button onclick="closeModal('modal-tambah')" class="text-body/40 hover:text-body transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <form id="formTambah" action="/admin/barang.php" method="POST" class="p-6 space-y-4">
            <input type="hidden" name="action" value="tambah">
            <div>
                <label class="block text-sm font-medium text-heading mb-1.5">Nama Barang <span class="text-red-500">*</span></label>
                <input type="text" name="nama_barang" required
                    class="w-full border border-default rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand/20 focus:border-brand transition" 
                    placeholder="Masukkan nama barang" />
            </div>
            <div>
                <label class="block text-sm font-medium text-heading mb-1.5">Stok <span class="text-red-500">*</span></label>
                <input type="number" name="stok" min="0" required
                    class="w-full border border-default rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand/20 focus:border-brand transition" 
                    placeholder="0" />
            </div>
            <div>
                <label class="block text-sm font-medium text-heading mb-1.5">Status</label>
                <select name="status" class="w-full border border-default rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand/20 focus:border-brand transition">
                    <option value="baik">Baik</option>
                    <option value="rusak">Rusak</option>
                </select>
            </div>
        </form>
        
        <div class="flex items-center justify-end space-x-3 p-6 border-t border-default bg-neutral-secondary-soft/50 rounded-b-2xl">
            <button type="button" onclick="closeModal('modal-tambah')"
                class="px-4 py-2.5 text-sm font-medium text-body border border-default rounded-xl hover:bg-white transition-colors">
                Batal
            </button>
            <button type="submit" form="formTambah"
                class="px-4 py-2.5 text-sm font-medium text-white bg-brand hover:bg-brand-strong rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg shadow-brand/25">
                Simpan Barang
            </button>
        </div>
    </div>
</div>