<?php
// controllers/RelatorioTreinoController.php
require_once '../models/Estatistica.php';
require_once '../database/conexao.php';

session_start();

class RelatorioTreinoController {

    public function gerarRelatorio() {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['id'])) {
            header("Location: login.php");
            exit();
        }

        $usuario_id = $_SESSION['id'];
        $data_atual = date('Y-m-d');
        $data_ultimo_ano = date('Y-m-d', strtotime('-1 year'));

        // Cria uma instância do model RelatorioTreino
        $relatorio = new RelatorioTreino($conexao);

        // Busca os dados dos grupos musculares
        $grupos_treinos = $relatorio->getGruposTreinos($usuario_id, $data_ultimo_ano);

        // Busca os dados dos treinos por mês
        $treinos_por_mes = $relatorio->getTreinosPorMes($usuario_id, $data_ultimo_ano);

        // Passa os dados para a view
        include '../views/relatorio_treino.php';
    }
}
?>
