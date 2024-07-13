<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia</title>
    <link rel="stylesheet" href="geto.css">
</head>
<body>
    <form id="exerciseForm" method="POST" action="submit.php">
        <label for="exercise">Escolha uma parte do corpo para treinar:</label>
        <select name="exercise" id="exercise">
            <option value="peito">Peito</option>
            <option value="costas">Costas</option>
            <option value="perna">Perna</option>
            <option value="braco">Braço</option>
        </select>
        <button type="submit">Enviar</button>
    </form>

    <div id="results">
        <!-- Os resultados serão exibidos aqui -->
    </div>

    <script src="gojo.js"></script>
</body>


</html>