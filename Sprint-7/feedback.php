<?php
session_start();
require_once 'conexao.php'; 

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['id'];

// Consulta os treinos agendados para o usuário
$sql = "SELECT id, data, hora, grupo_muscular FROM agendamentos WHERE usuario_id = :usuario_id ORDER BY data, hora";
$stmt = $conexao->prepare($sql);
$stmt->bindParam(':usuario_id', $usuario_id);
$stmt->execute();
$agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $agendamento_id = $_POST['agendamento_id'];
    $feedback = $_POST['feedback'];

    $sql_insert = "INSERT INTO feedback (agendamento_id, usuario_id, feedback) VALUES (:agendamento_id, :usuario_id, :feedback)";
    $stmt_insert = $conexao->prepare($sql_insert);

    $stmt_insert->bindParam(':agendamento_id', $agendamento_id);
    $stmt_insert->bindParam(':usuario_id', $usuario_id);
    $stmt_insert->bindParam(':feedback', $feedback);

    try {
        $stmt_insert->execute();
        echo "Feedback enviado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao enviar feedback: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Feedback</title>
    <link rel="stylesheet" href="css/feedback.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <h1>ClockYourWorkout - Feedback</h1>
        </div>
    </nav>
    <div class="login-container">
        <div class="login-box">
            <h2>Enviar Feedback sobre o Treino</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label>Escolha o treino:</label>
                <select name="agendamento_id" required>
                    <option value="">Selecione um treino...</option>
                    <?php foreach ($agendamentos as $agendamento): ?>
                        <option value="<?php echo htmlspecialchars($agendamento['id']); ?>">
                            <?php echo htmlspecialchars($agendamento['data'] . ' - ' . $agendamento['hora'] . ' (' . $agendamento['grupo_muscular'] . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br><br>
                <label>Feedback:</label><br>
                <textarea name="feedback" rows="5" cols="40" required></textarea><br><br>
                <input type="submit" value="Enviar Feedback">
            </form>
            <p><a href="meus_treinos.php">Voltar para meus agendamentos</a></p>
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
