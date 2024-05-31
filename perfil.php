<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Conexão com o banco de dados
require_once 'conexao.php'; // Altere para o caminho correto do arquivo de conexão

// Consulta SQL para obter informações do usuário
$sql = "SELECT * FROM cadastro WHERE id = :id";
$stmt = $conexao->prepare($sql);
$stmt->bindParam(':id', $_SESSION['id']);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <h1>Perfil do Usuário</h1>
        </div>
    </nav>
    <div class="background">
        <div class="login-container">
            <h2>Bem-vindo, <?php echo $usuario['nome']; ?>!</h2>
            <p>Email: <?php echo $usuario['email']; ?></p>
            <!-- Opções do perfil -->
            <ul>
                <li><a href="agendar_treino.php">Agendar Treino</a></li>
                <li><a href="meus_treinos.php">Ver Meus Treinos Agendados</a></li>
                <li><a href="editar_perfil.php">Editar Perfil</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
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