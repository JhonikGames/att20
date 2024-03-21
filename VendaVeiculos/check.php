<?php

require "./host.php";

if (!$_POST) {
    die;
}

//var_dump($_POST);

if ($_POST['tipo'] == "create") {
    //echo "criar";
    CreateDatabase($database);
} else {
    //echo "delete";
    $sql = "DROP DATABASE `$database`";
    newQuery($database, $sql);
}

sleep(5);

header("Location: ./");