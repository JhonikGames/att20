<?php
session_start();

//var_dump($_POST);
if (!$_POST) {
    die("Sem dados!");
}

if (!$_POST['page']) {
    die("Nao foi possivel adquerir a pagina local");
}

include "./host.php";
if (!$host) {
    die("Erro ao incluir host!");
}
//var_dump($host);

switch ($_POST['page']) {
    case '1':
        // principal
        $_SESSION['form_page1_post'] = $_POST;
        header("Location: ./form_opcionais.html");
        break;
    
    case '2':
        // opcional
        $_SESSION['form_page2_post'] = $_POST;
        header("Location: ./form_combustivel_tipo.html");
        break;

    case '3':
        // combustivel
        $_SESSION['form_page3_post'] = $_POST;
        ProcessForm();
        header("Location: ./");
        break;

    default:
        # code...
        break;
}

function ProcessForm() : void {
    $page1 = $_SESSION['form_page1_post'];
    $page2 = $_SESSION['form_page2_post'];
    $page3 = $_SESSION['form_page3_post'];
    $POST_SESSION = array_merge($page1, $page2, $page3);

    //var_dump($POST_SESSION);

    $database = $GLOBALS['database'];
    $table_prefix = $GLOBALS['table_prefix'];

    $placa= $POST_SESSION['placa'];
    $modelo= $POST_SESSION['modelo'];
    $cor= $POST_SESSION['cor'];
    $ano= $POST_SESSION['ano'];
    $ar_cond= $POST_SESSION['ar_cond'];
    $dir_hidraulica= $POST_SESSION['dir_hidra'];
    $dir_eletrica= $POST_SESSION['dir_eletrica'];
    $portas= $POST_SESSION['portas'];
    $tipo= $POST_SESSION['tipo'];
    $importado= $POST_SESSION['importado'];
    $cambio= $POST_SESSION['cambio'];
    $km= $POST_SESSION['km'];
    $combustivel= $POST_SESSION['combustivel'];

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

    session_unset();
    header("Location: ./");
}