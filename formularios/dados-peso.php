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
    
    <link rel="stylesheet" href="../assets/estilo-forms.css">
    <title>Dados Peso</title>
</head>

<body>
    <main class="container-dados">
        <h2>Lista de dados de peso dos participantes</h2>

        <h2>Maior peso</h2>
        <?php maiorPeso($auxConectar); ?>

        <h2>Menor peso</h2>
        <?php menorPeso($auxConectar); ?>

        <h2>Média peso</h2>
        <?php pesoMedio($auxConectar); ?>

        <h2>Pessoas fora do peso</h2>
        <?php pessoasFora($auxConectar); ?>
        
        <a href="painel-administrativo.html" class="btn-menu">Voltar ao Menu</a>
    </main>
</body>

</html>