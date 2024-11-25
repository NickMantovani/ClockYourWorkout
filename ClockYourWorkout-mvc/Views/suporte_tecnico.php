<?php
session_start();
require_once '../database/conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $assunto = $_POST['assunto'];
    $mensagem = $_POST['mensagem'];
    
    // Insere os dados no banco de dados (exemplo básico)
    $sql = "INSERT INTO suporte (id_usuario, assunto, mensagem) VALUES (:id_usuario, :assunto, :mensagem)";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id_usuario', $_SESSION['id']);
    $stmt->bindParam(':assunto', $assunto);
    $stmt->bindParam(':mensagem', $mensagem);
    $stmt->execute();

    // Redireciona o usuário após o envio
    header("Location: suporte_tecnico.php?sucesso=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suporte Técnico</title>
    <link rel="stylesheet" href="../css/perfil.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <h1>Suporte Técnico</h1>
        </div>
    </nav>
    <div class="login-container">
        <div class="background">
            <?php if (isset($_GET['sucesso'])): ?>
                <p>Sua mensagem foi enviada com sucesso!</p>
            <?php endif; ?>
            
            <form action="suporte_tecnico.php" method="POST">
                <label for="assunto">Assunto:</label>
                <input type="text" id="assunto" name="assunto" required>
                
                <label for="mensagem">Mensagem:</label>
                <textarea id="mensagem" name="mensagem" required></textarea>
                
                <button type="submit">Enviar</button>
            </form>
            <a href="perfil.php" class="btn-voltar">Voltar ao Perfil</a>

        </div>
    </div>
</body>
</html>
