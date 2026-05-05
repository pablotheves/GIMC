<?php

//banco de dados
function conectar(): PDO
{
    $localServidor = "localhost";
    $usuario = "root";
    $senha = "";
    $nomeBaseDados = "imc";

    try {
        $conexao = new PDO("mysql:host=$localServidor;dbname=$nomeBaseDados", $usuario, $senha);
        
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conexao;
    } catch (PDOException $e) {
        die("Conexão falhou: " . $e->getMessage());
    }
}

function mostrarPessoas(PDO $conexao): void
{

    $comandoSQL = "SELECT * from pessoas";
    $stmt = $conexao->prepare($comandoSQL); 
    $stmt->execute(); 
    $lista = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    if (count($lista) > 0) {
        echo "ID pessoa - Nome - Sobrenome - Idade - Peso - Altura<br>";

        foreach ($lista as $registro) {
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
    $stmt = null;
    return;
}

function inserirPessoa(PDO $conexao, string $nome, string $sobrenome, int $idade, float $peso, float $altura): bool
{
    $comandoSQL = "INSERT INTO pessoas (nome, sobrenome, idade, peso, altura) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conexao->prepare($comandoSQL);

    
    if (!$stmt) {
        return false; 
    }

    $stmt->bindParam(1, $nome, PDO::PARAM_STR);
    $stmt->bindParam(2, $sobrenome, PDO::PARAM_STR);
    $stmt->bindParam(3, $idade, PDO::PARAM_INT);
    $stmt->bindParam(4, $peso, PDO::PARAM_STR);
    $stmt->bindParam(5, $altura, PDO::PARAM_STR);
    
    $executou = $stmt->execute();

    if ($executou) {
        $dataHora = date("d/m/Y H:i:s");
        $mensagem = "INSERIU -> Nome: $nome | Sobrenome: $sobrenome | Idade: $idade | Peso: $peso | Altura: $altura | $dataHora\n";
        
        @file_put_contents("../logs/log.txt", $mensagem, FILE_APPEND);
    }

    $stmt = null;

    return $executou; 


}

function excluirPessoa(PDO $conexao, int $idpessoa): bool
{
    $sqlBusca = "SELECT nome, sobrenome, idade, peso, altura FROM pessoas WHERE idpessoa = ?";
    $stmtBusca = $conexao->prepare($sqlBusca);
    $stmtBusca->bindParam(1, $idpessoa, PDO::PARAM_INT);
    $stmtBusca->execute();
    
    $dados = $stmtBusca->fetch(PDO::FETCH_ASSOC);

    if (!$dados) {
        return false; // Pessoa não encontrada
    }

    $sqlDelete = "DELETE FROM pessoas WHERE idpessoa = ?";
    $stmtDelete = $conexao->prepare($sqlDelete);
    $stmtDelete->bindParam(1, $idpessoa, PDO::PARAM_INT);
    
    if ($stmtDelete->execute()) {
        if ($stmtDelete->rowCount() > 0) {
            
            // 3. Gravar Log[cite: 2]
            $mensagem = "EXCLUIU -> Nome: {$dados['nome']} | Sobrenome: {$dados['sobrenome']} | " .
                        "Idade: {$dados['idade']} | Peso: {$dados['peso']} | Altura: {$dados['altura']} | " .
                        date("d/m/Y H:i:s") . "\n";

            file_put_contents("../logs/log.txt", $mensagem, FILE_APPEND);
            
            // Fechar os statements
            $stmtBusca = null;
            $stmtDelete = null;
            
            return true;
        }
    }

    $stmtBusca = null;
    $stmtDelete = null;
    return false;
}


function listarPessoas(PDO $conexao): void
{

    if (isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
        $id = $_GET['id'];
        excluirPessoa($conexao, $id);
    }

    $comandoSQL = "SELECT * FROM pessoas";
    $stmt = $conexao->prepare($comandoSQL);
    $stmt->execute();

    $listaPessoas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($listaPessoas) > 0): ?>
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

                foreach($listaPessoas as $registro):
                    ?>
                    <tr>
                        <td><?= $registro['nome'] ?></td>
                        <td><?= $registro['sobrenome'] ?></td>
                        <td><?= $registro['peso'] ?> kg</td>
                        <td><?= $registro['altura'] ?> m</td>
                        <td>
                            <a href="?acao=excluir&id=<?= $registro['idpessoa'] ?>" ]
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
                endforeach; ?>

            </tbody>
        </table>

    <?php else: ?>
        <p>Nenhum resultado encontrado.</p>
    <?php endif;
    $stmt = null;
}

//funcoes imc
function calcularImc(float $peso, float $altura): float
{
    return round($peso / ($altura * $altura), 2);
}

function contParticipantes(PDO $conexao): int
{
    $sql = "SELECT COUNT(*) AS total FROM pessoas";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);
    return $registro['total'];
}

