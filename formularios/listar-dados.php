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
    <title>Document</title>
    <link rel="stylesheet" href="../assets/estilo-forms.css">
</head>
<body>
    <main class="container-painel"> 

        <h2>Lista dos participantes</h2>
            <?php listarPessoas($auxConectar); ?>
        </table>

            
        <a href="painel-administrativo.html" class="btn-menu">Voltar ao Menu</a>
    </main>
</body>
</html>