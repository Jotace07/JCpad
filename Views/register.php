<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link href="/Assets/style.css" rel="stylesheet" type="text/css">

</head>
<body class="register-page">
    <div class="register-container">
        <h2>Criar Conta</h2>
        <form action="#" method="post">
            <div class="form-group">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" placeholder="Digite seu nome de usuário" required>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
            </div>
            <div class="form-group">
                <button type="submit">Registrar</button>
            </div>
            <a class="login-link" href="/login">Já tem uma conta? Faça login</a>
        </form>
    </div>
    <script src="/Assets/register.js"> </script>
</body>
</html>
