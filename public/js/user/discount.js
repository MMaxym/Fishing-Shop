document.addEventListener('DOMContentLoaded', function () {
    const timers = document.querySelectorAll('.discount-timer-products');

    timers.forEach(timer => {
        const endDateStr = timer.getAttribute('data-end-date');
        const endDate = new Date(endDateStr);

        const timerValue = timer.querySelector('.timer-value-products');

        function getDayWord(number) {
            const lastTwoDigits = number % 100;
            const lastDigit = number % 10;

            if (lastTwoDigits >= 11 && lastTwoDigits <= 14) {
                return 'днів';
            }

            if (lastDigit === 1) {
                return 'день';
            }

            if (lastDigit >= 2 && lastDigit <= 4) {
                return 'дні';
            }

            return 'днів';
        }

        function updateTimer() {
            const now = new Date();
            const diff = endDate - now;

            if (diff <= 0) {
                timerValue.textContent = 'Акція завершена';
                clearInterval(interval);
                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
            const minutes = Math.floor((diff / (1000 * 60)) % 60);
            const seconds = Math.floor((diff / 1000) % 60);

            const dayWord = getDayWord(days);

            timerValue.textContent = `${days} ${dayWord} ${padZero(hours)}:${padZero(minutes)}:${padZero(seconds)}`;
        }

        function padZero(number) {
            return number < 10 ? '0' + number : number;
        }

        updateTimer();
        const interval = setInterval(updateTimer, 1000);
    });
});
