<?php

function conectar(): mysqli
{
    // Informação da Conexão
    $localServidor = "localhost";
    $usuario = "root";
    $senha = "";
    $nomeBaseDados = "imc";

    $conexao = mysqli_connect($localServidor, $usuario, $senha, $nomeBaseDados);

    // Verificando a Conexao com a Base de Dados.
    if (!$conexao) {
        die("Conexão falhou: " . mysqli_connect_error());
    }

    echo "Conectado com sucesso!!!";
    return $conexao;
}

function mostrarPessoas(mysqli $conexao): void
{

    $comandoSQL = "SELECT * from pessoas";
    $retornoBanco = mysqli_query($conexao, $comandoSQL) or die(mysqli_error($conexao));

    if (mysqli_num_rows($retornoBanco) > 0) {
        echo "ID pessoa - Nome - Sobrenome - Idade - Peso - Altura<br>";

        while ($registro = mysqli_fetch_array($retornoBanco)) {
            echo $registro['idpessoa'] .
                " " . $registro['nome'] .
                " " . $registro['sobrenome'] .
                " " . $registro['idade'] .
                " " . $registro['peso'] .
                " " . $registro['altura'] . "<br>";
        }
    } else {
        echo "Nenhum resultado.";
    }

    return;
}

function inserirPessoa(mysqli $conexao, string $nome, string $sobrenome, int $idade, float $peso, float $altura): bool
{
    $comandoSQL = "insert into pessoas (nome,sobrenome,idade,peso,altura) values ('$nome','$sobrenome',$idade,$peso,$altura)";
    $retornoBanco = mysqli_query($conexao, $comandoSQL) or die(mysqli_error($conexao));
    return $retornoBanco;
}

function excluirPessoa(mysqli $conexao, int $idpessoa): bool
{
    $comandoSQL = "delete from pessoas where idpessoa = '$idpessoa'";
    $retornoBanco = mysqli_query($conexao, $comandoSQL) or die(mysqli_error($conexao));
    return $retornoBanco;
}
