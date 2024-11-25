<?php
require_once '../database/conexao.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "SELECT data, hora FROM agendamentos WHERE id = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $agendamento = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nova_data']) && isset($_POST['nova_hora'])) {
        $nova_data = $_POST['nova_data'];
        $nova_hora = $_POST['nova_hora'];

        $sql_update = "UPDATE agendamentos SET data = :data, hora = :hora WHERE id = :id";
        $stmt_update = $conexao->prepare($sql_update);
        $stmt_update->bindParam(':data', $nova_data);
        $stmt_update->bindParam(':hora', $nova_hora);
        $stmt_update->bindParam(':id', $id);

        try {
            $stmt_update->execute();
            header("Location: meus_treinos.php");
        } catch (PDOException $e) {
            echo "Erro ao reagendar horário: " . $e->getMessage();
        }
    }
} else {
    header("Location: meus_treinos.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClockYourWorkout - Reagendar</title>
    <link rel="stylesheet" href="../css/style.css">
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
                <h2>Reagendar Horário</h2>
                <form method="post" action="reagendar.php">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <label>Nova Data:</label>
                    <input type="date" name="nova_data" value="<?php echo htmlspecialchars($agendamento['data']); ?>" required><br><br>
                    <label>Nova Hora:</label>
                    <input type="time" name="nova_hora" value="<?php echo htmlspecialchars($agendamento['hora']); ?>" required><br><br>
                    <input type="submit" value="Reagendar">
                </form>
                <p><a href="meus_treinos.php">Voltar aos meus agendamentos</a></p>
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
