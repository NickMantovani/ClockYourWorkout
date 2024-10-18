<?php
// Inicia a sessão
session_start();

// Destrói todas as variáveis de sessão
session_destroy();

// Redireciona o usuário de volta para a página de login (ou qualquer outra página desejada)
header("Location: login.php");
exit();
?>
