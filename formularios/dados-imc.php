<?php

include_once "../funcoes/funcoes.php";

$auxConectar = conectar();

//FUNÇÃO DE CLASSIFICAÇÃO DO GRAU DE OBESIDADE
$classeCss = "";
function classificarGrauObesidade(float $imc): array
{
    if ($imc < 18.5) {
        return[
            "texto" => "Abaixo do peso",
            "classeCss" => "alerta"
        ];
    } elseif ($imc >= 18.5 && $imc < 25) {
        return[
            "texto" => "Peso normal",
            "classeCss" => "normal"
        ];
    } elseif ($imc >= 25 && $imc < 30) {
        return[
            "texto" => "Sobrepeso",
            "classeCss" => "cuidado"
        ];
    } elseif ($imc >= 30 && $imc < 35) {
        return[
            "texto" => "Obesidade grau I",
            "classeCss" => "alerta"
        ];
    } elseif ($imc >= 35 && $imc < 40) {
        return[
            "texto" => "Obesidade grau II",
            "classeCss" => "alerta"
        ];
    } else {
        return[
            "texto" => "Obesidade grau III (mórbida)",
            "classeCss" => "alerta"
        ];
    }
}

//calculo do imc médio
function imcMedio(mysqli $conexao): void
{
    $sql = "SELECT peso, altura FROM pessoas";
    $resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

    $totalImc = 0;
    $quantidadePessoas = contParticipantes($conexao);

    while ($registro = mysqli_fetch_assoc($resultado)) {
        $imc = calcularImc($registro['peso'], $registro['altura']);
        $totalImc += $imc;
    }

    if ($quantidadePessoas > 0) {
        $imcMedio = round($totalImc / $quantidadePessoas, 2);
        echo "<p>O IMC médio dos participantes é: <strong>" . $imcMedio . "</strong></p>";
    } else {
        echo "<p>Nenhum participante encontrado para calcular o IMC médio.</p>";
    }
}


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
        //funcao p mostrar dados classificados
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

</body>

</html>