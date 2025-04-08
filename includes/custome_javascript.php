<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countdownElement = document.querySelector('.countdown');
        if (!countdownElement) return;

        // Set initial time (10 minutes in seconds)
        let timeLeft = 600;

        // Update the countdown every second
        const countdownInterval = setInterval(function() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;

            // Format as MM:SS with leading zeros
            countdownElement.textContent =
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            // When time runs out
            if (timeLeft <= 0) {
                clearInterval(countdownInterval);
                countdownElement.closest('a').style.display = 'none';

                // Optional: You could also disable the form here
                // document.querySelector('.verification-form').querySelector('button').disabled = true;
            }

            timeLeft--;
        }, 1000);
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password toggle functionality
        document.querySelectorAll('[data-password-toggle]').forEach(button => {
            button.addEventListener('click', function() {
                const container = this.closest('[data-password]');
                const input = container.querySelector('[data-password-input]');
                const showIcon = this.querySelector('.show');
                const hideIcon = this.querySelector('.hide');

                if (input.type === 'password') {
                    input.type = 'text';
                    showIcon.style.display = 'none';
                    hideIcon.style.display = 'block';
                } else {
                    input.type = 'password';
                    showIcon.style.display = 'block';
                    hideIcon.style.display = 'none';
                }
            });
        });

        // Initialize hide icons to be hidden initially
        document.querySelectorAll('.hide').forEach(icon => {
            icon.style.display = 'none';
        });
    });
</script>