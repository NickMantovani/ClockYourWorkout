<?php
require_once 'conexao.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['id'];

$sql = "SELECT data, hora FROM agendamentos WHERE usuario_id = :usuario_id ORDER BY data, hora";
$stmt = $conexao->prepare($sql);
$stmt->bindParam(':usuario_id', $usuario_id);
$stmt->execute();
$agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClockYourWorkout - Visualizar Agendamentos</title>
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
                <h2>Meus Agendamentos</h2>
                <table>
                    <tr>
                        <th>Data</th>
                        <th>Hora</th>
                    </tr>
                    <?php foreach ($agendamentos as $agendamento): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($agendamento['data']); ?></td>
                            <td><?php echo htmlspecialchars($agendamento['hora']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <p><a href="agendamento.php">Agendar novo horário</a></p>
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
