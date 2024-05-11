
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Projeto Software</title>
  <link rel="stylesheet" href="inicio.css">
  <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
  <script defer src="script.js"></script>
</head>
<body>
<!-- NAV BAR -->
  <nav class="navbar">
    <div class="max-width">
      <ul class="menu">
       <li><a>ClockYourWorkout</a></li>
      </ul>
    </div>
  </nav>
  
  <!-- HOME SECTION -->
  <section class="home" id="home">
    <div class="max-width">
      <div class="home-content">
        <div class="text-1">Olá, vamos agendar</div>
        <div class="text-2"><span>Hora</span><span>rios </span>?</div>
        <div class="text-3"><span class="typing"></span></div>
        <a href="cadastro.php">Sign Up</a>
        <a href="login.php">Sign In</a>
      </div>
    </div>
  </section>

  <!-- PROJECT SECTION -->
  <section class="projetos" id="projetos">
    <div class="max-width">
      <h2 class="title">Teste Agendamento:</h2>
    </div>
  <div class="conhecimentos">
  <h1>Sistema de Agendamento de Horários</h1>

<?php
// Função para remover um item específico de um array e reindexar o array
function removeItem($array, $item) {
    $index = array_search($item, $array);
    if ($index !== false) {
        array_splice($array, $index, 1);
    }
    return $array;
}

// Verifica se o formulário foi enviado para agendar ou excluir horário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o botão de agendamento foi clicado
    if (isset($_POST["agendar"]) && !empty($_POST["agendar"])) {
        // Verifica se o horário foi selecionado
        if (isset($_POST["horario"]) && !empty($_POST["horario"])) {
            // Adiciona o horário ao arquivo de agendamento
            $file = "agendamento.txt";
            $horario = $_POST["horario"] . PHP_EOL;
            file_put_contents($file, $horario, FILE_APPEND | LOCK_EX);
            echo "<p>Horário agendado com sucesso para: " . $_POST["horario"] . "</p>";
        } else {
            echo "<p>Por favor, selecione um horário válido.</p>";
        }
    }
    // Verifica se o botão de exclusão foi clicado
    elseif (isset($_POST["excluir"]) && !empty($_POST["excluir"])) {
        // Verifica se o horário a ser excluído foi selecionado
        if (isset($_POST["horario_excluir"]) && !empty($_POST["horario_excluir"])) {
            $file = "agendamento.txt";
            $horario_excluir = $_POST["horario_excluir"];
            // Carrega os agendamentos do arquivo
            $agendamentos = file($file);
            // Remove o horário selecionado da lista de agendamentos
            $agendamentos = removeItem($agendamentos, $horario_excluir . PHP_EOL);
            // Escreve os agendamentos restantes no arquivo
            file_put_contents($file, implode("", $agendamentos));
            echo "<p>Horário excluído com sucesso: " . $horario_excluir . "</p>";
        } else {
            echo "<p>Por favor, selecione um horário a ser excluído.</p>";
        }
    }
}
?>

<h2>Agendar Horário</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="horario">Selecione um horário:</label>
    <select name="horario" id="horario">
        <option value="">Selecione</option>
        <option value="09:00">09:00</option>
        <option value="10:00">10:00</option>
        <option value="11:00">11:00</option>
        <option value="12:00">12:00</option>
        <option value="13:00">13:00</option>
        <option value="14:00">14:00</option>
        <option value="15:00">15:00</option>
        <option value="16:00">16:00</option>
        <option value="17:00">17:00</option>
    </select>
    <input type="submit" name="agendar" value="Agendar">
</form>

<h2>Excluir Horário</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="horario_excluir">Selecione um horário a ser excluído:</label>
    <?php
    // Carrega os agendamentos do arquivo para exibir como opções de exclusão
    $file = "agendamento.txt";
    $agendamentos = file($file);
    ?>
    <select name="horario_excluir" id="horario_excluir">
        <option value="">Selecione</option>
        <?php
        foreach ($agendamentos as $agendamento) {
            echo "<option value='" . htmlspecialchars(trim($agendamento)) . "'>" . htmlspecialchars(trim($agendamento)) . "</option>";
        }
        ?>
    </select>
    <input type="submit" name="excluir" value="Excluir">
</form>

<h2>Agendamentos</h2>
<?php
// Mostra os agendamentos do arquivo
if (!empty($agendamentos)) {
    echo "<ul>";
    foreach ($agendamentos as $agendamento) {
        echo "<li>" . htmlspecialchars($agendamento) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Nenhum agendamento realizado.</p>";
}
?>
  </div>
</section>  
  <!-- FOOTER SECTION -->
  <footer>
  <span>Criado por 
          <a>@Gabriel Alexandre</a>
          <a>@Nicolas Mantovani</a>
          <a>@Raphael Dantas</a>
          <a>@Victor Nunes</a>
        </span>
  </footer>
</body>
</html>