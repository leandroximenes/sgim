<?php 
session_start();
header('Content-Type: text/html; charset=iso-8859-1');

header("Content-type: application/vnd.ms-word");
header("Content-type: application/force-download");
header("Content-Disposition: attachment; filename=contrato_administracao_Garantia.doc");
header("Pragma: no-cache");

$titulo = 'COntrato de administra��o';

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
	$enderecoImovel = $rsLinha['endereco'];
	$bairroImovel = $rsLinha['bairro'];
	$cidadeImovel = $rsLinha['cidade'];
	$ufImovel = $rsLinha['uf'];
	$cepImovel = $rsLinha['cep'];
	$codProprietario = $rsLinha['codProprietario'];
	$valor = $rsLinha['valor'];

	$sql = sprintf("CALL procPessoaListarUnico($codProprietario)");
	$rsLocatorio = $mySQL->runQuery($sql);
	$rsLocatarioLinha = mysqli_fetch_assoc($rsLocatorio);
	$nomeLocatario = utf8_decode($rsLocatarioLinha['nome']);
	$emailProprietario = utf8_decode($rsLocatarioLinha['email']);
	$profissao = utf8_decode($rsLocatarioLinha['profissao']);
	$cpf = $rsLocatarioLinha['cpf'];
	$rg = $rsLocatarioLinha['rg'];
	$orgaoExpedidor = $rsLocatarioLinha['orgaoExpedidor'];
	$enderecoLocatario = $rsLocatarioLinha['endereco'];
	$bairroLocatario = $rsLocatarioLinha['bairro'];
	$cidadeLocatario = $rsLocatarioLinha['cidade'];
	$cepLocatario = $rsLocatarioLinha['cep'];
	$nacionalidade = $rsLocatarioLinha['nacionalidade'];
	
	$sqlTelefone = sprintf("CALL procPessoaTelefoneListar($codProprietario)");
	
	$rsTelefone = $mySQL->runQuery($sqlTelefone);
		
	$sqlBanco 		= sprintf("CALL procPessoaDadoBancarioListar($codProprietario)");
	$rsBanco 		= $mySQL->runQuery($sqlBanco);
	$rsBancoLinha 	= mysqli_fetch_assoc($rsBanco);
	
	$banco = $rsBancoLinha['banco'];
	$agencia = $rsBancoLinha['agencia'];
	$conta = $rsBancoLinha['conta'];
	$observacao = $rsBancoLinha['observacao'];
	
	//se existir conjuge ele lista!
	$sqlConjuge = sprintf("CALL procPessoaConjugeListar($codProprietario)"); 
	$rsConjugeLocatario = $mySQL->runQuery($sqlConjuge);
	
	
	$rsLocatarioConjugeLinha = mysqli_fetch_assoc($rsConjugeLocatario);
	$conjugeLocatarioNome = $rsLocatarioConjugeLinha['nome'];
	$conjugeLocatarioRg = $rsLocatarioConjugeLinha['rg'];
	$conjugeLocatarioOrgaoExpedidor = $rsLocatarioConjugeLinha['orgaoExpedidor'];
	$conjugeLocatarioCpf = $rsLocatarioConjugeLinha['cpf'];
	$conjugeLocatarioProfissao = $rsLocatarioConjugeLinha['profissao'];
	$conjugeLocatarioNacionalidade = $rsLocatarioConjugeLinha['nacionalidade'];
	
	if($conjugeLocatarioNome != ""){
		$strConjugeListar = ' casado(a) com ' . $conjugeLocatarioNome . ', ' . $conjugeLocatarioNacionalidade . '(a), portador(a) da carteira de identidade ' . $conjugeLocatarioRg . ' '  . $conjugeLocatarioOrgaoExpedidor . ', inscrito(a) no CPF sob o n�mero ' .  $conjugeLocatarioCpf . ',';
	}else{
		$strConjugeListar = "";
	}
	//fim
?>

