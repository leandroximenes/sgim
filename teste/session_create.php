<?php 
session_start(); 
$_SESSION["teste"] = "teste de session";
echo "se��o criada: "  . $_SESSION["teste"];
?>