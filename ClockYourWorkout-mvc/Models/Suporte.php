<?php
// models/Suporte.php

class Suporte {

    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    // Método para inserir um novo suporte
    public function criarSolicitacao($id_usuario, $assunto, $mensagem) {
        $sql = "INSERT INTO suporte (id_usuario, assunto, mensagem) VALUES (:id_usuario, :assunto, :mensagem)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':assunto', $assunto);
        $stmt->bindParam(':mensagem', $mensagem);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Erro ao enviar a solicitação de suporte: " . $e->getMessage();
        }
    }
}
?>
