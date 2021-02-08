<?php
header('Content-Type: text/html; charset=iso-8859-1');
error_reporting(1);
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=document_termo_entrega_documentos_{$_GET[codContrato]}.doc");
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
include("../../../conexao/conexao.php");
include("../../../php/php.php");
include("../../diversos/util.php");

$mySQL->runQuery("call procContratoUnicoListar({$_GET['codContrato']})");
$ArrayDados = $mySQL->getArrayResult();
if (!empty($ArrayDados))
    $contrato = arrayUtf8Decode($ArrayDados[0]);

$mySQL->runQuery("call procPessoaListarUnico({$contrato['codContratante']})");
$ArrayDados = $mySQL->getArrayResult();
if (!empty($ArrayDados))
    $inquilino = arrayUtf8Decode($ArrayDados[0]);

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
    
    .recuo { text-indent:4em }
    
    .zebrada thead{
        font-weight:700
    }

    .zebrada tbody tr:nth-child(odd){
        background-color:#ccc
    }
</style>
<script type="text/javascript" src="../../biblioteca_js/jquery-1.11.0.min.js"></script>
<div style="width: 584px;">
    <p align="center"><b>TERMO DE ENTREGA DE DOCUMENTOS E ORIENTA��ES PARA O <?= strtoupper($inquilino['nome']) ?><br/>
            CONTRATO N.� <?= $contrato['codContrato'] ?></b><br/><br/></p>

    <p class="justify">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Eu,</span> <?= $inquilino['nome'] ?>, 
        na qualidade de <b>LOCAT�RIO(A)</b>, declaro ter recebido da <b>TABAKAL EMPREENDIMENTOS IMOBILI�RIOS LTDA.</b>, 
        pessoa jur�dica de direito privado, inscrita no CNPJ/MF n.� 06.864.021/0001-31, Inscri��o Estadual n.� 07.457.662/001-02 e 
        Conselho Regional de Corretores de Im�veis - CRECI/DF n.� 9508, estabelecida na <b>SCLN QUADRA 309 BLOCO D N� 50 SALAS 104/105, 
            70755-540, ASA NORTE, BRAS�LIA/DF</b>, os documentos e orienta��es relativas ao im�vel sito na <?= $contrato['endereco'] ?>, objeto 
        desta loca��o:</p><br/><br/>

    <b>DOCUMENTOS:</b><br/>

    <ul>
        <li><b>Recibo de Chaves </b>(declaro ter recebido uma via);</li>
        <li><b>Carta para  S�ndico </b>(declaro ter recebido uma via);</li>
        <li><b>Carta de Boas Vindas </b>(declaro ter recebido uma via);</li>
        <li><b>Contrato de Loca��o </b>(declaro ter recebido uma via assinada);</li>
        <li><b>Termo de Vistoria </b>(declaro ter recebido uma via. Estou ciente do prazo de 7 dias corridos, a contar desta data, para entregar 
            contesta��o/observa��es, em 3 vias de igual teor);</li>
    </ul>


    <b>ORIENTA��ES E INFORMA��ES:</b><br/><br/>
    <p class="justify"> <b>Seguro Inc�ndio</b> - Comprometo-me a entregar proposta de contrata��o em at� 7 dias da assinatura do contrato de loca��o, 
    e ap�lice em at� 20 dias. O seguro � renovado a cada 12 meses e, caso n�o ocorra contrata��o/renova��o, autorizo a cobran�a, em �nica parcela, 
    em meu boleto de aluguel;</p>
    <p class="justify"><b>CEB inscri��o, CAESB inscri��o e GAS </b>- Estou ciente que, de posse do contrato de loca��o assinado com reconhecimento de firma do locador 
    e dos meus documentos pessoais, devo encaminhar �s respectivas concession�rias pedido de religa��o de fornecimento de servi�os e fazer altera��o 
    cadastral ao consumidor, ainda que tenha fornecimento;</p>
    <p class="justify"><b>IPTU/TLP inscri��o "Nr. IPTU"</b> - Estou ciente que devo entregar os comprovantes de pagamento na imobili�ria e estar atento aos vencimentos 
    dos boletos enviados pelos correios ou retirar a 2� via no site da SEFAZ (www.fazenda.df.gov.br). Em caso de d�vida deverei entrar em contato com 
    a imobili�ria;</p>
    <p class="justify"><b>Taxas Extras, Atas e Nada Consta </b>- Estou ciente que devo entregar imediatamente na imobili�ria boletos e atas das taxas extras, antes de 
    seus vencimentos. Caso eu venha efetuar os pagamentos,</p>
    devo apresentar os comprovantes e solicitar ressarcimento. Caso ocorra mora  por minha culpa terei que arcar com juros e multas. Estou ciente que 
    devo apresentar � administradora, a cada 06 meses, ou sempre que me for solicitado, o Nada Consta do Condom�nio;<br/>
    <p class="justify"><b>Boleto de Aluguel </b>- Estou ciente que, caso n�o o receba em tempo h�bil para o pagamento, � minha obriga��o comparecer � imobili�ria para 
    retirar um novo, antes do vencimento;</p>
    <p class="justify"><b>Im�veis com Garagem </b>- O controle deve ser devolvido juntamente com as chaves e em condi��es de uso. Caso contr�rio ficarei obrigado a 
    realizar a troca ou reparos necess�rios para o bom funcionamento;</p>
    <p class="justify"><b>Comprovantes de Pagamento </b>- Estou ciente que devo encaminhar trimestralmente todos os comprovantes de pagamento (Condom�nio, Energia 
    El�trica, �gua, IPTU/TLP etc.). No caso do IPTU/TLP, deverei entregar todo ano o carn� quitado com os comprovantes originais, sabendo que se 
    trata de imposto e que o documento pertence ao LOCADOR(A).</p><br/><br/>

    <p align="right">Bras�lia-DF, <?= data() ?></p><br/><br/>

    <p align="center">________________________________________<br/>
        LOCAT�RIO: <?= $inquilino['nome'] ?><br/>
        CPF n.� <?= mascaraCpf($contrato['cpf']) ?> <br/>
    </p>


</div>


