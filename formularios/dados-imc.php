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
    <title>Dados IMC</title>
    <link rel="stylesheet" href="../assets/estilo-forms.css">

</head>


<body>

    <h2>Lista de IMCs dos participantes</h2>
    <?php listarImcs($auxConectar); ?>

    <h2> Classificação no grau de obesidade</h2>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Classificação</th>
            </tr>
        </thead>
        <?php
        while ($registro = mysqli_fetch_assoc($resultado)) {
            $valorImc = calcularImc($registro['peso'], $registro['altura']);

            $dadosClassificacao = classificarGrauObesidade($valorImc);
            $grau = $dadosClassificacao["texto"];
            $classeCss = $dadosClassificacao["classeCss"];

            echo "<tr>";
            echo "<td>" . $registro['nome'] . " " . $registro['sobrenome'] . "</td>";
            echo "<td class='" . $classeCss . "'>" . $grau . "</td>";
            echo "</tr>";
        }
        ?>

    </table>
    <h2>IMC MÉDIO</h2>
    <?php imcMedio($auxConectar); ?>

    
        <a href="painel-administrativo.html" class="btn-menu">Voltar ao Menu</a>

</body>

</html>