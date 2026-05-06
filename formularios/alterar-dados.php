<?php
include_once "../funcoes/funcoes.php";

$auxConectar = conectar();

$sql = "SELECT * FROM pessoas";
$stmt = $auxConectar->prepare($sql);
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

$id = $_GET['id'] ?? null;

$pessoa = null;

if ($id) {
    $sql = "SELECT * FROM pessoas WHERE idpessoa = ?";
    $stmt = $auxConectar->prepare($sql);

    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute();

    $pessoa = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar dados</title>
    <link rel="stylesheet" href="../assets/estilo-forms.css">
</head>

<body>
    <header>
        <h1>FORMULÁRIO ONLINE</h1>
    </header>

    <main class="container">
        <div class="caixa-destaque">
            Alterar Dados - Pessoais
        </div>

        <h3>Formulário</h3>

        <form action="processar-form-pessoas.php" method="post" class="form-grid">

            <input type="hidden" name="id" value="<?= $pessoa['idpessoa'] ?? '' ?>">

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="containerNome" value="<?= $pessoa['nome'] ?? '' ?>" required>
            <br>

            <label for="sobrenome">Sobrenome:</label>
            <input type="text" id="sobrenome" name="containerSobrenome" value="<?= $pessoa['sobrenome'] ?? '' ?>"
                required>
            <br>

            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="containerIdade" value="<?= $pessoa['idade'] ?? '' ?>" required>
            <br>

            <label for="peso">Peso:</label>
            <input type="number" step="0.01" id="peso" name="containerPeso" value="<?= $pessoa['peso'] ?? '' ?>"
                required>
            <br>

            <label for="altura">Altura:</label>
            <input type="number" step="0.01" id="altura" name="containerAltura" value="<?= $pessoa['altura'] ?? '' ?>"
                required>
            <br>

            <div class="button-area">
                <button type="submit" class="btn-alterar">Alterar</button>

            </div>
        </form>

        <div class="button-area">
            <a href="painel-administrativo.html" class="btn-menu">Voltar ao Menu</a>
        </div>
        
    </main>

    <footer>
        <hr>
        <div class="rodape-conteudo">
            Crédito - Pablo Theves & Tiago Gonçalves - Grupo de Pesquisa
        </div>
    </footer>

</body>

</html>

</html>