<?php
// controllers/AgendamentoController.php
require_once '../models/Agendamento.php';
require_once '../database/conexao.php';

session_start();

class AgendamentoController {

    public function agendar() {
        if (!isset($_SESSION['id'])) {
            header("Location: login.php");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $_POST['data'];
            $hora = $_POST['hora'];
            $grupo_muscular = $_POST['grupo_muscular'];
            $usuario_id = $_SESSION['id'];

            // Criando a instância do model Agendamento
            $agendamento = new Agendamento($conexao);

            // Chamando o método para agendar
            if ($agendamento->agendar($usuario_id, $data, $hora, $grupo_muscular)) {
                echo "Horário agendado com sucesso!";
                header("Location: meus_treinos.php");
            } else {
                echo "Erro ao agendar horário.";
            }
        }
    }
}
?>
