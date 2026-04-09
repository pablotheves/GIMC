<?php


include_once "../funcoes/funcoes.php";

$auxConectar = conectar();

$sql = "SELECT * FROM pessoas";
$resultado = mysqli_query($auxConectar, $sql);
 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados Peso</title>
</head>
<body>
    <h2>Lista de dados do Peso</h2>
    <?php listarPesos($auxConectar); ?>

    <h2>Maior peso</h2>
    <?php maiorPeso($auxConectar); ?>

    <h2>Menor peso</h2>
    <?php menorPeso($auxConectar); ?>

    <h2>Média peso</h2>
    <?php pesoMedio($auxConectar); ?>

    <h2>Pessoas fora do peso</h2>
    <?php pessoasFora($auxConectar); ?>
</body>
</html>