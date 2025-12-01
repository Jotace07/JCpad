<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de</title>

    <link href="/Assets/style.css" rel="stylesheet" type="text/css">

</head>
<body class="login-page">
    <div class="login-container">
        <h2>Login</h2>
        <form action="/login" method="post">
            <div class="form-group">
                <label for="username">Username or Email:</label>
                <input type="text" id="username" name="username" placeholder="Digite seu nome de usuário" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
            </div>
            <div class="form-group">
                <button id="login_btn" type="submit">Login</button>
            </div>
        </form>
    </div>
    <script src="/Assets/login.js"> </script>
</body>
</html>