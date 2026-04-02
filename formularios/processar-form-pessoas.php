<?php

$nomeRecebido = $_POST['containerNome'];
$SobrenomeRecebido = $_POST['containerSobrenome'];
$IdadeRecebido = $_POST['containerIdade'];
$PesoRecebido = $_POST['containerPeso'];
$AlturaRecebido = $_POST['containerAltura'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados da Pessoa</title>
    <link rel="stylesheet" href="../assets/estilo-forms.css">
</head>
<main class="container">

    <body class="form-grid">
        <h3>Dados da Pessoa</h3>
        <p><strong>Nome:</strong> <?php echo $nomeRecebido; ?></p>
        <p><strong>Sobrenome:</strong> <?php echo $SobrenomeRecebido; ?></p>
        <p><strong>Idade:</strong> <?php echo $IdadeRecebido; ?></p>
        <p><strong>Peso:</strong> <?php echo $PesoRecebido; ?></p>
        <p><strong>Altura:</strong> <?php echo $AlturaRecebido; ?></p>
    </body>

</main>


</html>