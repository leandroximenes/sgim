<?php 
session_start();
header('Content-Type: text/html; charset=iso-8859-1');

header("Content-type: application/vnd.ms-word");
header("Content-type: application/force-download");
header("Content-Disposition: attachment; filename=procuracao.doc");
header("Pragma: no-cache");

$titulo = 'Procura��o';

if(isset($_SESSION["SISTEMA_codPessoa"])){
 
	include("../../conexao/conexao.php");
	include("../../php/php.php");
	include("../diversos/util.php");
	
	global $mySQL;
	$codImovel = $_GET['codImovel'];
	$sql = sprintf("CALL procContratoImovelUnicoListar($codImovel)");
	$rs = $mySQL->runQuery($sql);

?>
<style> 
body{
	margin: 0px;
	font-size: 12px;
	font-family: arial;
}

.clearfix:after {
	content: ".";
	display: block;
	clear: both;
	visibility: hidden;
	height: 0;
}


table{
	font-size: 11pt;
	font-family: arial;
}

th{
	background: #19688F;
	font-weight: bold;
	color: #FFF;
}

.vermelho{
	color: #990000;
}

.verde{
	color: #31CC2E;
}

.clJustificar{
	text-align: justify;
}

#cabecalhoRelatorio{
	width: 650px;
	margin-bottom: 10px;
	height: 62px;
	background: url('img/bg_topo.jpg') bottom repeat-x;
	float: left;
}

#logoRelatorio{
	float: left;
}

#tituloRelatorio{
	float: right;
	text-align: right;
}

#nomeRelatorio{
	padding-top: 15px;
	font-size: 18px;
	color: #19688F;
}
</style>

<?php

	$rsLinha = mysqli_fetch_assoc($rs);
        utf8_decode_array($rsLinha);
	$enderecoImovel = ($rsLinha['endereco']);
	$bairroImovel = ($rsLinha['bairro']);
	$cidadeImovel = ($rsLinha['cidade']);
	$ufImovel = $rsLinha['uf'];
	$cepImovel = mascaraCep($rsLinha['cep']);
	$codLocador = $rsLinha['codProprietario'];

	$sql = sprintf("CALL procPessoaListarUnico($codLocador)");
	$rsLocatorio = $mySQL->runQuery($sql);       
	$rsLocatarioLinha = mysqli_fetch_assoc($rsLocatorio);
        utf8_decode_array($rsLocatarioLinha);
        
	$nomeLocatario = ($rsLocatarioLinha['nome']);
	$profissao = ($rsLocatarioLinha['profissao']);
	$cpf = mascaraCpf($rsLocatarioLinha['cpf']);
	$rg = number_format($rsLocatarioLinha['rg'], 0, ',', '.');
        $ufLocatario = $rsLocatarioLinha['uf'];
	$orgaoExpedidor = $rsLocatarioLinha['orgaoExpedidor'];
	$enderecoLocatario = ($rsLocatarioLinha['endereco']);
	$bairroLocatario = ($rsLocatarioLinha['bairro']);
	$cidadeLocatario = ($rsLocatarioLinha['cidade']);
	$cepLocatario = mascaraCep($rsLocatarioLinha['cep']);
	$nacionalidade = ($rsLocatarioLinha['nacionalidade']);
	
	$sqlTelefone = sprintf("CALL procPessoaTelefoneListar($codLocador)");
	
	$rsTelefone = $mySQL->runQuery($sqlTelefone);
	
	//se existir conjuge ele lista!
	$sqlConjuge = sprintf("CALL procPessoaConjugeListar($codLocador)"); 
	$rsConjugeLocatario = $mySQL->runQuery($sqlConjuge);	
	$rsLocatarioConjugeLinha = mysqli_fetch_assoc($rsConjugeLocatario);
        utf8_decode_array($rsLocatarioConjugeLinha);
        
	$conjugeLocatarioNome = ($rsLocatarioConjugeLinha['nome']);
	$conjugeLocatarioRg = number_format($rsLocatarioConjugeLinha['rg'], 0, ',', '.');;
	$conjugeLocatarioOrgaoExpedidor = $rsLocatarioConjugeLinha['orgaoExpedidor'];
	$conjugeLocatarioCpf = mascaraCpf($rsLocatarioConjugeLinha['cpf']);
	$conjugeLocatarioProfissao = ($rsLocatarioConjugeLinha['profissao']);
	$conjugeLocatarioNacionalidade = ($rsLocatarioConjugeLinha['nacionalidade']);
	
	if($conjugeLocatarioNome != ""){
		$strConjugeListar = ' casado(a) com ' . $conjugeLocatarioNome . ', ' . $conjugeLocatarioNacionalidade . ' (a), portador(a) da carteira de identidade ' . $conjugeLocatarioRg  . ' '  . $conjugeLocatarioOrgaoExpedidor . ', inscrito(a) no CPF sob n�  ' .  $conjugeLocatarioCpf . ',';
	}else{
		$strConjugeListar = "";
	}
	//fim
?>

