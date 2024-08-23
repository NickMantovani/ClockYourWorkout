<?php
session_start();
require_once 'conexao.php'; 

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['id'];

// Consulta SQL para obter informações do usuário
$sql = "SELECT * FROM cadastro WHERE id = :id";
$stmt = $conexao->prepare($sql);
$stmt->bindParam(':id', $usuario_id);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "Erro: Usuário não encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="perfil.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <h1>Perfil do Usuário</h1>
        </div>
    </nav>
    <div class="login-container">
        <div class="background">
            <h2>Bem-vindo, <?php echo htmlspecialchars($usuario['nome']); ?>!</h2>
            <p>Email: <?php echo htmlspecialchars($usuario['email']); ?></p>
            <?php if (!empty($usuario['foto_perfil'])): ?>
                <img src="<?php echo htmlspecialchars($usuario['foto_perfil']); ?>" alt="Foto de Perfil" class="foto-perfil">
            <?php else: ?>
                <p>Foto de Perfil não disponível.</p>
            <?php endif; ?>
            <!-- Opções do perfil -->
            <ul>
                <li><a href="agendamento.php">Agendar Treino</a></li>
                <li><a href="dados-acad.php">Calculo-TMB</a></li>
                <li><a href="meus_treinos.php">Ver Meus Treinos Agendados</a></li>
                <li><a href="editar_perfil.php">Editar Perfil</a></li>
                <li><a href="logout.php">Sair</a></li>
                <li><a href="blog_saude.php">Acessar Blog de Saúde e Bem-estar</a></li>
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
