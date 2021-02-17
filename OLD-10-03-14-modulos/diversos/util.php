<?php
// Fun��o que valida o CPF
function validaCPF($cpf)
{	// Verifiva se o n�mero digitado cont�m todos os digitos
	//$cpf = str_pad(ereg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);
	
	

	// Verifica se nenhuma das sequ�ncias abaixo foi digitada, caso seja, retorna falso
	if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999'){
		return false;
	}
	else{   // Calcula os n�meros para verificar se o CPF � verdadeiro
		for ($t = 9; $t < 11; $t++) {
			for ($d = 0, $c = 0; $c < $t; $c++) {
				$d += $cpf{$c} * (($t + 1) - $c);
			}

			$d = ((10 * $d) % 11) % 10;

			if ($cpf{$c} != $d) {
				return false;
			}
		}

		return true;
	}
}

function extenso($valor, $maiusculas,$moeda,$np)
//$maiusculas true para definir o primeiro caracter
//$moeda true para definir se escreve Reais / Centavos para usar com numerais simples ou monetarios
{
	// verifica se tem virgula decimal
	if (strpos($valor,",") > 0)
	{
	    // retira o ponto de milhar, se tiver
	    $valor = str_replace(".","",$valor);

	    // troca a virgula decimal por ponto decimal
	    $valor = str_replace(",",".",$valor);
	}

	if(!$moeda)
	{
		$singular  = array("", "", "mil", "milh�o", "bilh�o", "trilh�o", "quatrilh�o");
		$plural = array("", "", "mil", "milh�es", "bilh�es", "trilh�es","quatrilh�es");
	}
	else
	{
		$singular = array("centavo", "real", "mil", "milh�o", "bilh�o", "trilh�o", "quatrilh�o");
		$plural = array("centavos", "reais", "mil", "milh�es", "bilh�es", "trilh�es","quatrilh�es");
	}

	$c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
	$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
	$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");

	if(!$moeda) // se for usado apenas para numerais
	{
	    if($np)
		$u = array("", "uma", "dois", "tr�s", "quatro", "cinco", "seis","sete", "oito", "nove");
	    else
		$u = array("", "uma", "duas", "tr�s", "quatro", "cinco", "seis","sete", "oito", "nove");
	}
	else
	{
	    $u = array("", "um", "dois", "tr�s", "quatro", "cinco", "seis","sete", "oito", "nove");
	}
	$z=0;
	$rt = "";
	$valor = number_format($valor, 2, ".", ".");
	$inteiro = explode(".", $valor);
	for($i=0;$i<count($inteiro);$i++)
		for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
			$inteiro[$i] = "0".$inteiro[$i];

			$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
				for ($i=0;$i<count($inteiro);$i++) {
					$valor = $inteiro[$i];
					$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
					$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
					$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

					$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
					$t = count($inteiro)-1-$i;
					$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
					if ($valor == "000")$z++; elseif ($z > 0) $z--;
					if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
					
					if ($r)	$rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
				}

	if(!$maiusculas){
		return($rt ? $rt : "zero");
	} else {
		return (ucwords($rt) ? ucwords($rt) : "Zero");
	}

}

function mascaraCpf($cpf){
    return substr($cpf, 0, 3).'.'.substr($cpf, 3, 3).'.'.substr($cpf, 6, 3).'-'.substr($cpf, 9);
}

function mascaraCep($cep){
    return substr($cep, 0, 5).'-'.substr($cep, 5);
}

?>