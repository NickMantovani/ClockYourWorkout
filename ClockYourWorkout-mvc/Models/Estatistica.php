<?php
require_once '../database/conexao.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['id'];
$data_atual = date('Y-m-d');
$data_ultimo_ano = date('Y-m-d', strtotime('-1 year'));

// Buscar a quantidade de treinos por grupo muscular no último ano
$sql_grupos = "SELECT grupo_muscular, COUNT(*) AS total_treinos 
               FROM agendamentos 
               WHERE usuario_id = :usuario_id AND data >= :data_ultimo_ano 
               GROUP BY grupo_muscular 
               ORDER BY total_treinos DESC";
$stmt_grupos = $conexao->prepare($sql_grupos);
$stmt_grupos->bindParam(':usuario_id', $usuario_id);
$stmt_grupos->bindParam(':data_ultimo_ano', $data_ultimo_ano);
$stmt_grupos->execute();
$grupos_treinos = $stmt_grupos->fetchAll(PDO::FETCH_ASSOC);

// Buscar a quantidade de treinos por mês no último ano
$sql_meses = "SELECT MONTH(data) AS mes, COUNT(*) AS total_treinos 
              FROM agendamentos 
              WHERE usuario_id = :usuario_id AND data >= :data_ultimo_ano 
              GROUP BY mes 
              ORDER BY mes DESC";
$stmt_meses = $conexao->prepare($sql_meses);
$stmt_meses->bindParam(':usuario_id', $usuario_id);
$stmt_meses->bindParam(':data_ultimo_ano', $data_ultimo_ano);
$stmt_meses->execute();
$treinos_por_mes = $stmt_meses->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClockYourWorkout - Estatísticas de Treinos</title>
    <link rel="stylesheet" href="css\estatisticas.css">
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
                <h2>Estatísticas de Treinos - Último Ano</h2>

                <h3>Grupo Muscular Mais Treinado</h3>
                <?php if (count($grupos_treinos) > 0): ?>
                    <p>O grupo muscular mais treinado foi: <strong><?php echo htmlspecialchars($grupos_treinos[0]['grupo_muscular']); ?></strong></p>
                    <p>Total de treinos deste grupo: <?php echo htmlspecialchars($grupos_treinos[0]['total_treinos']); ?></p>
                <?php else: ?>
                    <p>Você não tem treinos registrados no último ano.</p>
                <?php endif; ?>

                <h3>Treinos por Mês</h3>
                <?php if (count($treinos_por_mes) > 0): ?>
                    <table>
                        <tr>
                            <th>Mês</th>
                            <th>Total de Treinos</th>
                        </tr>
                        <?php foreach ($treinos_por_mes as $treino): ?>
                            <tr>
                                <td>
                                    <?php 
                                    // Converter o número do mês para o nome do mês em português
                                    setlocale(LC_TIME, 'pt_BR.UTF-8');
                                    echo strftime('%B', mktime(0, 0, 0, $treino['mes'], 10)); 
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($treino['total_treinos']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p>Nenhum treino realizado nos últimos meses.</p>
                <?php endif; ?>

                <p><a href="meus_treinos.php">Voltar para meus agendamentos</a></p>
            </div>
        </div>
    </div>
</body>
</html>
