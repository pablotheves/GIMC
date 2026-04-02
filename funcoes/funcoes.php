<?php

include "../banco_de_dados/funcoes_bd.php";


//Dados IMC

//Qual o IMC de cada participante?

function calcularImc(float $peso, float $altura): float
{
    return round($peso / ($altura * $altura), 2);
}

function listarImcs(mysqli $conexao): void
{

    $comandoSQL = "SELECT * from pessoas";
    $retornoBanco = mysqli_query($conexao, $comandoSQL) or die(mysqli_error($conexao));

    if (mysqli_num_rows($retornoBanco) > 0) {
        echo "Nome - Sobrenome - IMC<br>";

        while ($registro = mysqli_fetch_array($retornoBanco)) {
            $imc = calcularImc($registro['peso'], $registro['altura']);
            echo " " . $registro['nome'] .
                " " . $registro['sobrenome'] .
                " " . $imc . "<br>";
        }
    } else {
        echo "Nenhum resultado.";
    }

    return;
}
