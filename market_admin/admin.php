<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Cadastro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'admin' && $password === 'password') {
        $_SESSION['loggedin'] = true;
    } else {
        echo '<div class="container"><p class="error">Usuário ou senha incorretos!</p></div>';
    }
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo '
    <div class="login-container">
        <h2>Login</h2>
        <form method="post" action="">
            <input type="text" name="username" placeholder="Nome de usuário" required>
            <input type="password" name="password" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
    </div>';
} else {
    include 'tasks.php';
}
?>

</body>
</html>
