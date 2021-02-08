<?php
	include("../../conexao/conexao.php");
header('Content-Type: text/html; charset=iso-8859-1');
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<style type="text/css">
body{
	margin: 0px;
	font-family: arial;
	font-size: 11px;
}

#iframe{
	border: 0px;
	padding: 5px;
}

.negrito{
	font-weight: bold;
}

table{
	font-size: 11px;
}
</style>
</head>
<body>
	<div id="iframe">
		<?php
			global $mySQLAlert;

			$sql     = sprintf("call procPessoaAniversarioDiaListar()");
			$rs      = $mySQL->runQuery($sql);
			$rsQuant = $rs->num_rows;
		
			if($rsQuant>0){

		?>	
				<span class="negrito">A(s) pessoa(s) abaixo est�o fazendo anivers�rio hoje:</span>
				<br/>
				<br/>
				<table>

		<?php
					while ($linha = mysqli_fetch_assoc($rs)) {
		?>
						<tr>
							<td><img src='../../img/ic_estrela.png' /></td>
							<td>
								<span class="negrito"> Nome:</span> <?php echo utf8_decode($linha["nome"]); ?><br/>
								<span class="negrito">Data de Nascimento:</span> <?php echo  $linha["dataNascimento"]; ?>
							</td>
						</tr>
		<?php
					}
		?>
				</table>				
		<?php
			}
		?>

		
	</div>
</body>
</html>