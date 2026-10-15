document.querySelectorAll('.notification.notification-succes').forEach(notification => {
    setTimeout(() => {
        notification.remove();
    }, 10000);
});

document.querySelectorAll('.fermer-notification').forEach(bouton => {
    bouton.addEventListener('click', () => {
        const notification = bouton.closest('.notification');
        bouton.blur();
        notification.remove();
    });
});