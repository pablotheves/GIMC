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
}?>


