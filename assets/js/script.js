document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar em telas pequenas
    const toggleSidebar = document.querySelector('.toggle-sidebar');
    const sidebar = document.querySelector('.sidebar');
    
    if (toggleSidebar && sidebar) {
        toggleSidebar.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
    }
    
    // Tags input para palavras-chave
    const palavrasChaveInput = document.getElementById('palavras_chave');
    
    if (palavrasChaveInput) {
        palavrasChaveInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ',') {
                e.preventDefault();
                const value = this.value.trim();
                
                if (value) {
                    const currentValue = this.value;
                    this.value = currentValue + (currentValue ? ', ' : '') + value;
                }
            }
        });
    }
    
    // Mostrar mensagens de sucesso/erro
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 300);
        }, 5000);
    });
});