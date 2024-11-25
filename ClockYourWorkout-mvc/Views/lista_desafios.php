<?php
// desafios.php
require_once '../database/conexao.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Consulta para obter os desafios
$sql = "SELECT * FROM desafios";
$stmt = $conexao->prepare($sql);
$stmt->execute();
$desafios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Desafios de Treino</title>
    <link rel="stylesheet" href="../css/desafio.css">
</head>
<body>
    <div class="container">
        <h1>Desafios de Treino</h1>
        <a href="desafio.php">Criar Novo Desafio</a>
        <ul>
            <?php foreach ($desafios as $desafio): ?>
                <li>
                    <h2><?php echo htmlspecialchars($desafio['nome']); ?></h2>
                    <p><?php echo htmlspecialchars($desafio['descricao']); ?></p>
                    <p>Início: <?php echo htmlspecialchars($desafio['data_inicio']); ?> | Fim: <?php echo htmlspecialchars($desafio['data_fim']); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
