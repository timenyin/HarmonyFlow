class TourTimelineAnimation {
    constructor() {
        this.timelinePoints = Array.from(document.querySelectorAll('.p-2.rounded-2.bg-body-highlight.position-relative'));
        this.timelineLines = Array.from(document.querySelectorAll('.tour-direction-line'));
        this.numberSpans = Array.from(document.querySelectorAll('.bg-secondary.rounded-pill'));
        this.currentIndex = 0;
        this.animationDuration = 2000; // 2 seconds per step
        this.init();
    }

    init() {
        // Add necessary classes
        this.timelinePoints.forEach(point => point.classList.add('timeline-point'));
        this.numberSpans.forEach(span => span.classList.add('timeline-number'));
        this.startAnimation();
    }

    async animateStep(index) {
        // Reset previous active states
        this.timelinePoints.forEach((point, i) => {
            if (i < index) {
                point.querySelector('.tour-direction-line')?.classList.add('passed');
            }
        });

        // Activate current point
        const currentPoint = this.timelinePoints[index];
        const currentLine = this.timelineLines[index];
        const currentNumber = this.numberSpans[index];

        if (currentPoint && currentLine) {
            // Remove active state from previous points
            this.timelinePoints.forEach(point => point.classList.remove('active'));
            this.timelineLines.forEach(line => line.classList.remove('active'));

            // Activate current point
            currentPoint.classList.add('active');
            currentLine.classList.add('active');
            currentLine.classList.remove('passed');

            // Change number background
            if (currentNumber) {
                currentNumber.classList.remove('bg-secondary');
                currentNumber.classList.add('bg-primary-lighter');
            }

            // Wait for animation
            await new Promise(resolve => setTimeout(resolve, this.animationDuration));

            // Reset current point but keep the line passed state
            currentPoint.classList.remove('active');
            currentLine.classList.remove('active');
            currentLine.classList.add('passed');

            // Reset number background
            if (currentNumber) {
                currentNumber.classList.remove('bg-primary-lighter');
                currentNumber.classList.add('bg-secondary');
            }
        }
    }

    async startAnimation() {
        while (true) {
            for (let i = 0; i < this.timelinePoints.length; i++) {
                await this.animateStep(i);
            }
            // Reset all passed states before restarting
            this.timelineLines.forEach(line => line.classList.remove('passed'));
            // Pause before restarting
            await new Promise(resolve => setTimeout(resolve, 1500));
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new TourTimelineAnimation();
});