function listarImcs(PDO $conexao): void
{

    $comandoSQL = "SELECT * FROM pessoas";
    $stmt = $conexao->prepare($comandoSQL);
    $stmt->execute();
    $listaPessoas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($listaPessoas) > 0): ?>
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
                <?php foreach ($listaPessoas as $registro): ?>
                    <?php $imc = calcularImc($registro['peso'], $registro['altura']); ?>
                    <tr>
                        <td><?= $registro['nome'] ?></td>
                        <td><?= $registro['sobrenome'] ?></td>
                        <td><?= $registro['peso'] ?> kg</td>
                        <td><?= $registro['altura'] ?> m</td>
                        <td><?= $imc ?></td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>



    <?php else: ?>
        <p>Nenhum resultado encontrado.</p>
    <?php endif;
}



function imcMedio(PDO $conexao): void
{
    $sql = "SELECT peso, altura FROM pessoas";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalImc = 0;
    $quantidadePessoas = contParticipantes($conexao);

    foreach ($resultado as $registro) {
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



//funcoes idade
function listarIdades(PDO $conexao): void
{

    $comandoSQL = "SELECT * from pessoas";
    $stmt = $conexao->prepare($comandoSQL);
    $stmt->execute();
    $listaPessoas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($listaPessoas) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>Idade</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaPessoas as $registro): ?>

                    <tr>
                        <td><?= $registro['nome'] ?></td>
                        <td><?= $registro['sobrenome'] ?></td>
                        <td><?= $registro['idade'] ?> anos</td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>



    <?php else: ?>
        <p>Nenhum resultado encontrado.</p>
    <?php endif;
}

function maiorIdade(PDO $conexao): void
{
    $sql = "SELECT nome, sobrenome, idade FROM pessoas ORDER BY idade DESC LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        echo "<p>A idade mais velha é: <strong>" . $resultado['idade'] . "</strong> anos.</p>";
    } else {
        echo "<p>Nenhuma idade encontrada.</p>";
    }
}

function pessoaMaisVelha(PDO $conexao): void
{
    $sql = "SELECT nome, sobrenome, idade FROM pessoas ORDER BY idade DESC LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        echo "<p>A pessoa mais velha é: <strong>" . $resultado['nome'] . " " . $resultado['sobrenome'] . "</strong>, com <strong>" . $resultado['idade'] . "</strong> anos.</p>";
    } else {
        echo "<p>Nenhuma pessoa encontrada.</p>";
    }
}

function menorIdade(PDO $conexao): void
{
    $sql = "SELECT nome, sobrenome, idade FROM pessoas ORDER BY idade ASC LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        echo "<p>A menor idade é: <strong>" . $resultado['idade'] . "</strong> anos.</p>";
    } else {
        echo "<p>Nenhuma idade encontrada.</p>";
    }
}

function nomeEAlturaPessoaMaisNova(PDO $conexao): void
{
    $sql = "SELECT nome, sobrenome, altura FROM pessoas ORDER BY idade ASC LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        echo "<p>A pessoa mais nova é: <strong>" . $resultado['nome'] . " " . $resultado['sobrenome'] . "</strong>, com altura de <strong>" . $resultado['altura'] . "</strong> metros.</p>";
    } else {
        echo "<p>Nenhuma pessoa encontrada.</p>";
    }
}

function idadeMedia(PDO $conexao): void
{
    $sql = "SELECT idade FROM pessoas";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalIdade = 0;
    $quantidadePessoas = count($resultado);

    foreach ($resultado as $registro) {
        $totalIdade += $registro['idade'];
    }

    if ($quantidadePessoas > 0) {
        $idadeMedia = round($totalIdade / $quantidadePessoas, 2);
        echo "<p>A idade média do grupo é: <strong>" . $idadeMedia . "</strong> anos.</p>";
    } else {
        echo "<p>Nenhum participante encontrado para calcular a idade média.</p>";
    }
}

function acimaIdadeMedia(PDO $conexao): void
{
    $sql = "SELECT nome, sobrenome, idade FROM pessoas";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $pessoas = [];
    $somaIdades = 0;

    // Armazenamos todos os dados da pessoa, não apenas a idade
    foreach ($resultado as $registro) {
        $pessoas[] = $registro;
        $somaIdades += $registro['idade'];
    }

    $totalPessoas = count($pessoas);
    echo "<p>total de pessoas acima: <strong>" . $totalPessoas . "</strong>.</p>";

    if ($totalPessoas > 0) {
        $idadeMedia = round($somaIdades / $totalPessoas, 2);

        foreach ($pessoas as $pessoa) {
            if ($pessoa['idade'] > $idadeMedia) {
                echo $pessoa['nome'] . " " . $pessoa['sobrenome'] . " - " . $pessoa['idade'] . " anos
                </br></li>";
            }
        }
        echo "</ul>";
    } else {
        echo "<p>Nenhum participante encontrado para calcular a idade média.</p>";
    }  
}

