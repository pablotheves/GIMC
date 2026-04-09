<?php

include "../funcoes/funcoes.php";

$nomeRecebido = $_POST['containerNome'];
$SobrenomeRecebido = $_POST['containerSobrenome'];
$IdadeRecebido = $_POST['containerIdade'];
$PesoRecebido = $_POST['containerPeso'];
$AlturaRecebido = $_POST['containerAltura'];

$auxConectar = conectar();

$retornoInserir=inserirPessoa($auxConectar,$nomeRecebido,$SobrenomeRecebido,$IdadeRecebido,$PesoRecebido,$AlturaRecebido);
if($retornoInserir){
    echo 'Pessoa inserida';
}
else{
    echo "Não foi possivel inserir";
}





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
        <h3>Pessoa registrada com sucesso!</h3>
        <a href="formulario-inserir-pessoas.html" class="btn-registrar">Voltar</a>
        
    </body>

</main>


</html>