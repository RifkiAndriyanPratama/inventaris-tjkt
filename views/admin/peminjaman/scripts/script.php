<script>
// Notifikasi
function showNotification(type, message) {
    const notification = document.getElementById('notification');
    const title = document.getElementById('notification-title');
    const msg = document.getElementById('notification-message');
    const iconContainer = notification.querySelector('.w-8.h-8');
    
    notification.querySelector('.border-l-4').className = 'bg-white rounded-xl shadow-2xl border-l-4 p-4 min-w-[320px] flex items-start gap-3';
    
    if (type === 'success') {
        title.textContent = 'Berhasil!';
        notification.querySelector('.border-l-4').classList.add('border-green-500');
        iconContainer.className = 'w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center';
        iconContainer.innerHTML = '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
    } else if (type === 'error') {
        title.textContent = 'Gagal!';
        notification.querySelector('.border-l-4').classList.add('border-red-500');
        iconContainer.className = 'w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center';
        iconContainer.innerHTML = '<svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    } else if (type === 'warning') {
        title.textContent = 'Peringatan!';
        notification.querySelector('.border-l-4').classList.add('border-yellow-500');
        iconContainer.className = 'w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center';
        iconContainer.innerHTML = '<svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';
    }
    
    msg.textContent = message;
    
    notification.classList.remove('translate-x-full', 'opacity-0');
    notification.classList.add('translate-x-0', 'opacity-100');
    
    setTimeout(() => {
        closeNotification();
    }, 3000);
}

function closeNotification() {
    const notification = document.getElementById('notification');
    notification.classList.add('translate-x-full', 'opacity-0');
    notification.classList.remove('translate-x-0', 'opacity-100');
}

// Modal functions
function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    } else {
        console.error('Modal dengan id "' + id + '" tidak ditemukan!');
    }
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

// Fungsi untuk open modal edit peminjaman
function openEditModal(item) {
    console.log('Edit item:', item);
    
    // Isi field di modal edit peminjaman
    document.getElementById('edit-id').value = item.id_peminjaman;
    document.getElementById('edit-nama-user').value = item.nama + ' - ' + item.kelas;
    document.getElementById('edit-nama-barang').value = item.nama_barang + ' (ID: BRG-' + String(item.id_barang).padStart(4, '0') + ')';
    document.getElementById('edit-jumlah').value = item.jumlah;
    
    // Buka modal (sesuaikan dengan ID modal di modals/edit.php)
    openModal('edit'); // Jika ID modal di edit.php adalah 'edit'
    // openModal('modal-edit'); // Jika ID modal di edit.php adalah 'modal-edit'
}

// Fungsi untuk open modal hapus
function openHapusModal(id, nama) {
    document.getElementById('hapus-id').value = id;
    document.getElementById('hapus-nama').textContent = nama;
    document.getElementById('hapus-nama-input').value = nama;
    openModal('hapus'); // Sesuaikan dengan ID modal hapus
}

// Fungsi untuk konfirmasi pinjam
function konfirmasiPinjam(id) {
    if (confirm('Setujui peminjaman ini?')) {
        fetch('/admin/peminjaman.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=approve&id=' + id
        })
        .then(response => response.json())
        .then(data => {
            showNotification(data.success ? 'success' : 'error', data.message);
            if (data.success) setTimeout(() => location.reload(), 1500);
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan!');
        });
    }
}

// Fungsi untuk tolak pinjam
function tolakPinjam(id) {
    if (confirm('Tolak peminjaman ini?')) {
        fetch('/admin/peminjaman.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=tolak&id=' + id
        })
        .then(response => response.json())
        .then(data => {
            showNotification(data.success ? 'warning' : 'error', data.message);
            if (data.success) setTimeout(() => location.reload(), 1500);
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan!');
        });
    }
}

// Fungsi untuk kembalikan barang
function kembalikanBarang(id) {
    if (confirm('Konfirmasi pengembalian barang ini?')) {
        fetch('/admin/peminjaman.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=kembali&id=' + id
        })
        .then(response => response.json())
        .then(data => {
            showNotification(data.success ? 'success' : 'error', data.message);
            if (data.success) setTimeout(() => location.reload(), 1500);
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan!');
        });
    }
}

// Search & Filter
document.getElementById('searchInput')?.addEventListener('keyup', filterTable);
document.getElementById('filterStatus')?.addEventListener('change', filterTable);

function filterTable() {
    const searchText = document.getElementById('searchInput')?.value.toLowerCase() || '';
    const filterStatus = document.getElementById('filterStatus')?.value || '';
    const rows = document.querySelectorAll('tbody tr:not(:first-child)');
    
    rows.forEach(row => {
        const namaPeminjam = row.querySelector('td:nth-child(2) .font-medium')?.textContent.toLowerCase() || '';
        const namaBarang = row.querySelector('td:nth-child(3) .font-medium')?.textContent.toLowerCase() || '';
        const status = row.querySelector('td:nth-child(7) span')?.textContent.trim().toLowerCase() || '';
        
        const matchesSearch = namaPeminjam.includes(searchText) || namaBarang.includes(searchText);
        const matchesFilter = !filterStatus || status.includes(filterStatus);
        
        row.style.display = (matchesSearch && matchesFilter) ? '' : 'none';
    });
}

// Close modal with ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        ['tambah', 'edit', 'hapus'].forEach(id => {
            const modal = document.getElementById(id);
            if (modal && !modal.classList.contains('hidden')) {
                closeModal(id);
            }
        });
    }
});

// Notification from server
<?php if (isset($_SESSION['notification'])): ?>
document.addEventListener('DOMContentLoaded', function() {
    showNotification(
        '<?= $_SESSION['notification']['type'] ?>', 
        '<?= $_SESSION['notification']['message'] ?>'
    );
});
<?php unset($_SESSION['notification']); ?>
<?php endif; ?>
</script>