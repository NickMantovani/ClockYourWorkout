<?php
// models/ParticipacaoDesafio.php

class ParticipacaoDesafio {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function participar($usuario_id, $desafio_id) {
        $data_participacao = date('Y-m-d');
        $sql = "INSERT INTO participacoes_desafios (usuario_id, desafio_id, data_participacao) 
                VALUES (:usuario_id, :desafio_id, :data_participacao)";
        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':desafio_id', $desafio_id);
        $stmt->bindParam(':data_participacao', $data_participacao);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
