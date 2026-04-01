<?php

include "funcoes_bd.php";

$auxConectar = conectar();

mostrarPessoas($auxConectar);

mysqli $conexao, string $nome, string $sobrenome, int $idade, double $peso, double $altura

$retornoInserir=inserirPessoa($auxConectar,"Tiago","Gonçalves",20,70.0,1.68);

if($retornoInserir){
    echo 'carro inserido';
}
else{
    echo "não foi possivel inserir";
}

mostrarPessoas($auxConectar);

$excluirPessoa = $excluirPessoa($auxConectar,1);

if($excluirCarro){
    echo 'carro excluido';
}
else{
    echo "não foi possivel excluir";
}
mostrarPessoas($auxConectar);

