<?php

    include_once "../funcoes/funcoes.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/estilo-forms.css">
</head>
<body>
    <main class="container-painel"> 
        <h2>Lista dos participantes</h2>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>Peso</th>
                    <th>Altura</th>
                </tr>
            </thead>
        </table>
        <?php mostrarPessoas(conectar()); ?>

    </main>
</body>
</html>