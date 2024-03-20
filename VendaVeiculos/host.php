<?php

$host = [
    "localhost", // server
    "root", // user
    "" // password
];

$database = "venda_veiculos";

// conectar o banco de dados
function ConnectSQLi() : mysqli {
    $host = $GLOBALS['host'];

    $conn = mysqli_connect($host[0], $host[1], $host[2]);
    if (!$conn) {
        die("Falha de conexao: " . mysqli_connect_error());
    }

    return $conn;
}

function ConnectDatabase($database_name) : mysqli {
    $host = $GLOBALS['host'];

    $conn = mysqli_connect($host[0], $host[1], $host[2], $database_name);
    if (!$conn) {
        CreateDatabase($database_name);
        //die("Falha de conexao: " . mysqli_connect_error());
    }

    return $conn;
}
function  CreateDatabase($database_name) : void {
    $conn = ConnectSQLi();

    $sql_command = "CREATE DATABASE ". $database_name;

    if (mysqli_query($conn, $sql_command)) {
        echo "Banco de dados criado!";
    } else {
        echo "Erro ao criar banco de dados: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
}

function newQuery($database_name, $sql_command) : void {
    $conn = ConnectDatabase($database_name);

    if (mysqli_query($conn, $sql_command)) {
        echo "Consulta executada!";
    } else {
        echo "Erro ao consultar: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

function CreateTables($database_name) : void {
    $query = "CREATE TABLE `$database_name`.";
    $tables = [
        "veiculos_decada90",
        "veiculos_decada2000",
        "veiculos_decada2010",
        "veiculos_decada2020"
    ];
    $cmd = " (
        `id` INT(5) NOT NULL AUTO_INCREMENT , 
        `placa` VARCHAR(7) NOT NULL , 
        `modelo` VARCHAR(50) NOT NULL , 
        `marca` VARCHAR(50) NOT NULL , 
        `cor` VARCHAR(20) NOT NULL , 
        `ano` YEAR(4) NOT NULL , 
        `ar_condicionado` BOOLEAN NOT NULL , 
        `dir_hidraulica` BOOLEAN NOT NULL , 
        `dir_eletrica` BOOLEAN NOT NULL , 
        `portas` INT(1) NOT NULL , 
        `tipo` INT(1) NOT NULL , 
        `importado` BOOLEAN NOT NULL , 
        `cambio` BOOLEAN NOT NULL , 
        `km` INT(6) NOT NULL , 
        `combustivel` INT(1) NOT NULL , 
        PRIMARY KEY (`id`)) 
        ENGINE = InnoDB;";

    $sql_command = "";
    for ($i=0; $i<count($tables); $i++) {
        $sql_command = $sql_command . $query . $tables[$i] . $cmd;
    }

    newQuery($database_name, $sql_command);
}

function InsertInto($database_name, $table_name, $colums, $values) : void {
    $sql_command = "INSERT INTO `$table_name` (";
    for ($i=0; $i<count($colums); $i++) {
        if ($i == count($colums)-1) {
            $sql_command = $sql_command . "`". $colums[$i] ."`) VALUES (";
        } else {
            $sql_command = $sql_command ."`". $colums[$i] ."`, ";
        }
    }

    // TODO
    /*
    
    INSERT INTO `veiculos_decada90` (`id`, `placa`, `modelo`, `marca`, `cor`, `ano`, `ar_condicionado`, `dir_hidraulica`, `dir_eletrica`, `portas`, `tipo`, `importado`, `cambio`, `km`, `combustivel`) VALUES (NULL, 'awd4591', '', '', '', '', '', '', '', '', '', '', '', '', '')
    
    */

    newQuery($database_name, $sql_command);
}