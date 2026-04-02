<?php

include "../banco_de_dados/funcoes_bd.php";


//Dados IMC

//Qual o IMC de cada participante?


function listarImcs(mysqli $conexao): void
{

    $comandoSQL = "SELECT * from pessoas";
    $retornoBanco = mysqli_query($conexao, $comandoSQL) or die(mysqli_error($conexao));

    if (mysqli_num_rows($retornoBanco) > 0) {
        echo "Nome - Sobrenome - IMC<br>";

        while ($registro = mysqli_fetch_array($retornoBanco)) {
            echo $registro['idpessoa'] .
                " " . $registro['nome'] .
                " " . $registro['sobrenome'] .
                " " . $registro['peso/altura'] ."<br>";
        }
    } else {
        echo "Nenhum resultado.";
    }

    return;
}
