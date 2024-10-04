<?php
// participar_desafio.php
require_once 'conexao.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['desafio_id'])) {
    $usuario_id = $_SESSION['id'];
    $desafio_id = $_POST['desafio_id'];
    $data_participacao = date('Y-m-d');

    $sql = "INSERT INTO participacoes_desafios (usuario_id, desafio_id, data_participacao) VALUES (:usuario_id, :desafio_id, :data_participacao)";
    $stmt = $conexao->prepare($sql);

    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':desafio_id', $desafio_id);
    $stmt->bindParam(':data_participacao', $data_participacao);

    try {
        $stmt->execute();
        echo "Você participou do desafio com sucesso!";
        header("Location: desafios.php");
    } catch (PDOException $e) {
        echo "Erro ao participar do desafio: " . $e->getMessage();
    }
}
?>