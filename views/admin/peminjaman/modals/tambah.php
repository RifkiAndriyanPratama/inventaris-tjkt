<div id="tambah" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('tambah')"></div>
    <div class="relative bg-white rounded-2xl w-full max-w-md mx-4 shadow-2xl transform transition-all">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-default">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-brand/10 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-heading">Tambah Peminjaman</h3>
                    <p class="text-xs text-body/70 mt-0.5">Isi form untuk menambah peminjaman baru</p>
                </div>
            </div>
            <button onclick="closeModal('tambah')" class="text-body/40 hover:text-body transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <!-- Form -->
        <form id="formTambahPeminjaman" action="/admin/peminjaman.php" method="POST" class="p-6 space-y-4">
            <input type="hidden" name="action" value="tambah">
            
            <!-- Pilih User -->
            <div>
                <label class="block text-sm font-medium text-heading mb-1.5">Peminjam <span class="text-red-500">*</span></label>
                <select name="id_user" required class="w-full border border-default rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand/20 focus:border-brand transition">
                    <option value="">-- Pilih Peminjam --</option>
                    <?php
                    // Ambil data users dari database
                    $users = get_all_users($pdo);
                    foreach ($users as $user) {
                        echo '<option value="' . $user['id'] . '">' . htmlspecialchars($user['nama']) . ' - ' . htmlspecialchars($user['kelas']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            
            <!-- Pilih Barang -->
            <div>
                <label class="block text-sm font-medium text-heading mb-1.5">Barang <span class="text-red-500">*</span></label>
                <select name="id_barang" id="selectBarang" required class="w-full border border-default rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand/20 focus:border-brand transition">
                    <option value="">-- Pilih Barang --</option>
                    <?php
                    // Ambil data barang dari database
                    $barang = get_all_barang($pdo);
                    foreach ($barang as $b) {
                        $disabled = ($b['stok'] <= 0) ? 'disabled' : '';
                        echo '<option value="' . $b['id'] . '" data-stok="' . $b['stok'] . '" ' . $disabled . '>' 
                            . htmlspecialchars($b['nama_barang']) . ' (Stok: ' . $b['stok'] . ')' 
                            . ($b['stok'] <= 0 ? ' - HABIS' : '') 
                            . '</option>';
                    }
                    ?>
                </select>
            </div>
            
            <!-- Info Stok (muncul setelah pilih barang) -->
            <div id="infoStok" class="hidden p-3 bg-blue-50 text-blue-700 rounded-lg text-xs border border-blue-200">
                <span class="font-medium">Stok tersedia:</span> <span id="stokTersedia">0</span> unit
            </div>
            
            <!-- Jumlah -->
            <div>
                <label class="block text-sm font-medium text-heading mb-1.5">Jumlah <span class="text-red-500">*</span></label>
                <input type="number" name="jumlah" id="inputJumlah" min="1" required
                    class="w-full border border-default rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand/20 focus:border-brand transition" 
                    placeholder="Masukkan jumlah" />
            </div>
            
            <!-- Pesan Error (javascript) -->
            <div id="errorJumlah" class="hidden text-xs text-red-600"></div>
        </form>
        
        <!-- Footer -->
        <div class="flex items-center justify-end space-x-3 p-6 border-t border-default bg-neutral-secondary-soft/50 rounded-b-2xl">
            <button type="button" onclick="closeModal('tambah')"
                class="px-4 py-2.5 text-sm font-medium text-body border border-default rounded-xl hover:bg-white transition-colors">
                Batal
            </button>
            <button type="submit" form="formTambahPeminjaman" id="btnSimpan"
                class="px-4 py-2.5 text-sm font-medium text-white bg-brand hover:bg-brand-strong rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg shadow-brand/25">
                Ajukan Peminjaman
            </button>
        </div>
    </div>
</div>

<script>
// Script untuk validasi stok
document.addEventListener('DOMContentLoaded', function() {
    const selectBarang = document.getElementById('selectBarang');
    const inputJumlah = document.getElementById('inputJumlah');
    const infoStok = document.getElementById('infoStok');
    const stokTersedia = document.getElementById('stokTersedia');
    const errorJumlah = document.getElementById('errorJumlah');
    const btnSimpan = document.getElementById('btnSimpan');
    
    if (selectBarang) {
        selectBarang.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const stok = selected.dataset.stok || 0;
            
            if (this.value) {
                stokTersedia.textContent = stok;
                infoStok.classList.remove('hidden');
                
                // Reset validasi
                validateJumlah();
            } else {
                infoStok.classList.add('hidden');
                errorJumlah.classList.add('hidden');
            }
        });
    }
    
    if (inputJumlah) {
        inputJumlah.addEventListener('input', validateJumlah);
    }
    
    function validateJumlah() {
        const selected = selectBarang.options[selectBarang.selectedIndex];
        const stok = parseInt(selected.dataset.stok || 0);
        const jumlah = parseInt(inputJumlah.value || 0);
        
        if (jumlah > stok) {
            errorJumlah.textContent = 'Jumlah melebihi stok yang tersedia!';
            errorJumlah.classList.remove('hidden');
            btnSimpan.disabled = true;
            btnSimpan.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            errorJumlah.classList.add('hidden');
            btnSimpan.disabled = false;
            btnSimpan.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }
});
</script>