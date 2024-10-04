<?php
session_start();
require_once 'conexao.php'; 

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['id'];

// Processa a meta de treino se o formulário for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['meta_tipo'], $_POST['valor_meta'])) {
    $meta_tipo = $_POST['meta_tipo'];
    $valor_meta = $_POST['valor_meta'];

    // Consulta SQL para inserir a meta de treino
    $sql = "INSERT INTO metas_treino (usuario_id, meta_tipo, valor_meta, data_criacao) VALUES (:usuario_id, :meta_tipo, :valor_meta, NOW())";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':meta_tipo', $meta_tipo);
    $stmt->bindParam(':valor_meta', $valor_meta);

    try {
        $stmt->execute();
        $mensagem = "Meta de treino registrada com sucesso!";
    } catch(PDOException $e) {
        $mensagem = "Erro ao registrar meta de treino: " . $e->getMessage();
    }
}

// Verifica se o pedido é para excluir uma meta
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Consulta SQL para deletar a meta de treino
    $sql = "DELETE FROM metas_treino WHERE id = :delete_id AND usuario_id = :usuario_id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':delete_id', $delete_id);
    $stmt->bindParam(':usuario_id', $usuario_id);

    try {
        $stmt->execute();
        $mensagem = "Meta de treino apagada com sucesso!";
    } catch(PDOException $e) {
        $mensagem = "Erro ao apagar meta de treino: " . $e->getMessage();
    }
}

// Consulta para exibir as metas do usuário
$sql = "SELECT * FROM metas_treino WHERE usuario_id = :usuario_id";
$stmt = $conexao->prepare($sql);
$stmt->bindParam(':usuario_id', $usuario_id);
$stmt->execute();
$metas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metas de Treino</title>
    <link rel="stylesheet" href="css/metas_treino.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <h1>Metas de Treino</h1>
        </div>
    </nav>

    <div class="container">
        <h2>Definir Nova Meta</h2>
        <?php if (!empty($mensagem)): ?>
            <p><?php echo htmlspecialchars($mensagem); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="meta_tipo">Tipo de Meta:</label>
            <select name="meta_tipo" id="meta_tipo" required>
                <option value="treinos_mensais">Treinos Mensais</option>
                <option value="calorias_mensais">Calorias Queimadas</option>
                <option value="tempo_treino">Tempo de Treino (em horas)</option>
            </select><br><br>

            <label for="valor_meta">Valor da Meta:</label>
            <input type="text" name="valor_meta" id="valor_meta" required><br><br>

            <input type="submit" value="Definir Meta">
        </form>

        <h2>Suas Metas de Treino</h2>
        <?php if (count($metas) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Tipo de Meta</th>
                        <th>Valor</th>
                        <th>Data de Criação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($metas as $meta): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($meta['meta_tipo']); ?></td>
                            <td><?php echo htmlspecialchars($meta['valor_meta']); ?></td>
                            <td><?php echo htmlspecialchars($meta['data_criacao']); ?></td>
                            <td>
                                <a href="?delete_id=<?php echo $meta['id']; ?>" onclick="return confirm('Tem certeza que deseja apagar esta meta?');">Apagar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Você ainda não definiu metas de treino.</p>
        <?php endif; ?>

        <!-- Botão para voltar ao perfil -->
        <a href="perfil.php" class="btn-voltar">Voltar ao Perfil</a>
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
