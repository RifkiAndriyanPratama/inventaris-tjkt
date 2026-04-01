<div class="w-full max-w-md mx-auto">
    <!-- Logo/Brand yang lebih elegan -->
    <div class="text-center mb-8">
        <div class="relative inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-brand to-brand-strong rounded-2xl shadow-lg mb-5 transform hover:scale-105 transition-transform duration-300">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-400 border-2 border-white rounded-full animate-pulse"></div>
        </div>
        <h1 class="text-3xl font-bold bg-gradient-to-r from-heading to-brand bg-clip-text text-transparent">Inventaris TJKT</h1>
        <p class="text-sm text-body/80 mt-2 tracking-wide">SMK Negeri 1 Pundong</p>
    </div>

    <!-- Card dengan desain lebih modern -->
    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl border border-white/20 p-8">
        <div class="mb-8 mx-auto text-center">
            <h2 class="text-xl font-semibold text-heading mb-1">Selamat Datang</h2>
            <p class="text-sm text-body/70">Silakan masuk ke akun Anda untuk melanjutkan</p>
        </div>

        <?php if(isset($error) && $error): ?>
        <div class="mb-6 p-4 bg-red-50/90 backdrop-blur-sm border border-red-200/50 text-red-600 rounded-2xl text-sm flex items-center space-x-3" role="alert">
            <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="flex-1 font-medium"><?php echo htmlspecialchars($error); ?></span>
            <button type="button" class="text-red-400 hover:text-red-600" onclick="this.parentElement.remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <?php endif; ?>

        <?php if(isset($success) && $success): ?>
        <div class="mb-6 p-4 bg-green-50/90 backdrop-blur-sm border border-green-200/50 text-green-600 rounded-2xl text-sm flex items-center space-x-3">
            <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <span class="flex-1 font-medium"><?php echo htmlspecialchars($success); ?> Mengalihkan...</span>
            <div class="w-4 h-4 border-2 border-green-500 border-t-transparent rounded-full animate-spin"></div>
        </div>
        <?php endif; ?>

        <form action="/login.php" method="POST" class="space-y-5">
            <div class="space-y-1.5">
                <label for="nama" class="block text-sm font-medium text-heading/90 ml-1">
                    Nama Lengkap
                </label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-body/40 group-focus-within:text-brand transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <input type="text" 
                           id="nama" 
                           name="nama"
                           value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>"
                           class="w-full bg-neutral-secondary-soft/50 border border-default/60 text-heading text-sm rounded-xl pl-10 pr-4 py-3.5 focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all duration-200 placeholder:text-body/30 hover:border-default"
                           placeholder="cth: Budi Santoso" 
                           required />
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="password" class="block text-sm font-medium text-heading/90 ml-1">
                    Kata Sandi
                </label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-body/40 group-focus-within:text-brand transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input type="password" 
                           id="password" 
                           name="password"
                           class="w-full bg-neutral-secondary-soft/50 border border-default/60 text-heading text-sm rounded-xl pl-10 pr-4 py-3.5 focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all duration-200 placeholder:text-body/30 hover:border-default"
                           placeholder="••••••••" 
                           required />
                </div>
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-brand to-brand-strong hover:from-brand-strong hover:to-brand text-white font-semibold rounded-xl px-5 py-3.5 text-sm text-center transition-all duration-300 transform hover:scale-[1.02] focus:ring-4 focus:ring-brand/30 shadow-lg shadow-brand/25 mt-6">
                <span class="flex items-center justify-center space-x-2">
                    <span>Masuk ke Dashboard</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </span>
            </button>
        </form>
    </div>

    <!-- Footer -->
    <p class="text-center text-xs text-body/50 mt-6">
        © 2026 Inventaris TJKT • v1.0.0
    </p>
</div>