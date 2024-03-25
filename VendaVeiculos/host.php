<?php

$host = [
    "localhost", // server
    "root", // user
    "" // password
];

$database = "venda_veiculos";
$table_prefix = "veiculos_decada";

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

    $conn = ConnectSQLi();
    $sql_query = "SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database_name';";
    
    if ($result = mysqli_query($conn, $sql_query)) {
        $num = mysqli_num_rows($result);
        mysqli_close($conn);
        
        if ($num == '1') {
            $conn = mysqli_connect($host[0], $host[1], $host[2], $database_name);
            if (!$conn) {
                //CreateDatabase($database_name);
                die("Falha de conexao: " . mysqli_connect_error());
            }
            return $conn;
        } else {
            CreateDatabase($database_name);
            return ConnectDatabase($database_name);
        }
    } else {
        die ("falha");
    }
}
function  CreateDatabase($database_name) : void {
    $conn = ConnectSQLi();

    $sql_command = "CREATE DATABASE IF NOT EXISTS ". $database_name;

    if (mysqli_query($conn, $sql_command)) {
        echo "Banco de dados criado!";
        CreateTables($database_name);
    } else {
        echo "Erro ao criar banco de dados: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
}

function newQuery($database_name, $sql_command) : void {
    $conn = ConnectDatabase($database_name);
    echo $sql_command;
    if (mysqli_query($conn, $sql_command)) {
        echo "Consulta executada!";
    } else {
        echo "Erro ao consultar: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

function newRootQuery($sql_command) : void {
    $conn = ConnectSQLi();
    //echo $sql_command;
    if (mysqli_query($conn, $sql_command)) {
        echo "Consulta executada!";
    } else {
        echo "Erro ao consultar: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

function CreateTables($database_name) : void {
    $table_prefix = $GLOBALS['table_prefix'];

    $query = "CREATE TABLE IF NOT EXISTS `$database_name`.";
    $tables = [
        $table_prefix."90",
        $table_prefix."2000",
        $table_prefix."2010",
        $table_prefix."2020"
    ];
    $cmd = "(
        `id` INT(5) NOT NULL AUTO_INCREMENT,
        `placa` VARCHAR(7) NOT NULL,
        `modelo` VARCHAR(50) NOT NULL,
        `marca` VARCHAR(50) NOT NULL,
        `cor` VARCHAR(20) NOT NULL,
        `ano` YEAR(4) NOT NULL,
        `ar_condicionado` BOOLEAN NOT NULL,
        `dir_hidraulica` BOOLEAN NOT NULL,
        `dir_eletrica` BOOLEAN NOT NULL,
        `portas` INT(1) NOT NULL,
        `tipo` INT(1) NOT NULL,
        `importado` BOOLEAN NOT NULL,
        `cambio` BOOLEAN NOT NULL,
        `km` INT(6) NOT NULL,
        `combustivel` INT(1) NOT NULL,
        PRIMARY KEY(`id`)
    )";

    $sql_command = "";
    foreach ($tables as $tablekey) {
        $sql_command = $query . "`" . $tablekey . "` " . $cmd . " ENGINE = InnoDB;";
        newQuery($database_name, $sql_command);
    }

    // for ($i=0; $i<count($tables); $i++) {
    //     $sql_command = $query . "`" . $tables[$i] . "` " . $cmd . " ENGINE = InnoDB;";
    //     newQuery($database_name, $sql_command);
    // }
}

function InsertInto($database_name, $table_name, $colums, $values) : void {
    $sql_command = "INSERT INTO `$table_name` (";
    // concatena as colunas da array $colums para o query
    foreach ($colums as $index => $key) {
        if ($index < count($colums)-1) {
            $sql_command = $sql_command ."`". $key ."`, ";
        } else {
            $sql_command = $sql_command . "`". $key ."`) VALUES (";
        }
    }
    // concatena os valores da array $values para o query
    foreach ($values as $index => $key) {
        if ($index < count($values)-1) {
            $sql_command = $sql_command ."'". $key ."', ";
        } else {
            $sql_command = $sql_command . "'". $key ."')";
        }
    }
    //echo $sql_command;
    newQuery($database_name, $sql_command);
}