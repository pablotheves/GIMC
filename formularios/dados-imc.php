<?php

include_once "../funcoes/funcoes.php";

$auxConectar = conectar();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["containerPeso"]) && isset($_POST["containerAltura"])) {
        
        $PesoRecebido = $_POST["containerPeso"];
        $AlturaRecebida = $_POST["containerAltura"];

        $ImcCalculado = calcularImc($PesoRecebido, $AlturaRecebida);

        listarImcs($auxConectar);
    }
} else {
    echo "Por favor, preencha os campos de peso e altura.";
}

listarImcs($auxConectar);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados IMC</title>
</head>

<body>
    <form action="dados-imc.php" method="post">
        <label for="peso">Peso:</label>
        <input type="text" id="peso" name="containerPeso" required>
        <br>
        <label for="altura">Altura:</label>
        <input type="text" id="altura" name="containerAltura" required>
        <br>
        <button type="submit">Calcular</button>

    </form>

    <h1>IMC</h1>
    <p>O IMC calculado é: <?php echo $ImcCalculado; ?></p>
</body>

</html>