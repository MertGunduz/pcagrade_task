document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('send-message-form');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const formData = new FormData(form);

        fetch('php/send_message.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                form.reset();
            } else {
                alert('Failed to send the message. \n\n' + data.errors.join(', '));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while sending the message.');
        });

        return false; // Ensure the default action is completely prevented
    });
});
