<?php
session_start();
require_once 'conexao.php'; 

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Consulta SQL para obter informações do usuário
$sql = "SELECT * FROM cadastro WHERE id = :id";
$stmt = $conexao->prepare($sql);
$stmt->bindParam(':id', $_SESSION['id']);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Processa o upload da foto de perfil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto_perfil'])) {
    $foto = $_FILES['foto_perfil'];
    $diretorio = __DIR__ . '/uploads/';
    $caminho = $diretorio . basename($foto['name']);

    // Verificar se o diretório de upload existe, se não, criá-lo
    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0755, true);
    }

    // Verifica se o arquivo é uma imagem real ou uma imagem falsa
    $check = getimagesize($foto['tmp_name']);
    if ($check === false) {
        echo 'Arquivo não é uma imagem.';
    } else {
        // Verificar se o arquivo já existe
        if (file_exists($caminho)) {
            echo 'O arquivo já existe.';
        } else {
            // Verificar o tamanho do arquivo
            if ($foto['size'] > 500000) { // 500KB
                echo 'O arquivo é muito grande.';
            } else {
                // Permitir certos formatos de arquivo
                $imageFileType = strtolower(pathinfo($caminho, PATHINFO_EXTENSION));
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    echo 'Somente arquivos JPG, JPEG, PNG e GIF são permitidos.';
                } else {
                    // Mover o arquivo para o diretório de uploads
                    if (move_uploaded_file($foto['tmp_name'], $caminho)) {
                        // Atualizar o caminho da foto no banco de dados
                        $sql = "UPDATE cadastro SET foto_perfil = :foto_perfil WHERE id = :id";
                        $stmt = $conexao->prepare($sql);
                        $stmt->bindParam(':foto_perfil', $caminho);
                        $stmt->bindParam(':id', $_SESSION['id']);
                        $stmt->execute();
                        header("Location: perfil.php?success=true");
                        exit();
                    } else {
                        echo 'Erro ao mover o arquivo.';
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="perfil.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <h1>Perfil do Usuário</h1>
        </div>
    </nav>
    <div class="login-container">
        <div class="background">
            <h2>Bem-vindo, <?php echo htmlspecialchars($usuario['nome']); ?>!</h2>
            <p>Email: <?php echo htmlspecialchars($usuario['email']); ?></p>
            <?php if (!empty($usuario['foto_perfil'])): ?>
                <img src="<?php echo htmlspecialchars($usuario['foto_perfil']); ?>" alt="Foto de Perfil" class="foto-perfil">
            <?php else: ?>
                <p>Foto de Perfil não disponível.</p>
            <?php endif; ?>
            <!-- Formulário para upload da foto de perfil -->
            <form action="perfil.php" method="post" enctype="multipart/form-data">
                <label for="file">Escolha uma nova foto de perfil:</label>
                <input type="file" name="foto_perfil" id="file" accept="image/*" required>
                <button type="submit">Atualizar Foto</button>
            </form>
            <!-- Opções do perfil -->
            <ul>
                <li><a href="agendamento.php">Agendar Treino</a></li>
                <li><a href="dados-acad.php">Calculo-TMB</a></li>
                <li><a href="meus_treinos.php">Ver Meus Treinos Agendados</a></li>
                <li><a href="editar_perfil.php">Editar Perfil</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
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
