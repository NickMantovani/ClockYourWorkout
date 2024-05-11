<?php
require_once 'conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

try {
    $sql = "SELECT * FROM cadastro WHERE email=:email AND senha=:senha";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        // Usuário autenticado
        session_start();
        $_SESSION['email'] = $email;
        echo "Login bem-sucedido!";
    } else {
        echo "Email ou senha incorretos!";
    }
} catch (PDOException $e) {
    echo "Erro ao fazer login: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClockYourWorkout - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <h1>ClockYourWorkout</h1>
        </div>
    </nav>
    <div class="background">
        <div class="login-container">
            <div class="login-box">
                <h2>Login</h2>
    <form action="login.php" method="post">
                    <div class="input-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="senha">Senha:</label>
                        <input type="password" id="senha" name="senha" required>
                    </div>
                    <button type="submit">Entrar</button>
                </form>
            </div>
        </div>
    </div>
    <footer>
        <span>Criado por 
          <a>@Gabriel Alexandre</a>
          <a>@Nicolas Mantovani</a>
          <a>@Raphael Dantas</a>
          <a>@Victor Nunes</a>
        </span>
    </footer>
</body>
</html>