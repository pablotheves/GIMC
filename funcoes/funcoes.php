<?php

//banco de dados
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




function listarPessoas(mysqli $conexao): void
{

    if (isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
        $id = $_GET['id'];
        excluirPessoa($conexao, $id);
    }


    $comandoSQL = "SELECT * from pessoas";
    $retornoBanco = mysqli_query($conexao, $comandoSQL) or die(mysqli_error($conexao));

    if (mysqli_num_rows($retornoBanco) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>Peso</th>
                    <th>Altura</th>
                    <th>Excluir</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php

                while ($registro = mysqli_fetch_array($retornoBanco)):
                    ?>
                    <tr>
                        <td><?= $registro['nome'] ?></td>
                        <td><?= $registro['sobrenome'] ?></td>
                        <td><?= $registro['peso'] ?> kg</td>
                        <td><?= $registro['altura'] ?> m</td>
                        <td>
                            <a href="?acao=excluir&id=<?= $registro['idpessoa'] ?>"]
                            onclick="return confirm('Tem certeza que deseja excluir esta pessoa?')">
                            Excluir </a>
                        </td>
                        <td>
                            <a href="alterar-dados.php?id=<?= $registro['idpessoa'] ?>">
                                Editar
                            </a>
                        </td>
                    </tr>
                    <?php

                endwhile; ?>
                
            </tbody>
        </table>
        
    <?php else: ?>
        <p>Nenhum resultado encontrado.</p>
    <?php endif;
}






//Dados IMC

//Qual o IMC de cada participante?

function calcularImc(float $peso, float $altura): float
{
    return round($peso / ($altura * $altura), 2);
}

function contParticipantes(mysqli $conexao): int
{
    $sql = "SELECT COUNT(*) AS total FROM pessoas";
    $resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
    $registro = mysqli_fetch_assoc($resultado);
    return $registro['total'];
}


function listarImcs(mysqli $conexao): void
{

    $comandoSQL = "SELECT * from pessoas";
    $retornoBanco = mysqli_query($conexao, $comandoSQL) or die(mysqli_error($conexao));

    if (mysqli_num_rows($retornoBanco) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>Peso</th>
                    <th>Altura</th>
                    <th>IMC</th>
                </tr>
            </thead>
            <tbody>
                //comentario aqui
                <?php while ($registro = mysqli_fetch_array($retornoBanco)):
                    // Pequeno bloco PHP apenas para o cálculo
                    $imc = calcularImc($registro['peso'], $registro['altura']);
                    ?>

                    <tr>
                        <td><?= $registro['nome'] ?></td>
                        <td><?= $registro['sobrenome'] ?></td>
                        <td><?= $registro['peso'] ?> kg</td>
                        <td><?= $registro['altura'] ?> m</td>
                        <td><?= $imc ?></td>
                    </tr>

                <?php endwhile; ?>
            </tbody>
        </table>



    <?php else: ?>
        <p>Nenhum resultado encontrado.</p>
    <?php endif;
}


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

$classeCss = "";
function classificarGrauObesidade(float $imc): array
{
    if ($imc < 18.5) {
        return [
            "texto" => "Abaixo do peso",
            "classeCss" => "alerta"
        ];
    } elseif ($imc >= 18.5 && $imc < 25) {
        return [
            "texto" => "Peso normal",
            "classeCss" => "normal"
        ];
    } elseif ($imc >= 25 && $imc < 30) {
        return [
            "texto" => "Sobrepeso",
            "classeCss" => "cuidado"
        ];
    } elseif ($imc >= 30 && $imc < 35) {
        return [
            "texto" => "Obesidade grau I",
            "classeCss" => "alerta"
        ];
    } elseif ($imc >= 35 && $imc < 40) {
        return [
            "texto" => "Obesidade grau II",
            "classeCss" => "alerta"
        ];
    } else {
        return [
            "texto" => "Obesidade grau III (mórbida)",
            "classeCss" => "alerta"
        ];
    }
}

?>