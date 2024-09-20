<?php
require_once 'conexao.php';
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['id'];

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['atualizar'])) {
        // Processar os dados do formulário
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        try {
            // Atualizar nome, email e senha
            $sql = "UPDATE cadastro SET nome = :nome, email = :email, senha = :senha WHERE id = :id";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha); 
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            echo "Perfil atualizado com sucesso!";
        } catch (PDOException $e) {
            echo "Erro ao atualizar perfil: " . $e->getMessage();
        }
    } elseif (isset($_POST['excluir'])) {
        // Processar a exclusão do perfil
        try {
            $sql = "DELETE FROM cadastro WHERE id = :id";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // Destruir a sessão e redirecionar para a página de login
            session_destroy();
            header("Location: login.php");
            exit();
        } catch (PDOException $e) {
            echo "Erro ao excluir perfil: " . $e->getMessage();
        }
    }
}

// Buscar os dados atuais do usuário para preencher o formulário
$sql_busca = "SELECT * FROM cadastro WHERE id = :id";
$stmt_busca = $conexao->prepare($sql_busca);
$stmt_busca->bindParam(':id', $id);
$stmt_busca->execute();
$usuario = $stmt_busca->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "Erro: Usuário não encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClockYourWorkout - Editar Perfil</title>
    <link rel="stylesheet" href="css/editar_perfil.css">
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
                <h2>Editar Perfil</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label>Nome de Usuário:</label>
                    <input type="text" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required><br><br>
                    <label>Email:</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required><br><br>
                    <label>Nova Senha (deixe em branco para manter a atual):</label>
                    <input type="password" name="senha"><br><br>
                    <input type="submit" name="atualizar" value="Atualizar">
                    <input type="submit" name="excluir" value="Excluir Perfil" onclick="return confirm('Tem certeza que deseja excluir seu perfil? Esta ação não pode ser desfeita.');">
                </form>
                <p><a href="perfil.php">Voltar para o perfil</a></p>
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
