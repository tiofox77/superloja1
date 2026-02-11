<!-- Toast Notifications - Simple Version -->
<div id="toast-container" class="fixed top-4 right-4 z-[9999] flex flex-col gap-3 pointer-events-none"></div>

<script>
(function() {
    // Evitar múltiplas inicializações
    if (window.toastInitialized) return;
    window.toastInitialized = true;
    
    const container = document.getElementById('toast-container');
    
    function showToast(data) {
        // Ignorar toasts sem mensagem
        if (!data || !data.message) return;
        
        const type = data.type || 'info';
        const message = data.message;
        const duration = data.duration || 4000;
        
        const colors = {
            success: { bg: 'bg-green-100', text: 'text-green-600', border: 'border-green-200', bar: 'bg-green-500' },
            error: { bg: 'bg-red-100', text: 'text-red-600', border: 'border-red-200', bar: 'bg-red-500' },
            warning: { bg: 'bg-yellow-100', text: 'text-yellow-600', border: 'border-yellow-200', bar: 'bg-yellow-500' },
            info: { bg: 'bg-blue-100', text: 'text-blue-600', border: 'border-blue-200', bar: 'bg-blue-500' }
        };
        
        const titles = { success: 'Sucesso!', error: 'Erro!', warning: 'Atenção!', info: 'Informação' };
        const icons = {
            success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>',
            error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>',
            warning: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>',
            info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
        };
        
        const c = colors[type] || colors.info;
        
        const toast = document.createElement('div');
        toast.className = `pointer-events-auto w-80 bg-white rounded-xl shadow-xl border ${c.border} overflow-hidden transform translate-x-full opacity-0 transition-all duration-300`;
        toast.innerHTML = `
            <div class="flex items-start gap-3 p-4">
                <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center ${c.bg} ${c.text}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">${icons[type] || icons.info}</svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900">${titles[type] || 'Notificação'}</p>
                    <p class="mt-0.5 text-sm text-gray-600">${message}</p>
                </div>
                <button class="close-toast flex-shrink-0 p-1 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="h-1 w-full bg-gray-100">
                <div class="progress-bar h-full ${c.bar} transition-all duration-100 ease-linear" style="width: 100%"></div>
            </div>
        `;
        
        container.appendChild(toast);
        
        // Animar entrada
        requestAnimationFrame(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
        });
        
        // Botão fechar
        toast.querySelector('.close-toast').addEventListener('click', () => removeToast(toast));
        
        // Progress bar e auto-remove
        const progressBar = toast.querySelector('.progress-bar');
        let progress = 100;
        const interval = setInterval(() => {
            progress -= 2;
            progressBar.style.width = progress + '%';
            if (progress <= 0) {
                clearInterval(interval);
                removeToast(toast);
            }
        }, duration / 50);
        
        toast._interval = interval;
    }
    
    function removeToast(toast) {
        if (toast._interval) clearInterval(toast._interval);
        toast.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    }
    
    // Escutar evento do Livewire
    window.addEventListener('toast', (e) => showToast(e.detail));
    
    // Expor globalmente para testes
    window.showToast = showToast;
})();
</script>
