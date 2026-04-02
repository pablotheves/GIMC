<?php

include "funcoes_bd.php";

$auxConectar = conectar();

mostrarPessoas($auxConectar);

//mysqli $conexao, string $nome, string $sobrenome, int $idade, double $peso, double $altura

$retornoInserir=inserirPessoa($auxConectar,"Tiago","Gonçalves",20,70,68);

if($retornoInserir){
    echo 'Pessoa inserida';
}
else{
    echo "não foi possivel inserir";
}

mostrarPessoas($auxConectar);

$excluirPessoa = excluirPessoa($auxConectar,1);

if($excluirPessoa){
    echo 'pessoa excluido';
}
else{
    echo "não foi possivel excluir";
}
mostrarPessoas($auxConectar);

    