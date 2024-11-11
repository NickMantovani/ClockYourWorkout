<?php
// models/MetaTreino.php

class MetaTreino {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function adicionarMeta($usuario_id, $meta_tipo, $valor_meta) {
        $sql = "INSERT INTO metas_treino (usuario_id, meta_tipo, valor_meta, data_criacao) 
                VALUES (:usuario_id, :meta_tipo, :valor_meta, NOW())";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':meta_tipo', $meta_tipo);
        $stmt->bindParam(':valor_meta', $valor_meta);

        try {
            $stmt->execute();
            return "Meta de treino registrada com sucesso!";
        } catch (PDOException $e) {
            return "Erro ao registrar meta de treino: " . $e->getMessage();
        }
    }

    public function excluirMeta($usuario_id, $delete_id) {
        $sql = "DELETE FROM metas_treino WHERE id = :delete_id AND usuario_id = :usuario_id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':delete_id', $delete_id);
        $stmt->bindParam(':usuario_id', $usuario_id);

        try {
            $stmt->execute();
            return "Meta de treino apagada com sucesso!";
        } catch (PDOException $e) {
            return "Erro ao apagar meta de treino: " . $e->getMessage();
        }
    }

    public function buscarMetas($usuario_id) {
        $sql = "SELECT * FROM metas_treino WHERE usuario_id = :usuario_id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
