
// script.js
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('contact-form');
    const responseMessage = document.getElementById('response-message');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const response = await fetch('contact.php', {
            method: 'POST',
            body: formData,
        });
        const result = await response.text();

        if (response.ok) {
            responseMessage.textContent = 'Thank you for your message! We have received it and will get back to you shortly.';
            setTimeout(() => {
                location.reload(); // Refresh the page after 2 seconds
            }, 3000);
        } else {
            responseMessage.textContent = 'Error: ' + result;
        }
    });
});




