<?php
require_once 'conexao.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['id'];

// Atualize a consulta SQL para incluir a coluna grupo_muscular
$sql = "SELECT id, data, hora, grupo_muscular FROM agendamentos WHERE usuario_id = :usuario_id ORDER BY data, hora";
$stmt = $conexao->prepare($sql);
$stmt->bindParam(':usuario_id', $usuario_id);
$stmt->execute();
$agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    $sql_delete = "DELETE FROM agendamentos WHERE id = :id";
    $stmt_delete = $conexao->prepare($sql_delete);
    $stmt_delete->bindParam(':id', $delete_id);

    try {
        $stmt_delete->execute();
        header("Location: meus_treinos.php");
    } catch (PDOException $e) {
        echo "Erro ao cancelar horário: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClockYourWorkout - Visualizar Agendamentos</title>
    <link rel="stylesheet" href="meus-treinos.css">
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
                        <th>Grupo Muscular</th> <!-- Adicione o cabeçalho para Grupo Muscular -->
                        <th>Ações</th>
                    </tr>
                    <?php foreach ($agendamentos as $agendamento): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($agendamento['data']); ?></td>
                            <td><?php echo htmlspecialchars($agendamento['hora']); ?></td>
                            <td><?php echo htmlspecialchars($agendamento['grupo_muscular']); ?></td> <!-- Exiba o grupo muscular -->
                            <td>
                                <form method="post" action="meus_treinos.php" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?php echo $agendamento['id']; ?>">
                                    <input type="submit" value="Cancelar">
                                </form>
                                <form method="post" action="reagendar.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $agendamento['id']; ?>">
                                    <input type="submit" value="Reagendar">
                                </form>
                            </td>
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