<table border='0' width='600' cellpadding='0' cellspacing='0'>
	<tr>
		<td colspan='2'>
			<center><b style='font-size:18.5px'><u>PROCURA��O DE ADMINISTRA��O DE IM�VEL</u></b></center>
			
			<br/>

			<div class="clJustificar">
				Pelo presente instrumento particular de <b>Procura��o para Administra��o de Im�vel</b>, <?php echo $nomeLocatario . ", " . $nacionalidade ." (a) , ". $profissao .", " ?> 
				portador(a) da carteira de identidade <?php echo $rg . ' '  . $orgaoExpedidor . ", "; ?>	inscrito(a) no CPF sob n� <?php echo $cpf; ?>, 
				<?php if($strConjugeListar != ""){ echo $strConjugeListar; } ?>  
				residente(s) e domiciliado(a)(s) no(a) 
				<?php 
					echo $enderecoLocatario . " - " . $bairroLocatario . " - " . $cidadeLocatario . "-" . $ufLocatario ." CEP: " . $cepLocatario; 
				?>
				doravante denominado(s)(a) Contratante(s) Locador(es)(a), nomeia(m) e constitui(em) como procuradora a <b>TABAKAL</b> 
				Empreendimentos Imobili�rios Ltda., firma jur�dica inscrita CNPJ n� 06.864.021/0001-31 e inscri��o CF/DF 07.457.662/001-02 - Bras�lia - DF, Telefones (61) 3340-0921/8190-1122, 
                                representada pela corretora de im�veis <b>MARLEIDE DE ARA�JO TELES</b>, CRECI/DF 8091, a qual s�o outorgados poderes para administrar o im�vel situado no(a)<b>
				<?php echo $enderecoImovel . ' - '. $bairroImovel . ' - ' . ($cidadeImovel) . "-" . $ufImovel . " - CEP: " . $cepImovel; ?>,</b> podendo para tanto, a mandat�ria praticar, al�m de todos os atos que se fizerem necess�rios ao fiel cumprimento deste mandato, nos termos do contrato de Administra��o de Loca��o de Im�vel, em anexo, os seguintes: contratar, alterar, prorrogar, assinar termos aditivos contratuais, rescindir loca��es, 
				fazer acordos de novos valores, escolher os <b>LOCAT�RIOS</b> e fiadores, vistoriar o im�vel, assinar termo de vistoria de entrega e 
				recebimento de chaves, publicar an�ncios, (jornais e internet), receber alugu�is e quitar recibos, fazer executar e cumprir as cl�usulas 
				contratuais, inclusive representar junto � Companhia de Eletricidade, Companhia de �gua e Esgoto, <b>Secretaria de Fazenda e Planejamento do Distrito Federal</b>, Prefeituras 
				e Administra��es Regionais e ainda Companhia Telef�nica, podendo bloquear linhas telef�nicas, instaladas no im�vel locado, entregar e 
				receber chaves, pagar os impostos, taxas devidas, assinando para este fim, requerimentos, pap�is ou quaisquer outros documentos, promover cobran�as 
				amig�veis e/ou requerer despejos dos locat�rios por quaisquer dos pressupostos previstos na Lei 8.245/91 assim como defender o(a)(s) 
				outorgante(s) nas a��es contra o(a)(s) mesmo(a)(s) intentado, podendo contratar advogados, a eles substabelecendo os poderes gerais para o foro, 
				inclusive os poderes contidos nas clausulas �ad judicia et ad extra� e mais os especiais de transigir, em ju�zo ou fora dele, desistir, receber 
				e dar quita��es, assinar e requerer o que for necess�rio, praticar, enfim, todos os atos necess�rios ou �teis a boa e fiel administra��o dos bens 
				a ela confiados, receber cita��es, podendo substabelecer no todo ou em parte, com ou sem reserva, firmar acordos e compromissos, por mais especiais 
				que sejam para o bom e fiel cumprimento do presente mandato. Uma vez rescindido o contrato de Administra��o de Im�vel torna-se sem efeito a procura��o outorgada.
			</div>
			<br />		

			<div style="text-align: center"> <!-- data-->
<?php
				$dia = date("d"); 
				$mess = date("m"); 
				$ano = date("y"); 

				switch ($mess) {
					case "01":    $mes = "Janeiro";     break;
					case "02":    $mes = "Fevereiro";   break;
					case "03":    $mes = "Mar�o";       break;
					case "04":    $mes = "Abril";       break;
					case "05":    $mes = "Maio";        break;
					case "06":    $mes = "Junho";       break;
					case "07":    $mes = "Julho";       break;
					case "08":    $mes = "Agosto";      break;
					case "09":    $mes = "Setembro";    break;
					case "10":    $mes = "Outubro";     break;
					case "11":    $mes = "Novembro";    break;
					case "12":    $mes = "Dezembro";    break; 
				}
				
				echo 'Bras�lia-DF, ' . $dia . ' de ' .  $mes . ' de 20' . $ano . '.';
?>
			</div>
			<br />			
			<br/>
			<br/>
			<br/>
			<table width='600'>
				<tr>
					<td align='center'>
						________________________________
						<br/>
						<b>CONTRATANTE LOCADOR(A)</b>
						<br/>
						<?php echo $nomeLocatario; ?>
						<br/>
						CPF n� <?php echo $cpf; ?>
					</td>
<?php
					if($strConjugeListar != ""){
?>
						<td align='center'>
							________________________________
							<br/>
							<b>C�NJUGE</b>
							<br/>
							<?php echo $conjugeLocatarioNome; ?>
							<br/>
							CPF n� <?php echo $conjugeLocatarioCpf; ?>
						</td>
<?php
					}
?>
				</tr>
			</table>

<?php

}else{
	header('location:login.php');
}	
?>