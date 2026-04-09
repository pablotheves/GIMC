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
    <title>Dados Idade</title>
    <link rel="stylesheet" href="../assets/estilo-forms.css">
</head>
<body>
    <h2>Lista de dados das idades</h2>
    <?php listarIdades($auxConectar); ?>

    <h2>Maior idade</h2>
    <?php maiorIdade($auxConectar); ?>

    <h2>Pessoa mais velha</h2>
    <?php pessoaMaisVelha($auxConectar); ?>

    <h2>Menor idade</h2>
    <?php menorIdade($auxConectar); ?>

    <h2>Nome e altura da pessoa mais nova</h2>
    <?php nomeEAlturaPessoaMaisNova($auxConectar); ?>

    <h2>Idade média do grupo</h2>
    <?php idadeMedia($auxConectar); ?>

    <h2>Pessoas acima da idade média</h2>
    <?php acimaIdadeMedia($auxConectar); ?>
    
</body>
</html>