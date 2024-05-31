<?php
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Processa os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha']; // Alteração aqui

    // Hash da senha
    $hashed_senha = password_hash($senha, PASSWORD_DEFAULT);

    // Insere os dados na tabela de usuários
    $sql = "INSERT INTO cadastro (nome, email, senha) VALUES (:nome, :email, :senha)";
    $stmt = $conexao->prepare($sql);

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);

    try {
        $stmt->execute();
        echo "Usuário registrado com sucesso!";
        header("Location: perfil.php"); // Redireciona para a página do painel do usuário
    } catch(PDOException $e) {
        echo "Erro ao registrar usuário: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClockYourWorkout - Cadastro</title>
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
                <h2>Cadastro</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Nome de Usuário:</label>
        <input type="text" name="nome" required><br><br>
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        <label>Senha:</label>
        <input type="password" name="senha" required><br><br>
        <input type="submit" value="Registrar">
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
</body>
</html>
