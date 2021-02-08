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

$mySQL->runQuery("call procPessoaListarUnico({$contrato['codProprietario']})");
$ArrayDados = $mySQL->getArrayResult();
if (!empty($ArrayDados))
    $proprietario = arrayUtf8Decode($ArrayDados[0]);

$mySQL->runQuery("call procPessoaListarUnico({$contrato['codContratante']})");
$ArrayDados = $mySQL->getArrayResult();
if (!empty($ArrayDados))
    $inquilino = arrayUtf8Decode($ArrayDados[0]);

$mySQL->runQuery("call procPessoaTelefoneListar({$contrato['codContratante']})");
$ArrayDados = $mySQL->getArrayResult();
if (!empty($ArrayDados))
    $inquilino_telefone = arrayUtf8Decode($ArrayDados[0]);

$mySQL->runQuery("call procPessoaConjugeListar({$contrato['codContratante']})");
$ArrayDados = $mySQL->getArrayResult();
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
    <p align="center"><b>COMUNICADO DE NOVO LOCAT�RIO(A)CONTRATO N.� <?= $contrato['codContrato'] ?></b><br/><br/></p>

    <p align="center"><b>Prezado S�ndico do <Endere�o Im�vel>, N.� <?= $imovel['endereco'] ?></b><br/><br/></p>

    <p class="justify">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Comunicamos a Vossa Senhoria que o im�vel 
        situado � <?= $imovel['endereco'] ?>, de propriedade do(a) Sr.(a) <?= $proprietario['nome'] ?>, <?= $proprietario['nacionalidade'] ?>, 
        <?= $proprietario['profissao'] ?>, por n�s administrado, foi alugado para o Sr.(a)  <?= $inquilino['nome'] ?>, <?= $inquilino['nacionalidade'] ?>, 
        <?= $inquilino['profissao'] ?>, <?= $inquilino['estadoCivil'] ?>, inscrito no CPF <?= mascaraCpf($inquilino['cpf']) ?> e 
        RG <?= $inquilino['rg'] ?> <?= $inquilino['orgaoExpedidor'] ?>, 
        <?php if (!empty($inquilino_conjuge)): ?>
            <?= $inquilino_conjuge['nome'] ?>, <?= $inquilino_conjuge['nacionalidade'] ?>, <?= $inquilino_conjuge['profissao'] ?>, inscrito no CPF 
            <?= mascaraCpf($inquilino_conjuge['cpf']) ?> e RG <?= $inquilino_conjuge['rg'] ?> <?= $inquilino_conjuge['orgaoExpedidor'] ?>,  

        <?php endif; ?>
        pelo per�odo de <?= $contrato['qtdMeses'] ?> meses, tendo seu in�cio em <?= $contrato['dataInicio'] ?> e t�rmino 
        em <?= $contrato['dataFim'] ?>, ficando o(a) LOCAT�RIO(A), a partir dessa data, respons�vel pelo pagamento das taxas de condom�nio.
    </p>   

    <p class="justify">
        Solicitamos ainda nos comunicar todo e qualquer assunto relativo ao im�vel em refer�ncia, principalmente cobran�a de <b>TAXAS EXTRAS</b>, 
        correspond�ncias, comunica��es eventuais e especialmente atrasos no pagamento de condom�nios. Dessa forma poderemos colaborar com a 
        sua Administra��o no recebimento de eventuais atrasos e solu��o de outros problemas.
    </p>

    <p class="justify">
        As <b>TAXAS EXTRAS</b>, poder�o ser encaminhadas ao <b>LOCAT�RIO(A)</b> para pagamento ou serem cobradas em nosso escrit�rio, sempre 
        acompanhada da <b>ATA DA ASSEMBLEIA</b> que deliberou o assunto. Queremos lembrar que, caso opte pelo recebimento em nosso escrit�rio n�o, 
        pagamos multa por atraso, uma vez que efetuamos o pagamento no ato da apresenta��o.
    </p>

    <p class="justify">
        Para maiores esclarecimentos, estamos a sua disposi��o, em nosso escrit�rio sito � SCLN QUADRA 309 BLOCO D N� 50 SALAS 104/105, 70755-540, 
        ASA NORTE, BRAS�LIA/DF ou pelos telefones (61) 3340-0921 / 98190-1122, em hor�rio comercial.
    </p>

    <p class="justify">
        Trabalhamos em parceria com condom�nios e muito agradecer�amos qualquer indica��o para loca��o de im�veis eventualmente vagos ou at� mesmo venda
        nesse condom�nio.
    </p><br/><br/>


    <p align="right">Bras�lia-DF, <?= data() ?></p><br/><br/>
    
    <p>Atenciosamente,</p><br/><br/>

    <p align="center">________________________________________<br/>
        TABAKAL Empreendimentos Imobili�rios<br/>
        Marleide de Ara�jo Teles<br/>
    </p>


</div>


