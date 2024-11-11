<?php
// models/Agendamento.php

class Agendamento {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function agendar($usuario_id, $data, $hora, $grupo_muscular) {
        $sql = "INSERT INTO agendamentos (usuario_id, data, hora, grupo_muscular) VALUES (:usuario_id, :data, :hora, :grupo_muscular)";
        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':grupo_muscular', $grupo_muscular);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
