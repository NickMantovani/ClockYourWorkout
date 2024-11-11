<?php

require_once '../config.php';
require_once '../models/Usuario.php';

class CadastroController {
    private $usuarioModel;

    public function __construct($pdo) {
        $this->usuarioModel = new Usuario($pdo);
    }

    public function cadastro() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            // Verificando se os campos não estão vazios
            if (!empty($nome) && !empty($email) && !empty($senha)) {
                if ($this->usuarioModel->cadastrar($nome, $email, $senha)) {
                    header("Location: login.php");
                    exit();
                } else {
                    echo "Erro ao cadastrar o usuário.";
                }
            } else {
                echo "Todos os campos são obrigatórios.";
            }
        }
    }
}

class LoginController {
    private $usuarioModel;

    public function __construct($pdo) {
        $this->usuarioModel = new Usuario($pdo);
    }

    public function login() {
        $erro_login = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            if ($this->usuarioModel->login($email, $senha)) {
                // Redirecionar para a página principal ou dashboard após o login
                header("Location: dashboard.php");
                exit();
            } else {
                $erro_login = "Credenciais inválidas.";
            }
        }

        return $erro_login;
    }
}


// Criação da instância do controlador e execução do método
$controller = new CadastroController($pdo);
$controller->cadastro();