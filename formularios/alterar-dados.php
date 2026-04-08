<?php
    include_once "../funcoes/funcoes.php";

    $auxConectar = conectar();

    $sql = "SELECT * FROM pessoas";
    $resultado = mysqli_query($auxConectar, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar dados</title>
</head>
<body>
    
</body>
</html>