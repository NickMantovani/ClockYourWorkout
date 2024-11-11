<?php
// models/RelatorioTreino.php

class RelatorioTreino {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function getGruposTreinos($usuario_id, $data_ultimo_ano) {
        $sql_grupos = "SELECT grupo_muscular, COUNT(*) AS total_treinos 
                       FROM agendamentos 
                       WHERE usuario_id = :usuario_id AND data >= :data_ultimo_ano 
                       GROUP BY grupo_muscular 
                       ORDER BY total_treinos DESC";
        $stmt_grupos = $this->conexao->prepare($sql_grupos);
        $stmt_grupos->bindParam(':usuario_id', $usuario_id);
        $stmt_grupos->bindParam(':data_ultimo_ano', $data_ultimo_ano);
        $stmt_grupos->execute();
        return $stmt_grupos->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTreinosPorMes($usuario_id, $data_ultimo_ano) {
        $sql_meses = "SELECT MONTH(data) AS mes, COUNT(*) AS total_treinos 
                      FROM agendamentos 
                      WHERE usuario_id = :usuario_id AND data >= :data_ultimo_ano 
                      GROUP BY mes 
                      ORDER BY mes DESC";
        $stmt_meses = $this->conexao->prepare($sql_meses);
        $stmt_meses->bindParam(':usuario_id', $usuario_id);
        $stmt_meses->bindParam(':data_ultimo_ano', $data_ultimo_ano);
        $stmt_meses->execute();
        return $stmt_meses->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
