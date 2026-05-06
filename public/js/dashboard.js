let chart = null;
let currentPeriod = 'day';

function randomColors(n) {
    const palette = [
        '#6366f1', '#f59e0b', '#10b981', '#ef4444', '#3b82f6',
        '#8b5cf6', '#ec4899', '#14b8a6', '#f97316', '#84cc16'
    ];
    return Array.from({length: n}, (_, i) => palette[i % palette.length]);
}

function loadData(period) {
    fetch('/analytics/visits?period=' + period)
        .then(r => r.json())
        .then(data => {
            const empty = document.getElementById('empty');
            const canvas = document.getElementById('chart');

            if (!data.length) {
                canvas.style.display = 'none';
                empty.style.display = 'block';
                if (chart) { chart.destroy(); chart = null; }
                return;
            }

            canvas.style.display = 'block';
            empty.style.display = 'none';

            const labels = data.map(d => d.city || 'Неизвестно');
            const counts = data.map(d => d.count);
            const colors = randomColors(labels.length);

            if (chart) chart.destroy();

            chart = new Chart(canvas, {
                type: 'pie',
                data: {
                    labels,
                    datasets: [{
                        data: counts,
                        backgroundColor: colors,
                    }]
                },
                options: {
                    plugins: {
                        legend: { position: 'right' },
                        tooltip: {
                            callbacks: {
                                label: ctx => ` ${ctx.label}: ${ctx.parsed} визитов`
                            }
                        }
                    }
                }
            });
        });
}

document.querySelectorAll('.controls button').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.controls button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        currentPeriod = btn.dataset.period;
        loadData(currentPeriod);
    });
});

loadData(currentPeriod);
