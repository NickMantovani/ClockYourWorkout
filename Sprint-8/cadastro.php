<?php
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Processa os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha']; 

    // Biblioteca de imagens
    $imagens = [
        'profile_pics/pic1.jpg', 
        'profile_pics/pic2.jpg', 
        'profile_pics/pic3.jpg', 
        'profile_pics/pic4.png', 
        'profile_pics/pic5.png', 
        'profile_pics/pic6.png', 
        'profile_pics/pic7.png', 
        'profile_pics/pic8.png', 
        'profile_pics/pic9.jpg', 
        'profile_pics/pic10.jpg'
    ];

    // Seleciona uma imagem aleatoriamente
    $imagem_selecionada = $imagens[array_rand($imagens)];

    // Insere os dados na tabela de usuários
    $sql = "INSERT INTO cadastro (nome, email, senha, foto_perfil) VALUES (:nome, :email, :senha, :foto_perfil)";
    $stmt = $conexao->prepare($sql);

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha); 
    $stmt->bindParam(':foto_perfil', $imagem_selecionada);

    try {
        $stmt->execute();
        echo "Usuário registrado com sucesso!";
        header("Location: perfil.php"); // Redireciona para a página do painel do usuário
        exit();
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
    <link rel="stylesheet" href="css/cadastro.css">
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
</body>
</html>
