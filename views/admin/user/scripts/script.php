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
    document.getElementById(id).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function openEditModal(item) {
    document.getElementById('edit-id').value = item.id;
    document.getElementById('edit-nis').value = item.nis;
    document.getElementById('edit-nama').value = item.nama;
    document.getElementById('edit-kelas').value = item.kelas;
    document.getElementById('edit-password').value = ''; // Kosongkan password saat edit
    document.getElementById('edit-role').value = item.role || 'user';
    openModal('modal-edit');
}

function openHapusModal(id, nama) {
    document.getElementById('hapus-id').value = id;
    document.getElementById('hapus-nama').textContent = nama;
    document.getElementById('hapus-nama-input').value = nama;
    openModal('modal-hapus');
}

// Search & Filter
document.getElementById('searchInput')?.addEventListener('keyup', filterTable);
document.getElementById('filterStatus')?.addEventListener('change', filterTable);

function filterTable() {
    const searchText = document.getElementById('searchInput')?.value.toLowerCase() || '';
    const filterStatus = document.getElementById('filterStatus')?.value || '';
    const rows = document.querySelectorAll('tbody tr:not(:first-child)');
    
    rows.forEach(row => {
        const namaBarang = row.querySelector('td:nth-child(2) .font-medium')?.textContent.toLowerCase() || '';
        const status = row.querySelector('td:nth-child(4) span')?.textContent.trim().toLowerCase() || '';
        
        const matchesSearch = namaBarang.includes(searchText);
        const matchesFilter = !filterStatus || status.includes(filterStatus);
        
        row.style.display = (matchesSearch && matchesFilter) ? '' : 'none';
    });
}

// Close modal with ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        ['modal-tambah', 'modal-edit', 'modal-hapus'].forEach(id => {
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