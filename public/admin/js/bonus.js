document.addEventListener('DOMContentLoaded', () => {
const messages = document.querySelectorAll('.message');

    messages.forEach(function(message) {
        if (message.textContent.trim() !== '') {
            // Show message
            message.style.display = 'block';

            setTimeout(function() {
                message.style.opacity = '0';
                message.style.transition = 'opacity 0.5s ease-in-out';

                setTimeout(function() {
                    message.remove();
                }, 500);
            }, 2000);
        }
    });
});