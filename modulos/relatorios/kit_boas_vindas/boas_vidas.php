<?php
header('Content-Type: text/html; charset=iso-8859-1');
error_reporting(1);
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=document_recibo_entrega_chaves_{$_GET[codContrato]}.doc");
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
include("../../../conexao/conexao.php");
include("../../../php/php.php");
include("../../diversos/util.php");

$mySQL->runQuery("call procContratoUnicoListar({$_GET['codContrato']})");
$ArrayDados = $mySQL->getArrayResult();
if (!empty($ArrayDados))
    $contrato = arrayUtf8Decode($ArrayDados[0]);

$mySQL->runQuery("call procImovelUnicoListar({$contrato['codImovel']})");
$ArrayDados = $mySQL->getArrayResult();
if (!empty($ArrayDados))
    $imovel = arrayUtf8Decode($ArrayDados[0]);

$mySQL->runQuery("call procPessoaListarUnico({$contrato['codContratante']})");
$ArrayDados = $mySQL->getArrayResult();
if (!empty($ArrayDados))
    $inquilino = arrayUtf8Decode($ArrayDados[0]);

if (!empty($ArrayDados))
    $inquilino_conjuge = arrayUtf8Decode($ArrayDados[0]);
?>
<style type="text/css">
    body{
        font-family:Sans-Serif;-webkit-print-color-adjust:exact
    }
    
    table{
        vertical-align:text-top;border-spacing:0;border-collapse:collapse;width:100%
    }

    table td{
        border:1px solid #000
    }
    
    .justify{
        text-align: justify;
    }
    
    .zebrada thead{
        font-weight:700
    }

    .zebrada tbody tr:nth-child(odd){
        background-color:#ccc
    }
</style>
<script type="text/javascript" src="../../biblioteca_js/jquery-1.11.0.min.js"></script>
<div style="width: 584px;">
    <p align="center"><b>CARTA DE BOAS VINDAS</b><br/><br/></p>

    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prezado(a),</span> <?= $inquilino['nome'] ?>,</p>
    
    
    <p class="justify">� com grande satisfa��o que a 
        <b>TABAKAL EMPREENDIMENTOS IMOBILI�RIOS</b> o(a) recebe como <b>LOCAT�RIO(A)</b> do im�vel sito na <?= $imovel['endereco'] ?>.
    </p>
    
    <p class="justify">Temos como princ�pio b�sico a satisfa��o cont�nua dos nossos clientes, sejam eles <b>LOCADORES</b> ou <b>LOCAT�RIOS</b>.</p>
    
    <p class="justify">Pedimos aten��o m�xima principalmente com o Laudo Inicial de Vistoria e o Termo de Entrega de Documentos. S�o documentos 
        importantes na entrada no im�vel, que v�o dar a seguran�a para uma rela��o saud�vel e sem transtornos. Com base nas informa��es do Laudo 
        Inicial de Vistoria, pedimos aten��o especial para a manuten��o e conserva��o do im�vel.</p>
    
    <p class="justify">Tomando os devidos cuidados temos plena certeza que, ao final do contrato, o im�vel estar� bem conservado e o(a) senhor(a) 
        evitar� maiores transtornos e gastos</p>

    <p>Seja bem vindo(a) e boa moradia.</p><br/><br/>

        <p align="right">Bras�lia-DF, <?= data() ?></p><br/><br/>

        <p align="center">________________________________________<br/>
            TABAKAL Empreendimentos Imobili�rios<br/>
            Marleide de Ara�jo Teles<br/>
        </p>


</div>


