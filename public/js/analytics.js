// получаем инфу о локации, потом шлем на бэк
fetch('/api/geo')
    .then(response => response.json())
    .then(data => {
        if (data.status !== 'success') return;

        fetch('/api/analytics/track', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                ip: data.query,
                city: data.city,
                country: data.country,
                user_agent: navigator.userAgent
            })
        })
        .catch(err => console.error('Analytics error:', err));
    })
    .catch(err => console.error('IP API error:', err));
