<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="/css/login.css">
</head>
<body>
<div class="card">
    <h1>Тест</h1>
    <form method="POST" action="/login">
        @csrf
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" autofocus>
        @error('email') <p class="error">{{ $message }}</p> @enderror

        <label for="password">Пароль</label>
        <input id="password" type="password" name="password">

        <button type="submit">Войти</button>
    </form>
</div>
</body>
</html>
