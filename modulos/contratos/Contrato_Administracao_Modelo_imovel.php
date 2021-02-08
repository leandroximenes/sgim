<?php
session_start();
header('Content-Type: text/html; charset=iso-8859-1');

header("Content-type: application/vnd.ms-word");
header("Content-type: application/force-download");
header("Content-Disposition: attachment; filename=contrato_administracao_modelo.doc");
header("Pragma: no-cache");

$titulo = 'COntrato de administra��o';

if (isset($_SESSION["SISTEMA_codPessoa"])) {

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
    $enderecoImovel = $rsLinha['endereco'];
    $bairroImovel = $rsLinha['bairro'];
    $cidadeImovel = $rsLinha['cidade'];
    $ufImovel = $rsLinha['uf'];
    $cepImovel = mascaraCep($rsLinha['cep']);
    $codProprietario = $rsLinha['codProprietario'];
    $valor = $rsLinha['valor'];
    $intermediacao = $rsLinha['intermediacao'];

    $sql = sprintf("CALL procPessoaListarUnico($codProprietario)");
    $rsLocatorio = $mySQL->runQuery($sql);
    $rsLocatarioLinha = mysqli_fetch_assoc($rsLocatorio);
    
    utf8_decode_array($rsLocatarioLinha);
    
    $nomeLocatario = ($rsLocatarioLinha['nome']);
    $emailProprietario = ($rsLocatarioLinha['email']);
    $profissao = ($rsLocatarioLinha['profissao']);
    $cpf = mascaraCpf($rsLocatarioLinha['cpf']);
    $rg = number_format($rsLocatarioLinha['rg'], 0, ',', '.');
    $orgaoExpedidor = $rsLocatarioLinha['orgaoExpedidor'];
    $enderecoLocatario = $rsLocatarioLinha['endereco'];
    $bairroLocatario = $rsLocatarioLinha['bairro'];
    $cidadeLocatario = $rsLocatarioLinha['cidade'];
    $cepLocatario = mascaraCep($rsLocatarioLinha['cep']);
    $nacionalidade = $rsLocatarioLinha['nacionalidade'];

    $sqlTelefone = sprintf("CALL procPessoaTelefoneListar($codProprietario)");

    $rsTelefone = $mySQL->runQuery($sqlTelefone);

    $sqlBanco = sprintf("CALL procPessoaDadoBancarioListar($codProprietario)");
    $rsBanco = $mySQL->runQuery($sqlBanco);
    $rsBancoLinha = mysqli_fetch_assoc($rsBanco);
    utf8_decode_array($rsBancoLinha);

    $banco = ($rsBancoLinha['banco']);
    $agencia = $rsBancoLinha['agencia'];
    $conta = $rsBancoLinha['conta'];
    $observacao = ($rsBancoLinha['observacao']);

    //se existir conjuge ele lista!
    $sqlConjuge = sprintf("CALL procPessoaConjugeListar($codProprietario)");
    $rsConjugeLocatario = $mySQL->runQuery($sqlConjuge);


    $rsLocatarioConjugeLinha = mysqli_fetch_assoc($rsConjugeLocatario);
    $conjugeLocatarioNome = ($rsLocatarioConjugeLinha['nome']);
    $conjugeLocatarioRg = number_format((int)str_replace('.', '', str_replace('-', '', $rsLocatarioConjugeLinha['rg'])), 0, ',', '.');
    $conjugeLocatarioOrgaoExpedidor = $rsLocatarioConjugeLinha['orgaoExpedidor'];
    $conjugeLocatarioCpf = mascaraCpf($rsLocatarioConjugeLinha['cpf']);
    $conjugeLocatarioProfissao = $rsLocatarioConjugeLinha['profissao'];
    $conjugeLocatarioNacionalidade = $rsLocatarioConjugeLinha['nacionalidade'];

    if ($conjugeLocatarioNome != "") {
        $strConjugeListar = ' casado(a) com ' . $conjugeLocatarioNome . ', ' . ($conjugeLocatarioNacionalidade) . ', portador(a) da carteira de identidade ' . $conjugeLocatarioRg . ' ' . $conjugeLocatarioOrgaoExpedidor . ', inscrito(a) no CPF sob n� ' . $conjugeLocatarioCpf . ',';
    } else {
        $strConjugeListar = "";
    }
    //fim
    ?>

    <table border='0' width='600' cellpadding='0' cellspacing='0'>
        <tr>
            <td colspan='2'>
        <center><b style='font-size:18.5px'><u>CONTRATO DE ADMINISTRA��O DE IM�VEL</u></b></center>
        
        <br/>

        <div class="clJustificar">
            <b>Contrato de Administra��o de Im�vel </b>que fazem entre si, <?php echo $nomeLocatario . ", " . $nacionalidade . "(a), " . $profissao . ", " ?> 
            portador(a) da carteira de identidade <?php echo $rg . ' ' . $orgaoExpedidor . ", "; ?>	inscrito(a) no CPF sob n� <?php echo $cpf; ?>, 
            <?php if ($strConjugeListar != "") {
                echo $strConjugeListar;
            } ?>  
            residente(s) e domiciliado(a)(s)  no(a) 
            <?php
            echo $enderecoLocatario . " - " . $bairroLocatario . " - " . $cidadeLocatario . " - CEP: " . $cepLocatario;
            echo " Fones: "
            ?>
            <?php
            while ($linhaTelefone = mysqli_fetch_assoc($rsTelefone)) {

                $mystring = $linhaTelefone['telefone'];
                //$findme   = '________';
                //$pos = strpos($mystring, $findme);
                //if(!$pos){
                echo mascaraTel($mystring);
                //}
            }
            ?>e <b>TABAKAL</b> Empreendimentos Imobili�rios Ltda., inscrita no CNPJ/MF sob o n� 06.864.021/0001-31 e Inscri��o CF/DF 
            n� 07.457.662/001-02 - Bras�lia-DF, e no Conselho Regional de Corretores de Im�veis - CRECI, sob o n� 9508, representada 
            pela corretora de im�veis MARLEIDE DE ARAUJO TELES, CRECI/DF 8091, aqui denominados, respectivamente, 
            CONTRATANTE(S) LOCADOR(ES)(A) e CONTRATADA ADMINISTRADORA, mediante as seguintes condi��es:
        </div>
        <br />		
        <div class="clJustificar">
            <b>CL�USULA PRIMEIRA - </b>
            O(s)(A) Contratante(s) Locador(es)(a) ajusta(m) com a Contratada Administradora a administra��o de um im�vel situado no(a) <b> 
                <?php echo $enderecoImovel . ' - ' . $bairroImovel . ' - ' . ($cidadeImovel) . "-" . $ufImovel . " - CEP: " . $cepImovel; ?></b>, 
                tudo de conformidade com os termos da procura��o anexa, que passa a fazer parte integrante deste instrumento. 
        </div>
        <br/>
        <div class="clJustificar">
            <b>CL�USULA SEGUNDA - </b>
            � Contratada Administradora � facultada, sob sua inteira responsabilidade, a escolha do(a) locat�rio(a) e das garantias 
            fidejuss�rias que ele prestar, estabelecendo as condi��es do contrato de loca��o que em nome do(s)(a) Contratante(s) Locador(es)(a) firmar�, 
            observando a legisla��o pertinente, e obviamente, seus interesses.
        </div>
        <br/>
        <div class="clJustificar">
            <b>CL�USULA TERCEIRA - </b>
            O valor do contrato de loca��o inicial a ser celebrado ser� de 
            R$ <?php echo number_format($valor, 2, ',', '.'); ?> (<?php echo extenso($valor, false, true, true); ?>), reajust�veis a cada 12 (doze) meses, de acordo com o IGPM/FGV. 
            Fica consignado que correr� por conta do(a) locat�rio(a) os encargos de �gua, luz, seguro de inc�ndio, telefone, IPTU/TLP e condom�nio. 
        </div>
        <br/>
        <div class="clJustificar">
            <b>CL�USULA QUARTA - </b>
            A Contratada Administradora prestar� assist�ncia advocat�cia ao(s)(�) Contratante(s) Locador(es)(a), defendendo todos seus direitos, 
            especificamente no que diz respeito � loca��o e acess�rios do im�vel ora administrado.
        </div>
        <br/>
        <div class="clJustificar">
            <b>Par�grafo �nico � </b>As despesas judiciais e os honor�rios advocat�cios estranhos ao contrato de loca��o e seus acess�rios correr�o por conta do(s)(a) Contratante(s) Locador(es)(a).
        </div>
        <br/>
        <div class="clJustificar">
            <b>CL�USULA QUINTA - </b>
            A Contratada Administradora, na hip�tese de n�o pagamento do(a) locat�rio(a), efetuar� �s custas do(s)(a) Contratante(s) 
            Locador(es)(a) os pagamentos dos impostos, taxas, condom�nios e outros encargos pertinentes ao im�vel e � sua loca��o; e as demais despesas decorrentes, 
            bem como as de reparos e pintura que se fizerem necess�rias, cobrando-os do(a) locat�rio(a) e seu(s) fiador(a)(es) o que for de obriga��o destes.
        </div>			
        <br/>
        <div class="clJustificar">
            <b>Par�grafo �nico - </b>
            As despesas com an�ncios em jornais, internet, que ser�o feitos a crit�rio da Contratada Administradora, se houver rescis�o de 
            administra��o antes do im�vel ser locado, correr�o por conta do(s)(a) Contratante(s) Locador(es)(a).
        </div>			
        <br/>
        <div class="clJustificar">		
            <b>CL�USULA SEXTA - </b>
            A Contratada Administradora far� jus, a t�tulo de remunera��o pelos servi�os que prestar ao(s)(�) Contratante(s) Locador(es)(a), a comiss�o de 10% 
            (dez por cento) do valor dos alugu�is l�quidos recebidos do(a) locat�rio(a), e ser� esta descontada na presta��o mensal de contas, contra recibo.<br/><br/>

            <?php if($intermediacao > 0): 
                $importancia = $intermediacao + 10;
                ?>
            
           <b>Par�grafo �nico</b> � Ser� descontada do primeiro aluguel e em todo novo contrato de loca��o a import�ncia correspondente a <?= $importancia ?>% (<?php echo extenso($importancia, false, false, true); ?> por cento) do valor 
           do aluguel, sendo <?= $intermediacao ?>% (<?php echo extenso($intermediacao, false, false, true); ?> por cento) de taxa de intermedia��o e 10% (dez por cento) de taxa de administra��o. A taxa de intermedia��o refere-se a despesas 
           de aferi��o da idoneidade do pretendente e fiadores, vistoria, visitas ao im�vel, an�ncios e outras necess�rias a promo��o da loca��o (art.22 - item VII- lei 8.245/91), 
           conforme resolu��o COFECI no 334/92 e Tabela Referencial de Valores aprovada pelo CRECI/DF, na XIX a Sess�o Plen�ria, em 23.11.96. 
            <?php endif;?>

        </div>			
        <br/>
        <div class="clJustificar">					
            <b>CL�USULA S�TIMA - </b>
            O(s)(A) Contratante(s) Locador(es)(a) estipula(m) que tem interesse em receber da Contratada Administradora o aluguel l�quido 
            conforme a seguir: Dep�sito Banc�rio no <?php echo $banco; ?>  - Ag�ncia: <?php echo $agencia . " - "; ?> Conta Corrente 
                <?php echo $conta . " -  Favorecido(a): <b>" . $observacao; ?></b>.
        </div>			
        <br/>
        <div class="clJustificar">		
            <b>CL�USULA OITAVA - </b>
            A Contratada Administradora colocar� � disposi��o do(s)(o) Contratante(s) Locador(es)(a) o valor l�quido referente ao aluguel at� o quinto dia �til, 
            a contar da data do efetivo recebimento do aluguel. Mensalmente a  Contratada Administradora enviar� ao e-mail  <b>
                <?php echo strtolower($emailProprietario); ?></b>, extrato com cr�ditos e d�bitos relativos � loca��o.
        </div>			
        <br/>
        <div class="clJustificar">		
            <b>CL�USULA NONA - </b>
            A Contratada Administradora ficar� desobrigada de efetuar o pagamento do aluguel ao(s)(�) Contratante(s) Locador(es)(a) se este n�o for pago pelo(a) 
            locat�rio(a) em caso de desapropria��o, interdi��o, venda ou penhora, arresto ou seq�estro do im�vel, calamidade p�blica e guerra, quando ajuizada a��o 
            de retomada, ou ainda, quando por qualquer motivo o(s)(a) Contratante(s) Locador(es)(a) der(em) causa a que o(a) locat�rio(a) retenha o pagamento.
        </div>			
        <br/>
        <div class="clJustificar">		
            <b>CL�USULA D�CIMA - </b>
            N�o efetuado o pagamento do aluguel pelo(a) locat�rio(a) e necessitando a Contratada Administradora promover a cobran�a amig�vel e/ou judicial contra o 
            mesmo n�o poder�(�o) o(s)(a) Contratante(s) Locador(es)(a), em hip�tese alguma, revogar(em) a procura��o que �quela outorgou(aram), nem tampouco obstar(em), 
            por qualquer forma, os procedimentos judiciais que ser�o promovidos, sob pena de ficar(em) sujeito(s) o(s)(a) Contratante(s) Locador(es)(a) ao pagamento de 
            uma indeniza��o equivalente ao montante do que esteja sendo exigido do(a) locat�rio(a) em Ju�zo.
        </div>			
        <br/>
        <div class="clJustificar">					
            <b>CL�USULA D�CIMA PRIMEIRA � </b>
            Ao(s)(�) Contratante(s) Locador(es)(a) caber�o os juros, a corre��o monet�ria e as multas cobradas do(a) locat�rio(a). 
            Sobre tais verbas ser�o devidos � Contratada Administradora, o percentual de comiss�o, na forma pactuada na <b>CL�USULA SEXTA</b>.
        </div>			
        <br/>
        <div class="clJustificar">			
            <b>Par�grafo Primeiro - </b> Caso o pagamento do aluguel n�o seja efetuado pelo(a) locat�rio(a) na data de vencimento e havendo repasse do valor ao(s)(�) 
            Contratante(s) Locador(es)(a) at� o quinto dia �til, a contar da data de seu vencimento, pela Contratada Administradora, a esta caber�o o valor principal, os juros, a corre��o monet�ria e as multas cobradas do(a) locat�rio(a). O pagamento � uma delibera��o da Contratada Administradora, n�o constituindo nova��o da Contratada Administradora o dep�sito do valor do aluguel n�o pago ao(s)(�) Contratante(s) Locador(es)(a).
        </div>
        <br/>

        <div class="clJustificar">			
            <b>Par�grafo Segundo - </b>
            A Contratada Administradora, mediante consentimento do(s)(a) Contratante(s) Locador(es)(a), promover� a cobran�a ou n�o da multa de rescis�o contratual 
            estipulada no contrato de loca��o firmado com o(a) locat�rio(a).
        </div>

        <br/>
        <div class="clJustificar">							
            <b>CL�USULA D�CIMA SEGUNDA - </b>
            A Contratada Administradora mediante autoriza��o do(s)(a) Contratante(s) Locador(es)(a) celebrar� novo contrato de loca��o, por prazo id�ntico ou diverso, 
            se a loca��o em curso vier a ser rescindida antes do prazo previsto, seja amig�vel ou judicialmente.
        </div>			
        <br/>
        <div class="clJustificar">							
            <b>Par�grafo �nico - </b>
            Ocorrendo � hip�tese prevista no caput desta Cl�usula, se obriga a Contratada Administradora dar ci�ncia ao(s)(�) Contratante(s) Locador(es)(a), 
            tudo com vistas a ser ajustado novo pre�o e anu�ncia quanto ao novo prazo da loca��o.
        </div>			
        <br/>
        <div class="clJustificar">							
            <b>CL�USULA D�CIMA TERCEIRA - </b>
            Ao(s)(�) Contratante(s) Locador(es)(a) ser� defeso celebrar acordos com locat�rio(a) sem expressa anu�ncia escrita da Contratada Administradora, 
            assim como ingerir na administra��o do im�vel, sob pena de multa equivalente ao valor de 01 (um) m�s de aluguel conforme disposto na <b>CL�USULA TERCEIRA.</b>
        </div>			
        <br/>
        <div class="clJustificar">							
            <b>CL�USULA D�CIMA QUARTA - </b>Na vig�ncia do presente contrato de administra��o, caso seja autorizada a venda pelo(s)(a) Contratante(s) Locador(es)(a), fica desde j� a Contratada Administradora, nomeada a intermediadora da venda do im�vel em quest�o, fazendo jus, portanto, � comiss�o equivalente a 5% (cinco por cento) sobre o valor da transa��o.
        </div>			
        <br/>
        <div class="clJustificar">							
            <b>CL�USULA D�CIMA QUINTA - </b>O presente contrato de Administra��o � celebrado por prazo id�ntico ao contrato de loca��o a ser celebrado e somente poder� ser rescindido nas seguintes condi��es:
        </div>			
        <br/>
        <div class="clJustificar">							
            a) - Por justa causa, caso a Contratada Administradora, sem qualquer justificativa v�lida, deixe de prestar contas do aluguel, se recebido do(a) locat�rio(a),
            ap�s o prazo de car�ncia, salvo motivo de for�a maior, tais como greve banc�ria, calamidade p�blica, etc. Nestas circunst�ncias nada ser� devido de comiss�o �
            Contratada Administradora, exigindo-se apenas se notifique extrajudicialmente a Contratada Administradora, a fim de que se proceda administrativamente � 
            rescis�o do presente contrato, sob pena de n�o o fazendo ser feita judicialmente. 
        </div>			
        <br/>
        <div class="clJustificar">							
            b) - Sem justa causa, devendo ser precedida de notifica��o com anteced�ncia m�nima de <b>90 (noventa)</b> dias do vencimento do contrato locat�cio, caso pretenda(m) o(s)(a) Contratante(s) Locador(es)(a) retirar(em) o im�vel da Administra��o da Contratada Administradora, ap�s o vencimento do contrato locat�cio. Neste caso, arcar�(�o) o(s)(a) Contratante(s) Locador(es)(a) com o pagamento da comiss�o imobili�ria pactuada na <b>CL�USULA SEXTA</b>, calculada sobre os meses restantes at� o t�rmino do contrato locat�cio ou, na aus�ncia da notifica��o no prazo previsto, o equivalente a um m�s de aluguel.
        </div>			
        <br/>
        <div class="clJustificar">							
            <b>Par�grafo �nico - </b>Se a Contratada Administradora, sem motivo justificado, rescindir o presente contrato de Administra��o, se obrigar� igualmente ao pagamento da multa correspondente a comiss�o imobili�ria pactuada na CL�USULA SEXTA, calculada sobre os meses restantes at� o t�rmino do contrato locat�cio, ou na aus�ncia de notifica��o no prazo previsto, o equivalente a um m�s de aluguel.
        </div>			
        <br/>
        <div class="clJustificar">											
            <b>CL�USULA D�CIMA SEXTA - </b>Rescindido este contrato, ficar� sem efeito a procura��o referida na <b>CL�USULA PRIMEIRA</b>, outorgada pelo(s)(a) Contratante(s) Locador(es)(a) � Contratada Administradora.
        </div>			
        <br/>
        <div class="clJustificar">															
            <b>CL�USULA D�CIMA SETIMA - </b>Elegem os contratantes o foro da Circunscri��o Judici�ria de Bras�lia-DF, com exclus�o de qualquer outro, para que sejam dirimidas as quest�es oriundas deste contrato.
        </div>			
        <br/>
        <br/>
        <br/>		
        <div style="text-align: center"> <!-- data-->
            <?php
            $dia = date("d");
            $mess = date("m");
            $ano = date("y");

            switch ($mess) {
                case "01": $mes = "Janeiro";
                    break;
                case "02": $mes = "Fevereiro";
                    break;
                case "03": $mes = "Mar�o";
                    break;
                case "04": $mes = "Abril";
                    break;
                case "05": $mes = "Maio";
                    break;
                case "06": $mes = "Junho";
                    break;
                case "07": $mes = "Julho";
                    break;
                case "08": $mes = "Agosto";
                    break;
                case "09": $mes = "Setembro";
                    break;
                case "10": $mes = "Outubro";
                    break;
                case "11": $mes = "Novembro";
                    break;
                case "12": $mes = "Dezembro";
                    break;
            }

            echo 'Bras�lia-DF, ' . $dia . ' de ' . $mes . ' de 20' . $ano .'.';
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
                if ($conjugeLocatarioNome != "") {
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

        <b>Testemunhas:</b>
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
                    L�gia de Lima Paz
                    <br/>
                    CPF n� 919.484.601-49
                </td>
            </tr>
        </table>
    </td>
    </tr>
    </table>


    <?php
} else {
    header('location:login.php');
}
?>