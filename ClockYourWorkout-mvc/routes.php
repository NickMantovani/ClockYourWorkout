<?php
// routes.php

session_start();

// Função para verificar autenticação
function verificar_autenticacao() {
    if (!isset($_SESSION['id'])) {
        header("Location: Views/login.php");
        exit();
    }
}

// Verificando a rota passada pela URL
if (isset($_GET['route'])) {
    $route = $_GET['route'];
} else {
    $route = 'home'; // Página inicial padrão
}

switch ($route) {
    case 'home':
        include 'index.php';
        break;

    case 'login':
        include 'Views/login.php';
        break;

    case 'logout':
        include 'Controllers/logout.php';
        break;

    case 'perfil':
        verificar_autenticacao();
        include 'Views/perfil.php';
        break;

    case 'editar_perfil':
        verificar_autenticacao();
        include 'Controllers/editar_perfil.php';
        break;

    case 'agendamento':
        verificar_autenticacao();
        include 'Views/agendamento.php';
        break;

    case 'meus_treinos':
        verificar_autenticacao();
        include 'Views/meus_treinos.php';
        break;

    case 'metas_treino':
        verificar_autenticacao();
        include 'Controllers/metas_treino.php';
        break;

    case 'reagendar':
        verificar_autenticacao();
        include 'Controllers/reagendar.php';
        break;

    case 'feedback':
        verificar_autenticacao();
        include 'Views/feedback.php';
        break;

    case 'suporte_tecnico':
        verificar_autenticacao();
        include 'Models/suporte_tecnico.php';
        break;

    case 'estatisticas':
        verificar_autenticacao();
        include 'Models/estatisticas.php';
        break;

    default:
        include 'index.php'; // Página padrão caso a rota não seja encontrada
        break;
}
?>
