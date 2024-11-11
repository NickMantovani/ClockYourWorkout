<?php
// controllers/SuporteController.php
require_once '../models/Suporte.php';
require_once '../database/conexao.php';

session_start();

class SuporteController {

    public function criarSolicitacao() {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['id'])) {
            header("Location: login.php");
            exit();
        }

        // Inicializa o modelo de suporte
        $suporteModel = new Suporte($conexao);
        $mensagem = '';

        // Verifica se o formulário foi enviado
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $assunto = $_POST['assunto'];
            $mensagem = $_POST['mensagem'];

            // Cria a solicitação de suporte
            $sucesso = $suporteModel->criarSolicitacao($_SESSION['id'], $assunto, $mensagem);
            
            // Verifica se a solicitação foi criada com sucesso
            if ($sucesso) {
                header("Location: suporte_tecnico.php?sucesso=1");
                exit();
            } else {
                $mensagem = "Erro ao enviar a solicitação de suporte.";
            }
        }

        // Carrega a view do formulário
        include '../views/suporte_form.php';
    }
}
?>
