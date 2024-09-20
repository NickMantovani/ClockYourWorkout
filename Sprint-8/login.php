<?php
require_once 'conexao.php'; // Altere para o caminho correto do arquivo de conexão

if(isset($_POST['email']) && isset($_POST['senha'])) {

    if(strlen($_POST['email']) == 0) {
        echo "Preencha seu e-mail";
    } else if(strlen($_POST['senha']) == 0) {
        echo "Preencha sua senha";
    } else {

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sql = "SELECT * FROM cadastro WHERE email = :email AND senha = :senha";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();

        $quantidade = $stmt->rowCount();

        if($quantidade == 1) {
            
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            header("Location: perfil.php");
            exit();

        } else {
            echo "Falha ao logar! E-mail ou senha incorretos";
        }

    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClockYourWorkout - Login</title>
    <link rel="stylesheet" href="css\login.css">
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
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label>Email:</label>
                    <input type="email" name="email" required><br><br>
                    <label>Senha:</label>
                    <input type="password" name="senha" required><br><br>
                    <?php if(!empty($erro_login)) echo "<p class='error'>$erro_login</p>"; ?>
                    <input type="submit" value="Entrar">
                </form>
                <p>Ainda não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
                <a href="index.php" class="back-button">Voltar à Página Principal</a>
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
