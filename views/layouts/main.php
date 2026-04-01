<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inventaris TJKT</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
    theme: {
        extend: {
            fontFamily: { sans: ['Inter', 'ui-sans-serif'] },
            colors: {
                brand: '#3B82F6',
                'brand-strong': '#2563EB',
                'brand-medium': '#93C5FD',
                'neutral-secondary-soft': '#F9FAFB',
                'neutral-secondary-medium': '#F3F4F6',
                heading: '#111827',
                body: '#6B7280',
                default: '#E5E7EB',
                'default-medium': '#D1D5DB'
            }
        }
    }
}
</script>
<link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-neutral-secondary-soft font-sans">
<div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-default flex flex-col flex-shrink-0">
        <!-- Logo -->
        <div class="flex items-center space-x-3 px-6 py-5 border-b border-default">
            <div class="w-8 h-8 bg-brand rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <span class="font-semibold text-heading text-sm">Inventaris TJKT</span>
        </div>

        <!-- Nav -->
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <a href="/admin/dashboard.php" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium <?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'bg-brand text-white' : 'text-body hover:bg-neutral-secondary-soft hover:text-heading'; ?> transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Dashboard</span>
            </a>
            <a href="/admin/barang.php" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium <?php echo basename($_SERVER['PHP_SELF']) === 'barang.php' ? 'bg-brand text-white' : 'text-body hover:bg-neutral-secondary-soft hover:text-heading'; ?> transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                <span>Barang</span>
            </a>
            <a href="/admin/user.php" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium <?php echo basename($_SERVER['PHP_SELF']) === 'user.php' ? 'bg-brand text-white' : 'text-body hover:bg-neutral-secondary-soft hover:text-heading'; ?> transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span>User</span>
            </a>
            <a href="/admin/peminjaman.php" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium <?php echo basename($_SERVER['PHP_SELF']) === 'peminjaman.php' ? 'bg-brand text-white' : 'text-body hover:bg-neutral-secondary-soft hover:text-heading'; ?> transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span>Peminjaman</span>
            </a>
            <a href="/admin/laporan.php" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium <?php echo basename($_SERVER['PHP_SELF']) === 'laporan.php' ? 'bg-brand text-white' : 'text-body hover:bg-neutral-secondary-soft hover:text-heading'; ?> transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Laporan</span>
            </a>
        </nav>

        <!-- User + Logout -->
        <div class="px-3 py-4 border-t border-default">
            <div class="flex items-center space-x-3 px-3 py-2 mb-1">
                <div class="w-8 h-8 bg-brand-medium rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-xs font-semibold text-brand-strong"><?php echo strtoupper(substr($_SESSION['user']['nama'] ?? 'A', 0, 1)); ?></span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-heading truncate"><?php echo htmlspecialchars($_SESSION['user']['nama'] ?? ''); ?></p>
                    <p class="text-xs text-body truncate"><?php echo htmlspecialchars($_SESSION['user']['role'] ?? ''); ?></p>
                </div>
            </div>
            <a href="#" onclick="openLogoutModal()" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-500 hover:bg-red-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Logout</span>
            </a>

        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <div class="p-8">
            <?php include $content; ?>
        </div>
    </main>

    <!-- Logout Modal -->
    <div id="logout-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <div id="logout-backdrop" class="absolute inset-0 bg-black/50 opacity-0 transition-opacity duration-200"></div>
        <div id="logout-card" class="relative bg-white rounded-2xl p-6 w-80 shadow-xl scale-95 opacity-0 transition-all duration-200">
            <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-heading mb-1">Keluar dari sistem?</h3>
            <p class="text-sm text-body mb-6">Sesi kamu akan diakhiri dan kamu akan diarahkan ke halaman login.</p>
            <div class="flex space-x-3">
                <button onclick="closeLogoutModal()"
                    class="flex-1 px-4 py-2 text-sm font-medium text-body border border-default rounded-lg hover:bg-neutral-secondary-soft transition-colors">
                    Batal
                </button>
                <a href="/logout.php"
                    class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-500 hover:bg-red-600 rounded-lg text-center transition-colors">
                    Ya, Logout
                </a>
            </div>
        </div>
    </div>
    
    <script>
    function openLogoutModal() {
        const modal = document.getElementById('logout-modal');
        const backdrop = document.getElementById('logout-backdrop');
        const card = document.getElementById('logout-card');
        modal.classList.remove('hidden');
        setTimeout(() => {
            backdrop.classList.add('opacity-100');
            card.classList.remove('scale-95', 'opacity-0');
            card.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
    
    function closeLogoutModal() {
        const modal = document.getElementById('logout-modal');
        const backdrop = document.getElementById('logout-backdrop');
        const card = document.getElementById('logout-card');
        backdrop.classList.remove('opacity-100');
        card.classList.add('scale-95', 'opacity-0');
        card.classList.remove('scale-100', 'opacity-100');
        setTimeout(() => modal.classList.add('hidden'), 200);
    }
    </script>
</div>
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
</html>