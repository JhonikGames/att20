<?php

//var_dump($_POST);

if (!$_POST) {
    die("Sem dados!");
}

if (!$_POST['page']) {
    die("Nao foi possivel adquerir a pagina local");
}

switch ($_POST['page']) {
    case '1':
        // principal
        
        header("Location: ./form_opcionais.html");
        break;
    
    case '2':
        // opcional
        header("Location: ./form_combustivel_tipo.html");
        break;

    case '3':
        // combustivel
        break;

    default:
        # code...
        break;
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
$tipo= $_POST['tipo'];
$importado= $_POST['importado'];
$cambio= $_POST['cambio'];
$km= $_POST['km'];
$combustivel= $_POST['combustivel'];

$colums = [
    "placa", "modelo", "cor", 
    "ano", "ar_condicionado", "dir_hidraulica", 
    "dir_eletrica", "portas", "tipo", "importado",
    "cambio", "km", "combustivel"
];
$values = [
    $placa, $modelo, $cor,
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