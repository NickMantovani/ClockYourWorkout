<?php

class Usuario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function cadastrar($nome, $email, $senha) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO cadastro (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha_hash);
        return $stmt->execute();
    }

    public function login($email, $senha) {
        $sql = "SELECT * FROM cadastro WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }
        return false;
    }


    public function buscarUsuario($id) {
        $sql = "SELECT * FROM cadastro WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarPerfil($id, $nome, $email, $senha) {
        $sql = "UPDATE cadastro SET nome = :nome, email = :email, senha = :senha WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            return "Perfil atualizado com sucesso!";
        } catch (PDOException $e) {
            return "Erro ao atualizar perfil: " . $e->getMessage();
        }
    }

    public function excluirPerfil($id) {
        $sql = "DELETE FROM cadastro WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Erro ao excluir perfil: " . $e->getMessage();
        }
} 
}