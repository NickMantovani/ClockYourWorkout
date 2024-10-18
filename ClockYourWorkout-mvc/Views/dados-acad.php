<?php
session_start();
require_once '../database/conexao.php';

$tmb = null; // Variável para armazenar o resultado da TMB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $idade = $_POST['idade'];
    $sexo = $_POST['sexo'];
    $atividade = $_POST['atividade'];

    // Fórmulas de TMB de Harris-Benedict
    if ($sexo == 'masculino') {
        $tmb = 88.362 + (13.397 * $peso) + (4.799 * $altura) - (5.677 * $idade);
    } else {
        $tmb = 447.593 + (9.247 * $peso) + (3.098 * $altura) - (4.330 * $idade);
    }

    // Ajuste de acordo com o nível de atividade
    switch ($atividade) {
        case 'sedentario':
            $tmb *= 1.2;
            break;
        case 'leve':
            $tmb *= 1.375;
            break;
        case 'moderado':
            $tmb *= 1.55;
            break;
        case 'intenso':
            $tmb *= 1.725;
            break;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de TMB</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .navbar, .footer {
            background-color: #333;
            color: white;
            padding: 1em;
            text-align: center;
        }

        .background {
            background-color: #f4f4f4;
            padding: 2em;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .form-box, .result-box {
            background: white;
            padding: 1em;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 0.5em;
        }

        input, select {
            width: 100%;
            padding: 0.5em;
            margin-bottom: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            padding: 1em;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <h1>Calculadora de TMB</h1>
        </div>
    </nav>
    <div class="background">
        <div class="form-container">
            <?php if ($tmb !== null): ?>
                <div class="result-box">
                    <h2>Resultado da TMB</h2>
                    <p>Sua Taxa Metabólica Basal (TMB) ajustada é: <strong><?php echo number_format($tmb, 2); ?> calorias/dia</strong></p>
                    <p><a href="#form">Voltar ao Formulário</a></p>
                </div>
            <?php else: ?>
                <div class="form-box" id="form">
                    <h2>Calcular Taxa Metabólica Basal (TMB)</h2>
                    <form method="post" action="">
                        <label>Peso (kg):</label>
                        <input type="number" name="peso" step="0.1" required><br><br>

                        <label>Altura (cm):</label>
                        <input type="number" name="altura" required><br><br>

                        <label>Idade (anos):</label>
                        <input type="number" name="idade" required><br><br>

                        <label>Sexo:</label>
                        <select name="sexo" required>
                            <option value="">Selecione...</option>
                            <option value="masculino">Masculino</option>
                            <option value="feminino">Feminino</option>
                        </select><br><br>

                        <label>Nível de Atividade:</label>
                        <select name="atividade" required>
                            <option value="sedentario">Sedentário</option>
                            <option value="leve">Leve</option>
                            <option value="moderado">Moderado</option>
                            <option value="intenso">Intenso</option>
                        </select><br><br>

                        <input type="submit" value="Calcular TMB">
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="footer">
        <span>Criado por 
          <a>@Seu Nome</a>
        </span>
    </footer>
</body>
</html>
