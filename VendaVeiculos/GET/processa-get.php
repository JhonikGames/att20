<?php

//var_dump($_GET);

if (!$_GET) {
    die("Sem dados!");
}

include "../host.php";

if (!$host) {
    die("Erro ao incluir host!");
}

//var_dump($host);

$placa= $_GET['placa'];
$modelo= $_GET['modelo'];
$marca= $_GET['marca'];
$cor= $_GET['cor'];
$ano= $_GET['ano'];
$ar_cond= $_GET['ar_cond'];
$dir_hidraulica= $_GET['dir_hidra'];
$dir_eletrica= $_GET['dir_eletrica'];
$portas= $_GET['portas'];
$tipo= $_GET['tipo'];
$importado= $_GET['importado'];
$cambio= $_GET['cambio'];
$km= $_GET['km'];
$combustivel= $_GET['combustivel'];

$colums = [
    "placa", "modelo", "marca", "cor", 
    "ano", "ar_condicionado", "dir_hidraulica", 
    "dir_eletrica", "portas", "tipo", "importado",
    "cambio", "km", "combustivel"
];
$values = [
    $placa, $modelo, $marca, $cor,
    $ano, $ar_cond, $dir_hidraulica,
    $dir_eletrica, $portas, $tipo, $importado,
    $cambio, $km, $combustivel
];

//var_dump($ano);
// 2016 - *01* / 1998 - *99* / 2008 - *00*
//echo "<br>" . substr($ano, 1, 1);

$table_selected = $table_prefix;

if (substr($ano, 1,1) == 9) {
    // ano 1900
    $table_selected = $table_selected . "90";
} else {
    switch ( substr($ano, 2,1) ) {
        case '0':
            # DECADA 2000
            $table_selected = $table_selected . "2000";
            break;

        case '1':
            # DECADA 2010
            $table_selected = $table_selected . "2010";
            break;
        
        case '2':
            # DECADA 2020
            $table_selected = $table_selected . "2020";
            break;

        default:
            # erro...
            die("Foi encontrado um erro no Ano do carro: $ano");
            //break;
    }
}

//echo $table_selected;

/*var_dump($colums);
echo "<br><br>";
var_dump($values);*/

InsertInto($database, $table_selected, $colums, $values);

header("Location: ./");