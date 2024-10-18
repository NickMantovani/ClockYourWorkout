<?php
session_start();
require_once '../database/conexao.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Verificar se o arquivo é uma imagem real ou uma imagem falsa
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        header("Location: index.php?error=invalid");
        $uploadOk = 0;
    }
}

// Verificar se o arquivo já existe
if (file_exists($target_file)) {
    header("Location: index.php?error=exists");
    $uploadOk = 0;
}

// Verificar o tamanho do arquivo
if ($_FILES["file"]["size"] > 500000) { // 500KB
    header("Location: index.php?error=size");
    $uploadOk = 0;
}

// Permitir certos formatos de arquivo
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    header("Location: index.php?error=format");
    $uploadOk = 0;
}

// Verificar se $uploadOk está definido como 0 por um erro
if ($uploadOk == 0) {
    header("Location: index.php?error=upload");
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        // Atualizar o caminho da foto no banco de dados
        $sql = "UPDATE usuarios SET foto_perfil = :foto_perfil WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':foto_perfil', $target_file);
        $stmt->bindParam(':id', $_SESSION['id']);
        $stmt->execute();
        
        header("Location: index.php?success=true");
    } else {
        header("Location: index.php?error=upload");
    }
}
?>
