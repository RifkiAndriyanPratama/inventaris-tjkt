<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Inventaris TJKT</title>
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
</head>
<body class="bg-neutral-secondary-soft font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar User -->
        <aside class="w-64 bg-white border-r border-default flex flex-col flex-shrink-0">
            <div class="flex items-center space-x-3 px-6 py-5 border-b border-default">
                <div class="w-8 h-8 bg-brand rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <span class="font-semibold text-heading text-sm">Inventaris TJKT</span>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1">
                <?php
                // Tentukan halaman aktif
                $current_page = basename($_SERVER['PHP_SELF']);
                ?>
                
                <a href="/user/dashboard.php" 
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                   <?= $current_page === 'dashboard.php' ? 'bg-brand text-white' : 'text-body hover:bg-neutral-secondary-soft hover:text-heading' ?>">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
                
                <a href="/user/riwayat.php" 
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                   <?= $current_page === 'riwayat.php' ? 'bg-brand text-white' : 'text-body hover:bg-neutral-secondary-soft hover:text-heading' ?>">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span>Riwayat</span>
                </a>
            </nav>

            <div class="px-3 py-4 border-t border-default">
                <div class="flex items-center space-x-3 px-3 py-2 mb-1 bg-neutral-secondary-soft rounded-lg">
                    <div class="w-8 h-8 bg-gradient-to-br from-brand to-brand-strong rounded-full flex items-center justify-center">
                        <span class="text-xs font-semibold text-white">
                            <?= strtoupper(substr($_SESSION['user']['nama'] ?? 'U', 0, 1)) ?>
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-heading truncate"><?= htmlspecialchars($_SESSION['user']['nama'] ?? 'User') ?></p>
                        <p class="text-xs text-body truncate"><?= htmlspecialchars($_SESSION['user']['kelas'] ?? '-') ?></p>
                    </div>
                </div>
                <a href="/logout.php" class="w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-500 hover:bg-red-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto">
            <div class="p-8">
                <?php include $content; ?>
            </div>
        </main>
    </div>

    <!-- Notification -->
    <?php if (isset($_SESSION['notification'])) { ?>
    <div id="notification" class="fixed top-4 right-4 z-50">
        <div class="bg-white rounded-xl shadow-2xl border-l-4 <?= $_SESSION['notification']['type'] === 'success' ? 'border-green-500' : 'border-red-500' ?> p-4 min-w-[320px]">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 <?= $_SESSION['notification']['type'] === 'success' ? 'bg-green-100' : 'bg-red-100' ?> rounded-lg flex items-center justify-center">
                        <?php if ($_SESSION['notification']['type'] === 'success') { ?>
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <?php } else { ?>
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <?php } ?>
                    </div>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-heading"><?= $_SESSION['notification']['type'] === 'success' ? 'Berhasil!' : 'Gagal!' ?></h4>
                    <p class="text-xs text-body/70 mt-0.5"><?= $_SESSION['notification']['message'] ?></p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-body/40 hover:text-body">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const notif = document.getElementById('notification');
            if (notif) notif.remove();
        }, 3000);
    </script>
    <?php unset($_SESSION['notification']); ?>
    <?php } ?>
</body>
</html>
