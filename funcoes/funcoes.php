<?php

include "../banco_de_dados/funcoes_bd.php";


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


