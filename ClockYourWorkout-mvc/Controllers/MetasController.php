<?php
// controllers/MetaTreinoController.php
require_once '../models/MetaTreino.php';
require_once '../database/conexao.php';

session_start();

class MetaTreinoController {

    public function processarMeta() {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['id'])) {
            header("Location: login.php");
            exit();
        }

        $usuario_id = $_SESSION['id'];
        $mensagem = "";

        // Verifica se o formulário foi enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['meta_tipo'], $_POST['valor_meta'])) {
            $meta_tipo = $_POST['meta_tipo'];
            $valor_meta = $_POST['valor_meta'];

            // Instancia o model e processa a inserção da meta
            $metaTreino = new MetaTreino($conexao);
            $mensagem = $metaTreino->adicionarMeta($usuario_id, $meta_tipo, $valor_meta);
        }

        // Verifica se há solicitação para excluir uma meta
        if (isset($_GET['delete_id'])) {
            $delete_id = $_GET['delete_id'];
            $metaTreino = new MetaTreino($conexao);
            $mensagem = $metaTreino->excluirMeta($usuario_id, $delete_id);
        }

        // Busca as metas de treino do usuário
        $metaTreino = new MetaTreino($conexao);
        $metas = $metaTreino->buscarMetas($usuario_id);

        // Carrega a view passando os dados
        include '../views/metas_treino.php';
    }
}
?>
