<?php

header('Content-Type: text/html; charset=iso8859-1');
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    include("../conexao/conexao.php");

    $database = "sgim";

    $mySQL->runQuery("show tables");
    $tables = $mySQL->getArrayResult();


    foreach ($tables as $table) {
        $param = "Tables_in_$database";
        $mySQL->runQuery("SHOW KEYS FROM {$table[$param]} WHERE Key_name = 'PRIMARY'");
        $resultPrimary = $mySQL->getArrayResult();
        echo "tablea: {$resultPrimary[0]['Table']} => PK: {$resultPrimary[0]['Column_name']}<br />";
        alteraValoresTabela($resultPrimary[0]['Table'], $resultPrimary[0]['Column_name']);
    }
} catch (Exception $exc) {
    echo $exc->getMessage();
}

function alteraValoresTabela($tableName, $pkName) {
    global $mySQL;

    $mySQL->runQuery("SELECT * FROM $tableName");
    $result = $mySQL->getArrayResult();
    foreach ($result as $resultKey => $colunas) {
        $SQL = "UPDATE $tableName SET ";
        foreach ($colunas as $colunasName => $colunaVal) {
            if (!is_null($colunaVal) && $pkName != $colunasName) {
                $SQL .= "$colunasName = '$colunaVal', ";
            }
        }
        $SQL .= "WHERE $pkName = {$colunas[$pkName]}";
        $SQL = str_replace(", WHERE", "  WHERE", $SQL);

        $mysqli = new mysqli("localhost", "u672794128_admin", "Tabakal&sgim01", $database);

        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli->connect_error;
            exit();
        }

        // Change character set to utf8
        $mysqli->set_charset("utf8");

        if(!$mysqli->query($SQL)){
            throw new Exception("Erro ao processar a query" . $SQ);
            
        }
        $mysqli->close();
    }
    echo "tudo certo com a tabela $tableName<br /><br />";
}