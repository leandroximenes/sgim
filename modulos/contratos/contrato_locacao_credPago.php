<?php
error_reporting(E_ALL);
ini_set("display_errors", 0);
session_start();
header('Content-Type: text/html; charset=iso-8859-1');

header("Content-type: application/vnd.ms-word");
header("Content-type: application/force-download");
header("Content-Disposition: attachment; filename=contrato_locacao_cred_pago.doc");
header("Pragma: no-cache");

$titulo = 'Relat�rio de Aniversariantes';

if (isset($_SESSION["SISTEMA_codPessoa"])) {

    include("../../conexao/conexao.php");
    include("../../php/php.php");
    include("../diversos/util.php");

    global $mySQL;
    $codContrato = $_GET['codContrato'];
    $sql = sprintf("CALL procContratoUnicoListar($codContrato)");
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

        p.quebra    { 
            page-break-before: always 
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
    $cidadeImovel = $rsLinha['cidade'];
    $ufImovel = $rsLinha['uf'];
    $cep = $rsLinha['cep'];
    $bairroImovel = $rsLinha['bairro'];
    $codLocatario = $rsLinha['codContratante'];
    $dataInicio = $rsLinha['dataInicio'];
    $dataFim = $rsLinha['dataFim'];
    $valor = $rsLinha['valor'];
    $descontoPontualidade = floatval($rsLinha['descontoPontualidade']);
    $qtdMeses = $rsLinha['qtdMeses'];
    ?>



    <table border='0' width='600' cellpadding='0' cellspacing='0'>
        <tr>
            <td colspan='2'>
        <center><b style='font-size:18.5px'><u>CONTRATO DE LOCA��O DE IM�VEL RESIDENCIAL</u></b></center>
        

        <div style="page-break-before: always">

            <b><p>A - IM�VEL:</b> <?php echo $enderecoImovel . ' - ' . $bairroImovel . ' - ' . $cidadeImovel . ' - ' . $ufImovel . ' - CEP: ' . mascaraCep($cep); ?></p>
            <br/>
            <br/>
            <div class="clJustificar">
                <p><b>B � ADMINISTRADORA: TABAKAL</b> EMPREENDIMENTOS IMOBILI�RIOS LTDA., inscrita no CNPJ/MF 06.864.021/0001-31, CRECI/DF 9508, estabelecida no CLN 309, Bloco D, n� 50, Salas 104/105, nesta Capital, representada legalmente pela corretora de im�veis MARLEIDE DE ARA�JO TELES, brasileira, residente e domiciliada nesta capital, inscrita no CRECI/DF n� 8091. 
            </p></div>
            <br/>
            <?php
            $sql = sprintf("CALL procPessoaListarUnico($codLocatario)");
            $rsLocatorio = $mySQL->runQuery($sql);
            $rsLocatarioLinha = mysqli_fetch_assoc($rsLocatorio);
            utf8_decode_array($rsLocatarioLinha);

            $nomeLocatario = $rsLocatarioLinha['nome'];
            $profissao = $rsLocatarioLinha['profissao'];
            $cpf = mascaraCpf($rsLocatarioLinha['cpf']);
            $rg = number_format($rsLocatarioLinha['rg'], 0, ',', '.');
            $orgaoExpedidor = $rsLocatarioLinha['orgaoExpedidor'];
            $enderecoLocatario = $rsLocatarioLinha['endereco'];
            $bairroLocatario = $rsLocatarioLinha['bairro'];
            $cidadeLocatario = $rsLocatarioLinha['cidade'];
            $ufLocatario = $rsLocatarioLinha['uf'];
            $cepLocatario = mascaraCep($rsLocatarioLinha['cep']);
            $nacionalidade = $rsLocatarioLinha['nacionalidade'];
            

            //se existir conjuge ele lista!
            $sqlConjuge = sprintf("CALL procPessoaConjugeListar($codLocatario)");
            $rsConjugeLocatario = $mySQL->runQuery($sqlConjuge);
            $rsLocatarioConjugeLinha = mysqli_fetch_assoc($rsConjugeLocatario);
            utf8_decode_array($rsLocatarioConjugeLinha);

            $conjugeLocatarioNome = $rsLocatarioConjugeLinha['nome'];
            $conjugeLocatarioRg = number_format((int) str_replace('.', '', $rsLocatarioConjugeLinha['rg']), 0, ',', '.');
            $conjugeLocatarioCpf = mascaraCpf($rsLocatarioConjugeLinha['cpf']);
            $conjugeLocatarioOrgaoExpedidor = $rsLocatarioConjugeLinha['orgaoExpedidor'];
            $conjugeLocatarioProfissao = $rsLocatarioConjugeLinha['profissao'];
            $conjugeLocatarioNacionalidade = $rsLocatarioConjugeLinha['nacionalidade'];

            $strConjugeListar = '';
            if (!empty($conjugeLocatarioNome)) {
                $strConjugeListar = ' casado(a) com <b>' . $conjugeLocatarioNome . '</b>, ' . ($conjugeLocatarioNacionalidade) . '(a), portador(a) da carteira de identidade ' . $conjugeLocatarioRg . ' ' . $conjugeLocatarioOrgaoExpedidor . ', inscrito(a) no CPF sob n�  ' . $conjugeLocatarioCpf . ',';
            }else{
               
               //$strConjugeListar = $rsLocatarioLinha['estadoCivil'] . '(a),' ;

            }

            //fim
            ?>
            <div class="clJustificar">
                <p><b>C - LOCAT�RIO(S)(A): <?php echo ($nomeLocatario); ?></b>, <?php echo ($nacionalidade); ?>(a), <?php echo $profissao; ?>, portador(a) da carteira de identidade <?php echo $rg . ' ' . $orgaoExpedidor; ?>, inscrito(a) no CPF sob n� <?php echo $cpf; ?>, <?php echo $strConjugeListar; ?> residente(s) e domiciliado(a)(s) no(a) <?php echo ($enderecoLocatario); ?> - <?php echo ($bairroLocatario) . " - " . $cidadeLocatario . "-" . $ufLocatario; ?> � CEP: <?php echo $cepLocatario; ?>.
            </p></div>
            <br/>
            <div class="clJustificar">
                <p><b>D � PRAZO:</b> <?php echo $qtdMeses; ?> (<?php echo str_replace(' reais', '',  extenso($qtdMeses, false, true, true)); ?>) meses, 
                com in�cio em <?php echo $dataInicio; ?> e t�rmino em <?php echo $dataFim; ?>. 
                Ocorrendo prorroga��o contratual, tornando-se a aven�a por prazo indeterminado, 
                responde(m) o(s)(a) LOCAT�RIO(S)(A) e fiador(es) nos termos ora pactuados at� a efetiva devolu��o do im�vel.</p>
            </div>
            <br/>
            <div class="clJustificar">
                <p><b>E � ALUGUEL MENSAL INICIAL:</b> R$ <?php echo number_format($valor, 2, ',', '.'); ?> 
                (<?php echo extenso($valor, false, true, true); ?>), com desconto de pontualidade de 
                R$ <?php echo number_format($descontoPontualidade, 2, ',', '.'); ?> 
                (<?php echo extenso($descontoPontualidade, false, true, true); ?>).
            </p></div>
            <br/>
            <div>
                <p><b>F � PRAZO DE REAJUSTE:</b> Anual, com base no IGPM/FGV.</p>
            </div>
            <br/>
            <div>
                <p><b>G � USO DO IM�VEL:</b> Residencial.<br/></p>
            </div>

        </div>

        <div class="clJustificar">
        <p>
            Os signat�rios deste instrumento, de um lado a ADMINISTRADORA, indicado na al�nea �B� acima, e de outro lado o(s)(a) LOCAT�RIO(S)(A), indicado(s)(a) na al�nea �C�, contrata(m) a loca��o do im�vel (Residencial) mencionado na al�nea �A�, sob as seguintes cl�usulas e condi��es:</p>
        </div>
        
        
        <b>CL�USULA I � DO PRAZO</b>
        <br/>
        <br/>
        <div class="clJustificar">
            O prazo do presente contrato de loca��o � o determinado na al�nea ?D?, com seu t�rmino tamb�m fixado na mesma al�nea, independentemente de qualquer aviso, interpela��o judicial ou extrajudicial, n�o se havendo como presumida a falta de oposi��o da ADMINISTRADORA o fato de findo o prazo estipulado, continuar(em) o(s)(a) LOCAT�RIO(S)(A) na posse do im�vel, por qualquer motivo. 
        </div>

        <br/>
        <div class="clJustificar">
        <b>Par�grafo Primeiro:</b> Estabelece-se que ap�s o transcurso de 12 (doze) meses da vig�ncia do contrato, caso haja interesse por parte do(s)(a) LOCAT�RIO(S)(A) na devolu��o do im�vel, poder�(�o) faz�-lo sem o pagamento da multa de que trata a Cl�usula V, desde que notifique(m) sua inten��o a ADMINISTRADORA com anteced�ncia m�nima de 30 (trinta) dias para a devolu��o do im�vel. <b>Caso ocorra a devolu��o anterior aos 30(trinta) dias, arcar� o locat�rio com custos da loca��o e seus acess�rios at� o final do prazo do aviso. Se ultrapassado os 30(trinta) dias, o aluguel e acess�rios ser�o calculados proporcionalmente aos dias excedidos. Caso ocorra a devolu��o anterior ao per�odo de 12 (doze) meses o(s)(a) LOCAT�RIO(S)(A) pagar�(�o) a multa pactuada na Cl�usula V proporcional aos meses faltantes.</b>
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo Segundo:</b> Caso ocorra prorroga��o autom�tica da aven�a, ser�o mantidas todas as cl�usulas e condi��es ora estabelecidas.
        </div>
        <br/>
        
        <b>CL�USULA II � DO ALUGUEL</b>
        <br/>
        <br/>
        <div class="clJustificar">
            O aluguel mensal do im�vel, venc�vel no dia <?php echo substr($dataInicio, 0, 2); ?> de cada m�s civil correspondente, ser� pago pelo(s)(a) LOCAT�RIO(S)(A) independente de qualquer aviso, atrav�s de boleto banc�rio emitido pela administradora.
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo Primeiro:</b> O reajuste do aluguel pactuado na al�nea �E� ocorrer� de acordo com a varia��o acumulada do IGPM/FGV, apurada a cada 12 (doze) meses considerando-se o acumulado no m�s anterior ao do reajuste - e excluindo-se eventuais contagens pro rata die do �ndice mencionado que se vinculem � data da assinatura do contrato -, ou na menor periodicidade que permitir a legisla��o, sendo o novo valor do aluguel processado e cobrado automaticamente, independente de qualquer notifica��o ou aviso.
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo Segundo:</b> Na hip�tese de n�o publica��o, extin��o ou suspens�o do �ndice de atualiza��o monet�ria eleito neste contrato (IGPM/FGV), o reajuste do aluguel permanecer� em pleno vigor, sendo regulado, na seguinte ordem de seq��ncia de �ndices: a) IGP - DI/FGV b) IPC/FIPE c) IPC/BRASIL/FGV d) IPC/DIEESE.
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo Terceiro:</b> Ocorrendo a extin��o do �ndice aplic�vel para o reajuste do aluguel mencionado no Par�grafo Primeiro e dos demais �ndices substitutivos mencionados no Par�grafo Segundo, ser�o adotados os �ndices m�ximos que a lei indicar em substitui��o, e na falta deste, ser� utilizada a varia��o de mercado havida no per�odo.
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo Quarto:</b> Em caso de atraso no pagamento do aluguel, haver� cobran�a de multa morat�ria de 10% (dez por cento) e juros de mora de 1% (um por cento) ao m�s. Se a cobran�a for requerida por interm�dio de processo judicial, incidir� sobre o d�bito, multa morat�ria de 2% (dois por cento), juros de mora de 1% (um por cento); e honor�rios de 20% (vinte por cento) (parte final da al�nea �d�, inc II, do art. 62, da Lei 8.245/91).
        </div>

        <br/>
        <b>CL�USULA III � DOS ENCARGOS</b>
        <br/>
        <br/>
        <div class="clJustificar">
            Al�m do aluguel mensal, o(s)(a) LOCAT�RIO(S)(A) pagar�(�o) o IPTU/TLP, despesas ordin�rias de condom�nio (portaria, �gua, limpeza, jardinagem, etc.), se houver, taxa de religa��o de energia el�trica e �gua � quando tiver dado causa � interrup��o desses servi�os. Os comprovantes de adimplemento destas obriga��es dever�o ser apresentados no ato do pagamento do aluguel.
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo primeiro:</b> Caso o pagamento dos encargos de que trata o caput desta Cl�usula n�o seja efetuado pelo(s)(a) LOCAT�RIO(S)(A) e a cobran�a seja requerida por processo judicial, incidir� sobre o valor do d�bito multa de 2% (dois por cento), juros de mora 1% (um por cento) ao m�s, corre��o monet�ria, e honor�rios advocat�cios de 20% (vinte por cento) sobre o valor da causa. 
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo segundo:</b> Sendo o IPTU/TLP pago em atraso, este ser� cobrado, acrescida de multa e juros determinados pelos �rg�os Governamentais.
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo Terceiro:</b> O descumprimento de qualquer obriga��o contratual por qualquer das partes, que ensejar a interven��o de advogado, os honor�rios advocat�cios, ser�o suportados pela parte contratante que der margem a interfer�ncia do referido profissional � raz�o de 20% (vinte por cento) (parte final da al�nea �d�, inc.II, do art. 62, da Lei 8.245/91).
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo Quarto:</b> O(s)(A) LOCAT�RIO(S)(A) obriga(m)-se a pagar o seguro contra inc�ndio do im�vel locado. O valor segurado dever� ser 120 (cento e vinte) vezes o valor do aluguel, em companhia seguradora de sua livre escolha. O pr�mio do referido seguro se reverter� � ADMINISTRADORA. Obriga(m)-se o(s)(a) LOCAT�RIO(S)(A) em renovar o contrato de seguro anualmente.
        </div>

        <br/>
        <b>CL�USULA IV � TOLER�NCIA</b>
        <br/>
        <br/>

        <div class="clJustificar">
            Caso venha a ser admitida qualquer toler�ncia em favor do(s)(a) LOCAT�RIO(S)(A), no cumprimento das obriga��es pactuadas, tal toler�ncia jamais poder� ser admitida como modifica��o do presente contrato, n�o dando ensejo � nova��o constante do C�digo Civil, permanecendo, a todo tempo, em vigor as cl�usulas do presente, como se nenhum favor houvesse intercorrido.
        </div>

        <br/>
        <b>CL�USULA V � DA RESCIS�O</b>
        <br/>
        <br/>

        <div class="clJustificar">
            Na falta do pagamento pontual do aluguel e demais encargos locat�cios, ou na viola��o de qualquer cl�usula contratual, o presente contrato ser� rescindido de pleno direito, independente de notifica��o, aviso ou interpela��o, obrigando-se o(s)(a) LOCAT�RIO(S)(A) � imediata restitui��o do im�vel inteiramente desocupado, e nas condi��es ajustadas neste instrumento, sujeitando-se a multa compensat�ria de valor correspondente a 03 (tr�s) meses do aluguel em vigor no momento da infra��o. Caso necess�rio � interven��o de advogado, responder�(�o) o(s)(a) LOCAT�RIO(S)(A) pelo pagamento de honor�rios de 20% (vinte por cento) e despesas processuais.
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo �nico:</b> Passando o contrato a viger por prazo indeterminado, e havendo interesse do(s)(a) LOCAT�RIO(S)(A) em rescindi-lo, dever�(�o) notificar seu interesse por escrito � ADMINISTRADORA com anteced�ncia m�nima de 30 (trinta) dias. 
        </div>

        <br/>
        <b>CL�USULA VI � TRANSFER�NCIA E SUBLOCA��O</b>
        <br/>
        <br/>

        <div class="clJustificar">
            O(s)(A) LOCAT�RIO(S)(A) n�o poder�(�o) ceder, mesmo gratuitamente, ou transferir o presente contrato, nem sublocar no todo ou em parte o im�vel locado, podendo apenas ser utilizado pelo(s)(a) LOCAT�RIO(S)(A), e ser� usado unicamente para o fim consignado na al�nea �G� deste instrumento. A infra��o a este dispositivo ensejar� rescis�o contratual nos termos da Cl�usula V.
        </div>

        <br/>
        <b>CL�USULA VII � DA CONSERVA��O</b>
        <br/>
        <br/>

        <div class="clJustificar">
            O(s)(A) LOCAT�RIO(S)(A) declara(m) neste ato haver vistoriado o im�vel objeto desta loca��o, e verificado se encontrar na mais perfeita ordem e condi��es de uso (conforme Laudo de Vistoria anexo que faz parte integrante deste instrumento), em especial quanto � pintura, acabamento, aparelhos sanit�rios e instala��es em geral, tudo em perfeito estado f�sico e de funcionamento. Compromete(m)-se o(s)(a) LOCAT�RIO(S)(A) a restitu�-los nas mesmas condi��es em que os recebeu, exceto desgaste natural pelo seu uso normal, com as ressalvas da cl�usula VIII.
        </div>

        <br/>
        <b>CL�USULA VIII � DA DEVOLU��O</b>
        <br/>
        <br/>

        <div class="clJustificar">
            Finda a loca��o, compromete(m)-se o(s)(a) LOCAT�RIO(S)(A) a devolver(em) o im�vel locado nas mesmas condi��es em que o recebeu: limpo, com pintura nova, vidros e lou�as sanit�rias de modo que possa ser imediatamente realugado, sem despesas para a ADMINISTRADORA. Para tanto, ser� feita uma vistoria antes do encerramento do contrato � que o(s)(a) LOCAT�RIO(S)(A) se obriga(m) em marcar no prazo m�nimo de 05 (cinco) dias e m�ximo de 10 (dez) dias anteriores � devolu��o definitiva do im�vel -, a fim de que o(s)(a) LOCAT�RIO(S)(A) proceda(m) a eventuais reparos necess�rios.
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo Primeiro:</b> Garante-se � ADMINISTRADORA o direito de n�o receber as chaves do im�vel para fins de encerramento da rela��o contratual at� que seja recomposto o im�vel, arcando o(s)(a) LOCAT�RIO(S)(A) com todas as despesas decorrentes, inclusive pelos alugu�is e encargos at� a efetiva libera��o.
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo Segundo:</b> Se a repara��o do im�vel ficar a cargo da ADMINISTRADORA, esta solicitar� 03 (tr�s) or�amentos de pessoas f�sicas ou jur�dicas diferentes, e ordenar� a que se realizem com aquele que apresentar menor pre�o, servindo o recibo, fatura ou nota fiscal para posterior cobran�a da respectiva quantia do(s)(a) LOCAT�RIO(S)(A).
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo Terceiro:</b> No ato de devolu��o definitiva do im�vel, obriga(m)-se o(s)(a) LOCAT�RIO(S)(A) em apresentar o comprovante de desligamento dos servi�os de energia (CEB) e �gua (CAESB), e respectivas certid�es ou declara��es negativas de d�bito emitidas por essas prestadoras de servi�os, al�m de apresentar o nada consta do condom�nio (se for o caso) relativos a todo per�odo de loca��o.
        </div>

        <br/>
        <b>CL�USULA IX � BENFEITORIAS</b>
        <br/>
        <br/>

        <div class="clJustificar">
            � vedado ao(s)(�) LOCAT�RIO(S)(A) erigir qualquer benfeitoria no im�vel objeto deste contrato.
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo �nico:</b> Em caso de inobserv�ncia da proibi��o prevista no caput desta cl�usula, o(s)(a) LOCAT�RIO(S)(A) n�o poder�(�o) exigir indeniza��es pelas benfeitorias que fizer no im�vel, sejam voluptu�rias, �teis ou necess�rias, e caso sejam realizadas, n�o lhe autorizar�o o exerc�cio do direito de reten��o (art. 578 do C�digo Civil), ficando desde logo incorporadas ao im�vel.
        </div>


        <br/>    
        <b>CL�USULA X - DA GARANTIA LOCAT�CIA </b>
        <br/>
        <br/>
        <p>O(A) Locat�rio(a) realizou a contrata��o da CREDPAGO SERVI�OS DE COBRAN�A S/A., pessoa jur�dica de direito privado, inscrita no CNPJ sob o n� 25.027.928/00001-90, com sede na Rua Abraham Lincol n� 263, Semin�rio, Curitiba/PR, a qual, se compromete a efetuar o paga mento de eventuais d�bitos relativos ao aluguel e demais encargos da presente loca��o que venham a ser inadimplidos pelo(a) Locat�rio(a), conforme condi��es e limita��es constantes nos Termos e Condi��es Gerais dos Servi�os CREDPAGO, que integram o presente Contrato como ANEXO I.<br />  As Partes declaram expressamente que est�o cientes de todas as condi��es e limita��es relativos � fian�a prestada pela CREDPAGO SERVI�OS DE COBRAN�A S/A., notadamente no tocante (i) ao valor m�ximo de sua responsabilidade, (ii) �s limita��es de sua responsabilidade, (iii) a o prazo de sua vig�ncia, (iv) �s condi��es para sua renova��o, e (v) �s hip�teses de sua exonera��o.<br />  O(A) Locat�rio(a) declara(m) expressamente, ainda, que est� ciente que em caso de exonera��o da CREDPAGO SERVI� OS DE COBRAN�A S/A. da condi��o de fiadora, caber� a ele promover no prazo m�ximo de 30 (trinta) dias a substitui��o da garantia prestada, sob pena de infra��o contratual e ajuizamentos da competente a��o de despejo.</p>

        <br/>    
        <b>CL�USULA XI � DO ABANDONO DO IM�VEL</b>
        <br/>
        <br/>

        <div class="clJustificar">
            A fim de se resguardar o im�vel de qualquer eventualidade decorrente da aus�ncia do(s)(a) LOCAT�RIO(S)(A), fica a ADMINISTRADORA expressamente autorizada a ocupar o im�vel, independentemente de procedimento judicial, caracterizando-se como abandono a aus�ncia comprovada do(s)(a) LOCAT�RIO(S)(A), combinada com a inadimpl�ncia de 02 (dois) meses de aluguel;
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo Primeiro:</b> Fica a ADMINISTRADORA autorizada a remover os bens que porventura existirem no im�vel, devendo para tanto lavrar um termo relacionando-os, termo este que vir� assinado por duas testemunhas e pela ADMINISTRADORA, ou seu representante.
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo Segundo:</b> Se no prazo de 90 (noventa) dias a contar da data do termo de abandono e imiss�o na posse, n�o forem procurados os bens nele relacionados, fica a ADMINISTRADORA expressamente autorizada a alienar o suficiente para saldar o d�bito.
        </div>

        <br/>
        <b>CL�USULA XII � DAS OBRIGA��ES</b>
        <br/>
        <br/>

        <div class="clJustificar">
            Sob pena de responsabilidade civil do(s)(a) LOCAT�RIO(S)(A), este(s)(a) dever�(�o) informar � ADMINISTRADORA quando do recebimento de quaisquer pap�is ou documentos entregues no endere�o do bem locado relativos a esta ou ao im�vel. Caso assim n�o proceda, o(s)(a) LOCAT�RIO(S)(A) arcar�(�o) com os encargos que forem aplicados em raz�o do descumprimento desta obriga��o.
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo Primeiro:</b> O(s)(A) LOCAT�RIO(S)(A) obriga(m)-se a transferir para o seu nome as tarifas de luz e �gua, no prazo de 30 (trinta) dias a contar da assinatura deste instrumento, devendo apresent�-las de imediato � ADMINISTRADORA, sob pena de ser aplicada � multa prevista na cl�usula V.
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo Segundo:</b> Obriga(m)-se o(s)(a) LOCAT�RIO(S)(A) a informar � ADMINISTRADORA qualquer altera��o de endere�o, sob pena de se considerarem v�lidas, para todos os efeitos legais, as correspond�ncias que lhe forem encaminhadas para o endere�o acima indicado ou do im�vel locado.
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo Terceiro:</b> Obriga-se a ADMINISTRADORA a informar ao(s)(a) LOCAT�RIO(S)(A) qualquer altera��o de endere�o, sob pena de se considerarem v�lidas, para todos os efeitos legais, as correspond�ncias que lhe forem encaminhadas para o endere�o acima indicado.
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo Quarto:</b> Ap�s a vig�ncia do contrato e tornando-se ele por prazo indeterminado, obriga(m)-se o(s)(a) LOCAT�RIO(S)(A) a atender(em) a solicita��o da ADMINISTRADORA quanto ao preenchimento de nova ficha cadastral com dados atualizados, sob pena de a recusa nesse sentido, configurar infra��o pun�vel com a multa estabelecida no caput da cl�usula V.
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo Quinto:</b> Autoriza(m) o(s)(a) LOCAT�RIO(S)(A) que a cita��o, intima��o ou notifica��o poder� ser formalizada mediante correspond�ncia com aviso de recebimento, ou, tratando-se de pessoa jur�dica ou firma individual, tamb�m mediante telex ou fac-s�mile, ou, ainda, sendo necess�rio, pelas demais formas previstas no C�digo de Processo Civil.
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo Sexto:</b> O(s)(A) LOCAT�RIO(S)(A) recebe(m), neste ato, a Conven��o do Condom�nio e o Regimento Interno, comprometendo-se a cumpri-los integralmente.
        </div>

        <br/>
        <b>CL�USULA XIII � FATOS SUPERVENIENTES</b>
        <br/>
        <br/>

        <div class="clJustificar">
            Em caso de desapropria��o, inc�ndio, ou qualquer outro fato que torne impeditiva a continuidade da loca��o e que n�o tenha resultado da a��o ou omiss�o das partes contratantes, considerar-se-� extinta a loca��o de pleno direito, sem que seja imputada indeniza��o a qualquer t�tulo, reciprocamente, sem preju�zo da cobran�a de eventuais d�bitos anteriores � ocorr�ncia.
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo �nico:</b> A ADMINISTRADORA n�o responder�, em nenhuma hip�tese, por quaisquer danos que venha(m) a sofrer o(s)(a) LOCAT�RIO(S)(A)  em raz�o de derramamento de l�quidos (�gua, rompimento de canos, chuvas, torneiras, defeitos de esgoto ou fossas, entre outros), inc�ndios, arrombamentos, roubos, furtos e quaisquer outros casos, inclusive fortuitos ou de for�a maior, do que neste ato o(s)(a) LOCAT�RIO(S)(A)  tem pleno conhecimento e concorda(m) expressamente.
        </div>

        <br/>
        <b>CL�USULA XIV � DA EXONERA��O DE RESPONSABILIDADE </b>
        <br/>
        <br/>

        <div class="clJustificar">
            O(s)(A) LOCAT�RIO(S)(A)  assume(m) toda e qualquer responsabilidade pelo atendimento de exig�ncias que venham a ser feitas pelas autoridades locais para sua instala��o, inclusive, em havendo negativa total para o fim a que pretende destinar o im�vel.
        </div>

        <br/>

        <div class="clJustificar">
            <b>Par�grafo �nico:</b> Multas oriundas do uso do im�vel em discord�ncia com quaisquer normas legais ser�o de responsabilidade do(s)(a) LOCAT�RIO(S)(A) .
        </div>

        <br/>
        <b>CL�USULA XV � DAS A��ES JUDICIAIS</b>
        <br/>
        <br/>

        <div class="clJustificar">
            Todas as obriga��es decorrentes do presente contrato, mesmo em caso de prorroga��o, s�o extensivas aos herdeiros e sucessores dos contratantes e exig�veis de pleno direito, nos prazos e pelas formas mencionadas, independentes de qualquer aviso, notifica��o judicial ou extrajudicial. No d�bito, ser�o consideradas inclusive as multas, juros, corre��es e indeniza��es, como d�vida l�quida e certa, cobr�vel judicialmente do(s)(a) LOCAT�RIO(S)(A) . Incluem-se, neste caso, tamb�m as custas judiciais e honor�rios advocat�cios despendidos para preserva��o e consecu��o dos direitos da ADMINISTRADORA.
        </div>

        <br/>
        <b>CL�USULA XVI � DO FORO</b>
        <br/>
        <br/>

        <div class="clJustificar">
            Elege-se o foro da Circunscri��o Especial Judici�ria de Bras�lia�DF para dirimir quaisquer d�vidas originadas deste contrato, com expressa ren�ncia a qualquer outro, por mais privilegiado que seja.
        </div>
        <br/>

        <div class="clJustificar">
            E, por estarem justos e contratados, assinam o presente contrato em 02 (duas) vias de igual teor e forma, para um s� efeito, na presen�a das testemunhas abaixo.
        </div>

        <br/>
        <br/>
        <br/>

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

    echo '<center>Bras�lia-DF, ' . $dia . ' de ' . $mes . ' de 20' . $ano . '.</center>';
    ?>


        <br/>
        <br/>
        <br/>
        <br/>
        
        <br/>
        <table width='600'>
            <tr>
                <td align='center' width='50%'>
                    ________________________________
                    <br/>
                    <b>ADMINISTRADORA
                    <br/>
                    TABAKAL</b> Emp. Imobili�rios Ltda. 
                    <br/>
                    CNPJ/MF n� 06.864.021/0001-31

                </td>
            </tr>
        </table>
        <br/>
        <br/>
        <br/>
        <br/>

        <table width='600'>
            <tr>
                <td colspan='2' align='center'>
                    ________________________________
                    <br/>
                    <b>LOCAT�RIO(A)</b>
                    <br/>
                <?php echo ($nomeLocatario); ?>
                    <br/>
                    CPF n� <?php echo $cpf; ?>
                </td>

                    <?php
                    if ($strConjugeListar != '') {
                        ?>
                    <td align='center' width='50%'>
                        ________________________________
                        <br/>
                        <b>C�NJUGE</b>
                        <br/>
        <?php echo ($conjugeLocatarioNome); ?>
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

            <?php
            $sql = sprintf("CALL procContratoFiadorSelecionar($codContrato)");
            $rsFiador = $mySQL->runQuery($sql);

            $rsQuant = $rsFiador->num_rows;

            if ($rsQuant > 0) {

                while ($rsFiadorLinha = mysqli_fetch_assoc($rsFiador)) {
                    utf8_decode_array($rsFiadorLinha);
                    $codPessoaEstadoCivil = $rsFiadorLinha['codPessoa'];

                    if ($rsFiadorLinha['codEstadoCivil'] = 2) { //casado
                        $sqlFiador = sprintf("CALL procPessoaConjugeListar($codPessoaEstadoCivil)");
                        $rsConjugeFiador = $mySQL->runQuery($sqlFiador);
                        $rsConjugeFiadorLinha = mysqli_fetch_assoc($rsConjugeFiador);
                        utf8_decode_array($rsConjugeFiadorLinha);
                    }
                    ?>
                    <tr>	
                        <td align='center' width='50%' height='170'>
                            ________________________________
                            <br/>
                            <b>FIADOR(A)</b>
                            <br/>
                        <?php echo ($rsFiadorLinha['nome']); ?>
                            <br/>
                            CPF n� <?php echo mascaraCpf($rsFiadorLinha['cpf']); ?> 	
                        </td>
            <?php
            if ($rsConjugeFiadorLinha['nome'] <> "") {
                ?>
                            <td align='center' width='50%'>
                                ________________________________
                                <br/>
                                <b>C�NJUGE</b>
                                <br/>
                            <?php echo ($rsConjugeFiadorLinha['nome']); ?>
                                <br/>
                                CPF n� <?php echo mascaraCpf($rsConjugeFiadorLinha['cpf']); ?>  
                            </td>
                        <?php
                    }
                    ?>
                    </tr>	
            <?php
        }
    }
    ?>

        </table>
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