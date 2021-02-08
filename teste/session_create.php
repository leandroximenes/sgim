<?php 
session_start(); 
$_SESSION["teste"] = "teste de session";
echo "seção criada: "  . $_SESSION["teste"];
?>