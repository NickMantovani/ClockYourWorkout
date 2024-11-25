<?php
// criar_desafio.php
require_once '../database/conexao.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];
    $usuario_id = $_SESSION['id'];

    $sql = "INSERT INTO desafios (nome, descricao, data_inicio, data_fim, usuario_id) VALUES (:nome, :descricao, :data_inicio, :data_fim, :usuario_id)";
    $stmt = $conexao->prepare($sql);

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':data_inicio', $data_inicio);
    $stmt->bindParam(':data_fim', $data_fim);
    $stmt->bindParam(':usuario_id', $usuario_id);

    try {
        $stmt->execute();
        echo "Desafio criado com sucesso!";
        header("Location: lista_desafios.php"); // Redirecionar para a lista de desafios
    } catch (PDOException $e) {
        echo "Erro ao criar desafio: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Criar Desafio</title>
    <link rel="stylesheet" href="../css/desafio.css">
</head>
<body>
    <div class="container">
        <h1>Criar Desafio</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label>Nome do Desafio:</label>
            <input type="text" name="nome" required><br><br>
            <label>Descrição:</label>
            <textarea name="descricao" required></textarea><br><br>
            <label>Data de Início:</label>
            <input type="date" name="data_inicio" required><br><br>
            <label>Data de Fim:</label>
            <input type="date" name="data_fim" required><br><br>
            <input type="submit" value="Criar Desafio">
        </form>
        <p><a href="lista_desafios.php">Ver todos os desafios</a></p>
        <a href="perfil.php" class="btn-voltar">Voltar ao Perfil</a>

    </div>
</body>
</html>
