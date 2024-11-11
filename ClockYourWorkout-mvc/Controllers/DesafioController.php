<?php
// controllers/DesafioController.php
require_once '../models/Desafio.php';
require_once '../database/conexao.php';

session_start();

class DesafioController {

    public function participar() {
        if (!isset($_SESSION['id'])) {
            header("Location: login.php");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['desafio_id'])) {
            $usuario_id = $_SESSION['id'];
            $desafio_id = $_POST['desafio_id'];

            // Criando a instância do model ParticipacaoDesafio
            $participacao = new Desafio($conexao);

            // Chamando o método para registrar a participação
            if ($participacao->participar($usuario_id, $desafio_id)) {
                echo "Você participou do desafio com sucesso!";
                header("Location: desafios.php");
            } else {
                echo "Erro ao participar do desafio.";
            }
        }
    }
}
?>
