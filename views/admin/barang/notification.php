<div id="notification" class="fixed top-4 right-4 z-50 transform transition-all duration-500 translate-x-full opacity-0">
    <div class="bg-white rounded-xl shadow-2xl border-l-4 border-green-500 p-4 min-w-[320px] flex items-start gap-3">
        <div class="flex-shrink-0">
            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>
        <div class="flex-1">
            <h4 class="text-sm font-semibold text-heading" id="notification-title">Berhasil!</h4>
            <p class="text-xs text-body/70 mt-0.5" id="notification-message">Data berhasil disimpan</p>
        </div>
        <button onclick="closeNotification()" class="text-body/40 hover:text-body transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>