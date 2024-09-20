<?php
require_once 'conexao.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $grupo_muscular = $_POST['grupo_muscular'];
    $usuario_id = $_SESSION['id'];

    $sql = "INSERT INTO agendamentos (usuario_id, data, hora, grupo_muscular) VALUES (:usuario_id, :data, :hora, :grupo_muscular)";
    $stmt = $conexao->prepare($sql);

    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':data', $data);
    $stmt->bindParam(':hora', $hora);
    $stmt->bindParam(':grupo_muscular', $grupo_muscular);

    try {
        $stmt->execute();
        echo "Horário agendado com sucesso!";
        header("Location: meus_treinos.php");
    } catch (PDOException $e) {
        echo "Erro ao agendar horário: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClockYourWorkout - Agendar</title>
    <link rel="stylesheet" href="css/style.css">
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
                <h2>Agendar Horário</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label>Data:</label>
                    <input type="date" name="data" required><br><br>
                    <label>Hora:</label>
                    <input type="time" name="hora" required><br><br>
                    <label>Grupo Muscular:</label>
                    <select name="grupo_muscular" required>
                        <option value="">Selecione...</option>
                        <option value="Peito">Peito</option>
                        <option value="Costas">Costas</option>
                        <option value="Ombros">Ombros</option>
                        <option value="Braços">Braços</option>
                        <option value="Pernas">Pernas</option>
                        <option value="Abdômen">Abdômen</option>
                    </select><br><br>
                    <input type="submit" value="Agendar">
                </form>
                <p><a href="meus_treinos.php">Ver meus agendamentos</a></p>
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