function abaixoIdadeMedia(PDO $conexao): void
{
    $sql = "SELECT nome, sobrenome, idade FROM pessoas";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $pessoas = [];
    $somaIdades = 0;

    // Armazenamos todos os dados da pessoa, não apenas a idade
    foreach ($resultado as $registro) {
        $pessoas[] = $registro;
        $somaIdades += $registro['idade'];
    }

    $totalPessoas = count($pessoas);
    echo "<p>total de pessoas abaixo: <strong>" . $totalPessoas . "</strong>.</p>";

}

function nomesEIMC3MaioresIdades(PDO $conexao): void
{
    $sql = "SELECT nome, sobrenome, idade, peso, altura FROM pessoas ORDER BY idade DESC LIMIT 3";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultado) {
        foreach ($resultado as $registro) {
            $imc = calcularImc($registro['peso'], $registro['altura']);
            echo "<p>" . $registro['nome'] . " " . $registro['sobrenome'] . " - IMC: <strong>" . $imc . "</strong></p>";
        }
    } else {
        echo "<p>Nenhuma pessoa encontrada.</p>";
    }
}

function nomesEIMC5MenoresIdades(PDO $conexao): void
{
    $sql = "SELECT nome, sobrenome, idade, peso, altura FROM pessoas ORDER BY idade ASC LIMIT 5";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultado) {
        foreach ($resultado as $registro) {
            $imc = calcularImc($registro['peso'], $registro['altura']);
            echo "<p>" . $registro['nome'] . " " . $registro['sobrenome'] . " - IMC: <strong>" . $imc . "</strong></p>";
        }
    } else {
        echo "<p>Nenhuma pessoa encontrada.</p>";
    }
}

//funcoes peso

function listarPesos(PDO $conexao): void
{
    $stmt = $conexao->prepare("SELECT * FROM pessoas");
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultado): ?>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>Peso</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultado as $registro): ?>
                    <tr>
                        <td><?= $registro['nome'] ?></td>
                        <td><?= $registro['sobrenome'] ?></td>
                        <td><?= $registro['peso'] ?> kg</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum resultado encontrado.</p>
    <?php endif;
    $stmt = null;
}

function menorPeso(PDO $conexao): void
{
    $sql = "SELECT nome, sobrenome, peso FROM pessoas ORDER BY peso ASC LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultado) {
        $registro = $resultado[0];
        echo "<p>O menor peso é: <strong>" . $registro['peso'] . "</strong> kg, pertencente a <strong>" . $registro['nome'] . " " . $registro['sobrenome'] . "</strong>.</p>";
    } else {
        echo "<p>Nenhum peso encontrado.</p>";
    }
}

function maiorPeso(PDO $conexao): void
{
    $sql = "SELECT nome, sobrenome, peso FROM pessoas ORDER BY peso DESC LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultado) {
        $registro = $resultado[0];
        echo "<p>O maior peso é: <strong>" . $registro['peso'] . "</strong> kg, pertencente a <strong>" . $registro['nome'] . " " . $registro['sobrenome'] . "</strong>.</p>";
    } else {
        echo "<p>Nenhum peso encontrado.</p>";
    }
}

function pesoMedio(PDO $conexao): void
{
    $sql = "SELECT peso FROM pessoas";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalPeso = 0;
    $quantidadePessoas = count($resultado);

    foreach ($resultado as $registro) {
        $totalPeso += $registro['peso'];
    }

    if ($quantidadePessoas > 0) {
        $pesoMedio = round($totalPeso / $quantidadePessoas, 2);
        echo "<p>O peso médio dos participantes é: <strong>" . $pesoMedio . "</strong> kg.</p>";
    } else {
        echo "<p>Nenhum participante encontrado para calcular o peso médio.</p>";
    }
}

function pessoasFora(PDO $conexao): void{

    $stmt = $conexao->prepare("SELECT * FROM pessoas");
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $quilosPendentes = 0;

    if ($resultado): ?>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>Peso</th>
                    <th>Altura</th>
                    <th>IMC</th>
                    <th>Quilos para atingir peso ideal</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($resultado as $registro): 
                    $imc = calcularImc($registro['peso'], $registro['altura']);
                    
                    if ($imc < 18.5 || $imc > 25): 
                    if($imc < 18.5){
                        $quilosPendentes = round(18.5 * ($registro['altura'] * $registro['altura']) - $registro['peso'], 2);
                        
                    }else{
                        $quilosPendentes = round($registro['peso'] - 25 * ($registro['altura'] * $registro['altura']), 2);
                    }
                    
                    ?>
                    <tr>
                        <td><?= $registro['nome'] ?></td>
                        <td><?= $registro['sobrenome'] ?></td>
                        <td><?= $registro['peso'] ?> kg</td>
                        <td><?= $registro['altura'] ?> m</td>
                        <td><?= $imc ?></td>
                        <td><?= $quilosPendentes ?></td>
                    </tr>
                        
                <?php endif;?>
                <?php endforeach; ?>
            </tbody>
        </table> 

    <?php else: ?>
        <p>Nenhum resultado encontrado.</p>
    <?php endif;
}

