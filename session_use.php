<?php
session_start(); 
var_dump($_SESSION);
var_dump($_SESSION["teste"]);

if(isset($_SESSION["teste"])){
    echo '<br /><br />Sess�o funcionando!';
}else{
    echo '<br /><br />Sess�o n�o funcionou!';
}