<table border='0' width='600' cellpadding='0' cellspacing='0'>
	<tr>
		<td colspan='2'>
			<center><b>Contrato de Administra��o de Im�vel Com Garantia de Pagamento de Aluguel</b></center>
			<br/>
			<br/>

			<div class="clJustificar">
				<b>Contrato de Administra��o de Im�vel </b>que fazem entre si, <?php echo utf8_decode($nomeLocatario) . ", " . $nacionalidade ."(a), ". utf8_decode($profissao) .", " ?> 
				portador(a) da carteira de identidade <?php echo $rg . ' '  . $orgaoExpedidor . ", "; ?>	inscrito(a) no CPF sob o <?php echo $cpf; ?>, 
				<?php if($strConjugeListar != ""){ echo $strConjugeListar; }else{ echo ","; } ?>  
				residente(s) e domiciliado(a)(s) 
				<?php 
					echo utf8_decode($enderecoLocatario) . " - " . utf8_decode($bairroLocatario) . " - " . utf8_decode($cidadeLocatario) . " - CEP: " . $cepLocatario; 
					echo " Fones: "
				?>
				<?php
					while($linhaTelefone = mysqli_fetch_assoc($rsTelefone)){
						
						$mystring = $linhaTelefone['telefone'];
						$findme   = '________';
						$pos = strpos($mystring, $findme);
					
						if(!$pos){
							echo $mystring . ", ";;
						}
					}	
				?>e TABAKAL Empreendimentos Imobili�rios Ltda., inscrita no CNPJ/MF sob o n� 06.864.021/0001-31 e Inscri��o CF/DF 
				n� 07.457.662/001-02 Bras�lia - DF, e no Conselho Regional de Corretores de Im�veis - CRECI, sob o n� 9508, representada 
				pela corretora de im�veis MARLEIDE DE ARAUJO TELES, CRECI/DF 8091, aqui denominados, respectivamente, 
				CONTRATANTE(S) LOCADOR(ES)(A) e CONTRATADA ADMINISTRADORA, mediante as seguintes condi��es:
			</div>
			<br />		
			<div class="clJustificar">
				<b>CL�USULA PRIMEIRA - </b>O(s)(A) Contratante(s) Locador(es)(a) ajusta(m) com a Contratada Administradora a administra��o de um im�vel situado na <?php echo utf8_decode($enderecoImovel) . ', '. utf8_decode($bairroImovel) . ', ' . utf8_decode($cidadeImovel) . "-" . $ufImovel . " - CEP: " . $cepImovel; ?>, tudo de conformidade com os termos da procura��o anexa, que passa a fazer parte integrante deste instrumento. 
			</div>
			<br/>
			<div class="clJustificar">
				<b>CL�USULA SEGUNDA - </b>� Contratada Administradora � facultada, sob sua inteira responsabilidade, a escolha do locat�rio e das garantias fidejuss�rias que ele prestar, estabelecendo as condi��es do contrato de loca��o que em nome do(s)(a) Contratante(s) Locador(es)(a) firmar�, observando a legisla��o pertinente, e obviamente, seus interesses.
			</div>
			<br/>
			<div class="clJustificar">
				<b>CL�USULA TERCEIRA - </b>O valor do contrato de loca��o inicial a ser celebrado ser� de <?php echo 'R$ '. number_format($valor, 2, ',', '.'); ?> (<?php echo extenso($valor, true, true, true); ?>), reajust�veis a cada 12 (doze) meses, de acordo com o IGPM/FGV. Fica consignado que correr� por conta do locat�rio os encargos de �gua, luz, seguro de inc�ndio, telefone, IPTU/TLP. 
			</div>
			<br/>
			<div class="clJustificar">
				<b>CL�USULA QUARTA - </b>A Contratada Administradora prestar� assist�ncia advocat�cia ao(s)(�) Contratante(s) Locador(es)(a), defendendo todos seus direitos, especificamente no que diz respeito � loca��o e acess�rios do im�vel ora administrado.
			</div>
			<br/>
			<div class="clJustificar">
				<b>par�grafo �nico � </b>As despesas judiciais e os honor�rios advocat�cios estranhos ao contrato de loca��o e seus acess�rios correr�o por conta do(s)(a) Contratante(s) Locador(es)(a).
			</div>
			<br/>
			<div class="clJustificar">
				<b>CL�USULA QUINTA - </b>A Contratada Administradora far� jus, a t�tulo de remunera��o pelos servi�os que prestar ao(s)(�) Contratante(s) Locador(es)(a), a comiss�o de 15% (quinze por cento) do valor dos alugu�is l�quidos recebidos do locat�rio, e ser� esta descontada na presta��o mensal de contas, contra recibo.
			</div>				
			<br/>
			<div class="clJustificar">					
				<b>CL�USULA SEXTA - </b>O(s)(A) Contratante(s) Locador(es)(a) estipula(m) que tem interesse em receber da Contratada Administradora o aluguel l�quido conforme a seguir: Dep�sito Banc�rio no Banco <?php echo $banco; ?>  - Ag�ncia: <?php echo $agencia . ", "; ?> Conta Corrente <?php echo $conta . ", " . utf8_decode($observacao); ?>.
			</div>	
			<br/>
			<div class="clJustificar">		
				<b>CL�USULA S�TIMA - </b>A Contratada Administradora colocar� � disposi��o do(s)(o) Contratante(s) Locador(es)(a) o valor l�quido referente ao aluguel at� o quinto dia �til, a contar da data do efetivo recebimento do aluguel. Mensalmente a  Contratada Administradora enviar� ao e-mail  <b><?php echo strtolower($emailProprietario); ?></b>, extrato com cr�ditos e d�bitos relativos � loca��o.
			</div>			
			<br/>
			<div class="clJustificar">		
				<b>CL�USULA OITAVA - </b>A Contratada Administradora ficar� desobrigada de efetuar o pagamento do aluguel ao(s)(�) Contratante(s) Locador(es)(a) se este n�o for pago pelo locat�rio em caso de desapropria��o, interdi��o, venda ou penhora, arresto ou seq�estro do im�vel, calamidade p�blica e guerra, quando ajuizada a��o de retomada, ou ainda, quando por qualquer motivo o(s)(a) Contratante(s) Locador(es)(a) der(em) causa a que o locat�rio retenha o pagamento.
			</div>			
			<br/>
			<div class="clJustificar">		
				<b>CL�USULA NONA - </b>N�o efetuado o pagamento do aluguel pelo locat�rio e necessitando a Contratada Administradora promover a cobran�a amig�vel e/ou judicial contra o mesmo n�o poder�(�o) o(s)(a) Contratante(s) Locador(es)(a), em hip�tese alguma, revogar(em) a procura��o que �quela outorgou, nem tampouco obstar, por qualquer forma, os procedimentos judiciais que ser�o promovidos, sob pena de ficar(em) sujeito(s) o(s)(a) Contratante(s) Locador(es)(a) ao pagamento de uma indeniza��o equivalente ao montante do que esteja sendo exigido do locat�rio em Ju�zo.
			</div>			
			<br/>
			<div class="clJustificar">					
				<b>CL�USULA D�CIMA � </b>Uma vez que o aluguel � garantido ao(s)(�) Contratante(s) Locador(es)(a) pela Contratada Administradora, a esta caber�o integralmente os juros, a corre��o monet�ria e as multas cobradas do locat�rio, inclusive a multa de rescis�o contratual conforme o caso, sem preju�zo da comiss�o a esta devida, na forma pactuada na <b>CL�USULA QUINTA</b>.
			</div>	
			<br/>
			<div class="clJustificar">					
				<b>CL�USULA D�CIMA PRIMEIRA � </b>A Contratada Administradora mediante autoriza��o do(s)(a) Contratante(s) Locador(es)(a) celebrar� novo contrato de loca��o, por prazo id�ntico ou diverso, se a loca��o em curso vier a ser rescindida antes do prazo previsto, seja amig�vel ou judicialmente.
			</div>	
			<br/>
			<div class="clJustificar">			
				<b>Par�grafo Primeiro - </b> Ocorrendo � hip�tese prevista no caput desta Cl�usula, se obriga a Contratada Administradora dar ci�ncia ao(s)(�) Contratante(s) Locador(es)(a), tudo com vistas a ser ajustado novo pre�o e anu�ncia quanto ao novo prazo da loca��o.
			</div>
			
			<br/>
			<div class="clJustificar">							
				<b>CL�USULA D�CIMA SEGUNDA - </b>Ao(s)(�) Contratante(s) Locador(es)(a) ser� defeso celebrar acordos com locat�rio sem expressa anu�ncia escrita da Contratada Administradora, assim como ingerir na administra��o do im�vel, sob pena de multa equivalente ao valor de 01 (um) m�s de aluguel conforme disposto na <b>CL�USULA TERCEIRA</b>.
			</div>					
			<br/>
			<div class="clJustificar">							
				<b>CL�USULA D�CIMA TERCEIRA - </b>Na vig�ncia do presente contrato de administra��o, caso seja autorizada a venda pelo(s)(a) Contratante(s) Locador(es)(a), fica desde j� a Contratada Administradora, nomeada a intermediadora da venda do im�vel em quest�o, fazendo jus, portanto, � comiss�o equivalente a <b>5% (cinco por cento)</b> sobre o valor da transa��o.
			</div>			
			<br/>
			<div class="clJustificar">							
				<b>CL�USULA D�CIMA QUARTA - </b>O presente contrato de Administra��o � celebrado por prazo id�ntico ao contrato de loca��o a ser celebrado e somente poder� ser rescindido nas seguintes condi��es:
			</div>					
			<br/>
			<div class="clJustificar">							
				a) - <b>Por justa causa</b>, caso a Contratada Administradora, sem qualquer justificativa v�lida, deixe de prestar contas do aluguel, ap�s o prazo de car�ncia, salvo motivo de for�a maior, tais como greve banc�ria, calamidade p�blica, etc. Nestas circunst�ncias nada ser� devido de comiss�o � Administradora Contratada, exigindo-se apenas que se fa�a a indispens�vel prova da infring�ncia contratual que se notifique judicialmente a Contratada Administradora, a fim de que se proceda administrativamente a rescis�o do presente contrato, sob pena de n�o o fazendo ser feita judicialmente.
			</div>			
			<br/>
			<div class="clJustificar">							
				b) - <b>Sem justa causa</b>, devendo ser precedida ser precedida de notifica��o com anteced�ncia m�nima de <b>90 (noventa)</b> dias do vencimento do contrato locat�cio, caso pretenda(m) o(s)(a) Contratante(s) Locador(es)(a) retirar(em) o im�vel da Administra��o da Contratada Administradora, ap�s o vencimento do contrato locat�cio. Neste caso, arcar�(�o) o(s)(a) Contratante(s) Locador(es)(a) com o pagamento da comiss�o imobili�ria pactuada na <b>CL�USULA QUINTA</b>, calculada sobre os meses restantes at� o t�rmino do contrato locat�cio ou, na aus�ncia da notifica��o no prazo previsto, o equivalente a um m�s de aluguel.
			</div>			
			<br/>
			<div class="clJustificar">							
				<b>Par�grafo �nico - </b>Se a Contratada Administradora, sem motivo justificado, rescindir o presente contrato de Administra��o, se obrigar� igualmente ao pagamento da multa correspondente a comiss�o imobili�ria pactuada na <b>CL�USULA QUINTA</b>, calculada sobre os meses restantes at� o t�rmino do contrato locat�cio, ou na aus�ncia de notifica��o no prazo previsto, o equivalente a um m�s de aluguel.
			</div>			
			<br/>
			<div class="clJustificar">											
				<b>CL�USULA D�CIMA QUINTA - </b>Rescindido este contrato, ficar� sem efeito a procura��o referida na <b>CL�USULA PRIMEIRA</b>, outorgada pelo(s)(a) Contratante(s) Locador(es)(a) � Contratada Administradora.
			</div>	
			<br/>
			<div class="clJustificar">															
				<b>CL�USULA D�CIMA SEXTA - </b>Elegem os contratantes o foro da Circunscri��o Judici�ria de Bras�lia-DF, com exclus�o de qualquer outro, para que sejam dirimidas as quest�es oriundas deste contrato.
			</div>			
			<br/>
			<br/>
			<br/>		
			<div> <!-- data-->
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
				
				echo 'Bras�lia-DF, ' . $dia . ' de ' .  $mes . ' de 20' . $ano;
?>
			</div>
			<br />			
			<br/>
			<br/>
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
						CPF: <?php echo $cpf; ?>
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
						CPF: <?php echo $conjugeLocatarioCpf; ?>
					</td>
<?php
					}
?>
				</tr>
			</table>
			<br/>
			<br/>
			<br/>

			<table width='600'>
				<tr>
					<td align='center' width='50%'>
						________________________________
						<br/>
						<b>CONTRATADA ADMINISTRADORA</b>
						<br/>
						<b>TABAKAL</b> Emp. Imobili�rios Ltda. 
						<br/>
						CNPJ/MF n� 06.864.021/0001-31
					</td>
				</tr>
			</table>
			<br/>
			<br/>
			<br/>

			Testemunhas:
			<br/>
			<br/>
			<br/>

			<table width='600'>
				<tr>
					<td align='center' width='50%'>
						________________________________
						<br/>
						Aur�lio Magno da Fonseca Pinto
						<br/>
						CPF n� 444.079.121-20	
					</td>
					<td align='center' width='50%'>
						________________________________
						<br/>
						
						<br/>
						CPF n�:
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>


<?php

}else{
	header('location:login.php');
}	
?>