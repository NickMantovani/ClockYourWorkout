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

// Array de mensagens motivacionais
$mensagens = [
    "Continue se esforçando, você está no caminho certo!",
    "O esforço de hoje é o sucesso de amanhã.",
    "Cada treino é um passo em direção ao seu objetivo!",
    "Não desista, sua melhor versão está por vir!",
    "Força e foco! Você está mais perto do que imagina.",
    "A consistência é o segredo do sucesso.",
    "Seu corpo pode, sua mente também pode!",
    "O único treino ruim é aquele que não aconteceu!",
    "Transforme obstáculos em desafios vencidos!",
    "A jornada é longa, mas os resultados valem a pena."
];

// Seleciona uma mensagem aleatória
$mensagem_motivacional = $mensagens[array_rand($mensagens)];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="css/perfil.css">
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

            <!-- Exibe a mensagem motivacional -->
            <p class="mensagem-motivacional"><?php echo $mensagem_motivacional; ?></p>

            <!-- Opções do perfil -->
            <ul>
                <li><a href="agendamento.php">Agendar Treino</a></li>
                <li><a href="dados-acad.php">Calculo-TMB</a></li>
                <li><a href="meus_treinos.php">Ver Meus Treinos Agendados</a></li>
                <li><a href="estatisticas.php">Estatisticas</a></li>
                <li><a href="metas_treino.php">Metas de Treino</a></li>
                <li><a href="editar_perfil.php">Editar Perfil</a></li>
                <li><a href="desafio.php">Desafios</a></li>
                <li><a href="suporte_tecnico.php">Suporte Técnico</a></li>
                <li><a href="feedback.php">Enviar Feedback do Treino</a></li> 
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
