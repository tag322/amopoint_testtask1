<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Аналитика посещений</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="/css/dashboard.css">
</head>
<body>

<header>
    <h1>Аналитика посещений</h1>
    <form method="POST" action="/logout">
        @csrf
        <button type="submit" style="background:none;border:none;cursor:pointer;color:#fff;font-size:.9rem;opacity:.85;">Выйти</button>
    </form>
</header>

<div class="container">
    <div class="card">
        <div class="controls">
            <button data-period="hour">Час</button>
            <button data-period="day" class="active">День</button>
            <button data-period="month">Месяц</button>
        </div>
        <div class="chart-wrap">
            <canvas id="chart"></canvas>
            <p class="empty" id="empty" style="display:none">Нет данных за выбранный период</p>
        </div>
    </div>
</div>

<script src="/js/dashboard.js"></script>
</body>
</html>