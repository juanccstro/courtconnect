// Popup de mensajes flash (animación)
document.addEventListener('DOMContentLoaded', function () {
    const toast = document.getElementById('ccToast');
    if (toast) {
        setTimeout(() => toast.classList.add('show'), 50);
        setTimeout(() => toast.classList.remove('show'), 4000);
    }
});
