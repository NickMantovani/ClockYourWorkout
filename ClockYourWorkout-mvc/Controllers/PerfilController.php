<?php
// controllers/PerfilController.php
require_once '../models/Usuario.php';
require_once '../database/conexao.php';

session_start();

class PerfilController {

    public function editarPerfil() {
        // Verificar se o usuário está logado
        if (!isset($_SESSION['id'])) {
            header("Location: login.php");
            exit();
        }

        $id = $_SESSION['id'];
        $mensagem = "";

        $usuarioModel = new Usuario($conexao);

        // Verificar se o formulário foi enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['atualizar'])) {
                // Processar os dados do formulário para atualizar
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $senha = $_POST['senha'];

                $mensagem = $usuarioModel->atualizarPerfil($id, $nome, $email, $senha);
            } elseif (isset($_POST['excluir'])) {
                // Processar a exclusão do perfil
                $excluir = $usuarioModel->excluirPerfil($id);
                if ($excluir) {
                    session_destroy();
                    header("Location: login.php");
                    exit();
                } else {
                    $mensagem = "Erro ao excluir perfil.";
                }
            }
        }

        // Buscar dados do usuário para preencher o formulário
        $usuario = $usuarioModel->buscarUsuario($id);

        if (!$usuario) {
            $mensagem = "Erro: Usuário não encontrado.";
        }

        // Carregar a view
        include '../views/editar_perfil.php';
    }
}
?>
