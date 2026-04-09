<?php

include "../funcoes/funcoes.php";

$id = $_POST['id'] ?? null;

$nomeRecebido = $_POST['containerNome'];
$SobrenomeRecebido = $_POST['containerSobrenome'];
$IdadeRecebido = $_POST['containerIdade'];
$PesoRecebido = $_POST['containerPeso'];
$AlturaRecebido = $_POST['containerAltura'];

$auxConectar = conectar();


if ($id) {
    // UPDATE
    $sql = "UPDATE pessoas SET 
        nome = '$nomeRecebido',
        sobrenome = '$SobrenomeRecebido',
        idade = $IdadeRecebido,
        peso = $PesoRecebido,
        altura = $AlturaRecebido
    WHERE idpessoa = $id";

    $retorno = mysqli_query($auxConectar, $sql);

    if ($retorno) {
        echo 'Pessoa atualizada com sucesso';

        // LOG 
    $mensagem = "ATUALIZOU -> Nome: $nome | Sobrenome: $sobrenome | Idade: $idade | Peso: $peso | Altura: $altura | "
                . date("d/m/Y H:i:s") . "\n";

    file_put_contents("../logs/log.txt", $mensagem, FILE_APPEND);

    
    } else {
        echo 'Erro ao atualizar';
    }

} else {
    // INSERT
    $retorno = inserirPessoa(
        $auxConectar,
        $nomeRecebido,
        $SobrenomeRecebido,
        $IdadeRecebido,
        $PesoRecebido,
        $AlturaRecebido
    );

    if ($retorno) {
        echo 'Pessoa inserida';
    } else {
        echo "Não foi possível inserir";
    }
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