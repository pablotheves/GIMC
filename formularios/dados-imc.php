<?php

include "../banco_de_dados/funcoes_bd.php";

$auxConectar = conectar();

listarImcs($auxConectar);