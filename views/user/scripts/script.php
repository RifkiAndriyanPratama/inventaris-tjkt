<script>
// Validasi stok
const selectBarang = document.getElementById('selectBarang');
const inputJumlah = document.getElementById('inputJumlah');
const errorJumlah = document.getElementById('errorJumlah');
const infoStok = document.getElementById('infoStok');
const btnPinjam = document.getElementById('btnPinjam');

if (selectBarang) {
    selectBarang.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const stok = selected.dataset.stok || 0;
        
        if (this.value) {
            infoStok.textContent = 'Stok tersedia: ' + stok + ' unit';
            infoStok.classList.remove('hidden');
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
        btnPinjam.disabled = true;
        btnPinjam.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
        errorJumlah.classList.add('hidden');
        btnPinjam.disabled = false;
        btnPinjam.classList.remove('opacity-50', 'cursor-not-allowed');
    }
}

// Filter untuk halaman riwayat
const searchInput = document.getElementById('searchInput');
const filterStatus = document.getElementById('filterStatus');
const rows = document.querySelectorAll('#riwayatTable tr:not(:first-child)');
const totalTampil = document.getElementById('totalTampil');

function filterTable() {
    if (!rows.length) return;
    
    const searchText = searchInput?.value.toLowerCase() || '';
    const statusFilter = filterStatus?.value || '';
    let visible = 0;
    
    rows.forEach(row => {
        const barang = row.dataset?.barang || '';
        const status = row.dataset?.status || '';
        
        const matchSearch = barang.includes(searchText);
        const matchStatus = !statusFilter || status === statusFilter;
        
        if (matchSearch && matchStatus) {
            row.style.display = '';
            visible++;
        } else {
            row.style.display = 'none';
        }
    });
    
    if (totalTampil) totalTampil.textContent = visible;
}

function resetFilter() {
    if (searchInput) searchInput.value = '';
    if (filterStatus) filterStatus.value = '';
    filterTable();
}

if (searchInput) searchInput.addEventListener('keyup', filterTable);
if (filterStatus) filterStatus.addEventListener('change', filterTable);

// Notification auto close
setTimeout(() => {
    const notif = document.getElementById('notification');
    if (notif) notif.remove();
}, 3000);
</script>
