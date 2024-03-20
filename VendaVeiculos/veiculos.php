<?php

//var_dump($_POST);

if (!$_POST) {
    die("Sem dados!");
}

include "./host.php";

if (!$host) {
    die("Erro ao incluir host!");
}

//var_dump($host);

$placa= $_POST['placa'];
$modelo= $_POST['modelo'];
$cor= $_POST['cor'];
$ano= $_POST['ano'];
$ar_cond= $_POST['ar_cond'];
$dir_hidraulica= $_POST['dir_hidra'];
$dir_eletrica= $_POST['dir_eletrica'];
$portas= $_POST['portas'];
$importado= $_POST['importado'];
$cambio= $_POST['cambio'];
$km= $_POST['km'];
$combustivel= $_POST['combustivel'];

$sql = "INSERT INTO ``";

newQuery($database, $sql);