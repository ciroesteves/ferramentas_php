<?php
include_once "menu.php";

$strTableHeader             = $strTableHeaderLote   = $strTableTrailer          =
    $strTableTrailerLote    = $strTableP            = $strTableQ                =
    $strTableR              = $strTableS            =  $strTableT               =
    $strTableU              =  '';

function campoNumerico($trecho, $padrao)
{
    if ($padrao == "N") {
        return !is_numeric($trecho) ? "ERRO" : "";
    }
    return "";
}

function campoBrancos($trecho, $padrao)
{
    if ($padrao == "Brancos") {
        return !empty(trim($trecho)) ? "ERRO" : "OK";
    }
    return "";
}

function campoValidaComPadrao($trecho, $padrao)
{
    if (!empty(trim($padrao))) {
        if ($trecho == $padrao) {
            return "OK";
        } else if (($padrao == "DDMMAAAA" || $padrao == "Nosso Número" || $padrao == "Seu Número")) {
            return "";
        } else {
            return "ERRO";
        }
    }
    return "";
}

function geraTabela($dados, $linha)
{
    $str = "<table>
                <tr>
                    <th class='campo_maior'>Trecho</th>
                    <th class='campo_maior'>Padrão</th>
                    <th>?</th>
                    <th>Tipo</th>
                    <th class='campo_maior'>Descrição</th>
                    <th>Pos_ini</th>
                    <th>Pos_fim</th>
                </tr>";

    foreach ($dados as $dado) {
        $pos = $dado[0] + $dado[1] - 1;
        $trecho = substr($linha, $dado[0] - 1, $dado[1]);

        $is_ok = $backgroundLinha = "";
        $is_ok = campoNumerico($trecho, $dado[2]) != "" ? campoNumerico($trecho, $dado[2]) : $is_ok;
        $is_ok = campoValidaComPadrao($trecho, $dado[3]) != "" ? campoValidaComPadrao($trecho, $dado[3]) : $is_ok;
        $is_ok = campoBrancos($trecho, $dado[3])  != "" ? campoBrancos($trecho, $dado[3]) : $is_ok;;

        if ($is_ok == "OK") {
            $backgroundLinha = "class='ok'";
        } else if ($is_ok == "ERRO") {
            $backgroundLinha = "class='erro'";
        }

        $str .= "<tr {$backgroundLinha}>
                    <td>{$trecho}</td> 
                    <td>{$dado[3]}</td>
                    <td>{$is_ok}</td>
                    <td>{$dado[2]}</td>
                    <td>{$dado[4]}</td>
                    <td>{$dado[0]}</td>
                    <td>{$pos}</td>
                </tr>";
    }
    $str .= "</table>";
    return $str;
}

if (!empty($_POST['header'])) {
    $dados = [
        [1,     3,      "N",    "033",      "Código do Banco na compensação"],
        [4,     4,      "N",    "0000",     "Lote de serviço "],
        [8,     1,      "N",    "0",        "Tipo de registro"],
        [9,     8,      "A",    "",         "Reservado (uso do banco)"],
        [17,    1,      "N",    "",         "Tipo de inscrição da empresa"],
        [18,    15,     "N",    "",         "Número de inscrição da empresa"],
        [33,    15,     "N",    "",         "Código de transmissão"],
        [48,    25,     "A",    "Brancos",  "Reservado (uso do banco)"],
        [73,    30,     "A",    "",         "Nome da empresa"],
        [103,   30,     "A",    "Banco Santander",  "Nome do Banco"],
        [133,   10,     "A",    "Brancos",          "Reservado (uso do banco)"],
        [143,   1,      "N",    "1",                "Código Remessa"],
        [144,   8,      "N",    "DDMMAAAA",         "Data da geração do arquivo"],
        [152,   6,      "A",    "Brancos",          "Reservado (uso do banco)"],
        [158,   6,      "N",    "",                 "Número sequencial do arquivo"],
        [164,   3,      "N",    "040",              "Versão do layout do arquivo"],
        [167,   74,     "A",    "Brancos",          "Reservado (uso do banco)"]

    ];

    $strTableHeader = geraTabela($dados, $_POST['header']);
}
if (!empty($_POST['header_lote'])) {
    $dados = [
        [1,     3,      "N",    "033",      "Código do Banco na compensação"],
        [4,     4,      "N",    "",         "Número do lote de serviço "],
        [8,     1,      "N",    "1",        "Tipo de registro"],
        [9,     1,      "A",    "R",        "Tipo de operação"],
        [10,    2,      "N",    "01",       "Tipo de serviço"],
        [12,    2,      "A",    "Brancos",  "Reservado (uso do banco)"],
        [14,    3,      "N",    "040",      "Nº da versão do layout do lote"],
        [17,    1,      "A",    "Brancos",  "Reservado (uso do banco)"],
        [18,    1,      "N",    "",         "Tipo de inscrição da empresa"],
        [19,    15,     "N",    "",         "Nº de inscrição da empresa"],
        [34,    20,     "A",    "Brancos",  "Reservado (uso do banco)"],
        [54,    15,     "N",    "",         "Código de transmissão"],
        [69,    5,      "A",    "Brancos",  "Reservado (uso do banco)"],
        [74,    30,     "A",    "",         "Nome do beneficiário"],
        [104,   40,     "A",    "",         "Mensagem 1"],
        [144,   40,     "A",    "",         "Mensagem 2"],
        [184,   8,      "N",    "",         "Número remessa"],
        [192,   8,      "N",    "DDMMAAAA", "Data da gravação da remessa"],
        [200,   41,     "A",    "Brancos",  "Reservado (uso do banco)"]
    ];

    $strTableHeaderLote = geraTabela($dados, $_POST['header_lote']);
}
if (!empty($_POST['trailer_lote'])) {
    $dados = [
        [1,     3,      "N",    "033",      "Código do Banco na compensação"],
        [4,     4,      "N",    "",         "Número do lote de remessa"],
        [8,     1,      "N",    "5",        "Tipo de registro"],
        [9,     9,      "A",    "Brancos",  "Reservado (uso do banco)"],
        [18,    6,      "N",    "",         "Quantidade de registros do lote"],
        [24,    217,    "A",    "Brancos",  "Reservado (uso do banco)"]
    ];

    $strTableTrailerLote = geraTabela($dados, $_POST['trailer_lote']);
}
if (!empty($_POST['trailer'])) {
    $dados = [
        [1,     3,      "N",    "033",      "Código do Banco na compensação"],
        [4,     4,      "N",    "",         "Número da remessa"],
        [8,     1,      "N",    "9",        "Tipo de registro"],
        [9,     9,      "A",    "Brancos",  "Reservado (uso do banco)"],
        [18,    6,      "N",    "",         "Quantidade de lotes do arquivo"],
        [24,    6,      "N",    "",         "Quantidade de registros do arquivo"],
        [30,    211,    "A",    "Brancos",  "Reservado (uso do banco)"]
    ];

    $strTableTrailer = geraTabela($dados, $_POST['trailer']);
}
if (!empty($_POST['segmento_t'])) {
    $dados = [
        [1,     3,  "N", "033",         "Código do Banco na compensação"],
        [4,     4,  "N", "",            "Número do lote retorno"],
        [8,     1,  "N", "3",           "Tipo de registro"],
        [9,     5,  "N", "",            "Nº sequencial do registro no lote"],
        [14,    1,  "A", "T",           "Cód. segmento do registro detalhe"],
        [15,    1,  "A", "Brancos",     "Reservado (uso Banco)"],
        [16,    2,  "A", "",            "Código de movimento (ocorrência)"],
        [18,    4,  "N", "",            "Agência do Beneficiário"],
        [22,    1,  "N", "",            "Dígito da Agência do Beneficiário"],
        [23,    9,  "N", "",            "Número da conta corrente"],
        [32,    1,  "N", "",            "Dígito verificador da conta"],
        [33,    8,  "A", "Brancos",     "Reservado (uso Banco)"],
        [41,    13, "N", "Nosso Número", "Identificação do boleto no Banco"],
        [54,    1,  "A", "",             "Código da carteira"],
        [55,    15, "A", "Seu Número",  "Nº do documento de cobrança"],
        [70,    8,  "N", "DDMMAAAA",    "Data do vencimento do boleto"],
        [78,    15, "N", "",            "Valor nominal do boleto"],
        [93,    3,  "N", "",            "Nº do Banco Cobrador / Recebedor"],
        [96,    4,  "N", "",            "Agência Cobradora / Recebedora"],
        [100,   1,  "N", "",            "Dígito da Agência do Beneficiário"],
        [101,   25, "A", "",            "Identif. do boleto na empresa"],
        [126,   2,  "N", "",            "Código da moeda "],
        [128,   1,  "N", "",            "Tipo de inscrição Pagador"],
        [129,   15, "N", "",            "Número de inscrição Pagador"],
        [144,   40, "A", "",            "Nome do Pagador"],
        [184,   10, "A", "",            "Conta Cobrança"],
        [194,   15, "N", "",            "Valor da Tarifa/Custas"],
        [209,   10, "A", "",            "Identificação para rejeições, tarifas, custas, liquidações, baixas e PIX."],
        [219,   22, "A", "Brancos",     "Reservado (uso Banco)"]
    ];
    $strTableT = geraTabela($dados, $_POST['segmento_t']);
}
if (!empty($_POST['segmento_u'])) {
    $dados = [
        [1,     3,      "N",    "033",      "Código do Banco na compensação"],
        [4,     4,      "N",    "",         "Lote de serviço"],
        [8,     1,      "N",    "3",        "Tipo de registro"],
        [9,     5,      "N",    "",         "Nº sequencial do registro no lote"],
        [14,    1,      "A",    "U",        "Cód. segmento do registro detalhe"],
        [15,    1,      "A",    "Brancos",  "Reservado (uso Banco)"],
        [16,    2,      "N",    "",         "Código de movimento (ocorrência)"],
        [18,    15,     "N",    "",         "Juros / Multa / Encargos"],
        [33,    15,     "N",    "",         "Valor do desconto concedido"],
        [48,    15,     "N",    "",         "Valor do Abatimento Concedido/Cancelado"],
        [63,    15,     "N",    "",         "Valor do IOF recolhido"],
        [78,    15,     "N",    "",         "Valor pago pelo Pagador"],
        [93,    15,     "N",    "",         "Valor liquido a ser creditado"],
        [108,   15,     "N",    "",         "Valor de outras despesas"],
        [123,   15,     "N",    "",         "Valor de outros créditos"],
        [138,   8,      "N",    "DDMMAAAA", "Data da ocorrência"],
        [146,   8,      "N",    "DDMMAAAA", "Data da efetivação do crédito"],
        [154,   4,      "N",    "",         "Código da ocorrência do Pagador"],
        [158,   8,      "N",    "DDMMAAAA", "Data da ocorrência do Pagador"],
        [166,   15,     "N",    "",         "Valor da ocorrência do Pagador"],
        [181,   30,     "A",    "",         "Complemento da ocorrência do Pagador"],
        [211,   3,      "N",    "",         "Código do Banco correspondente compens."],
        [214,   27,     "A",    "Brancos",  "Reservado"]
    ];

    $strTableU = geraTabela($dados, $_POST['segmento_u']);
}
if (!empty($_POST['segmento_p'])) {
    $dados = [
        [1,     3,      "N",    "033",          "Código do Banco na compensação"],
        [4,     4,      "N",    "",             "Número do lote remessa"],
        [8,     1,      "N",    "3",            "Tipo de registro"],
        [9,     5,      "N",    "",             "Nº sequencial do registro no lote"],
        [14,    1,      "A",    "P",            "Cód. segmento do registro detalhe"],
        [15,    1,      "A",    "Brancos",      "Reservado (uso Banco)"],
        [16,    2,      "N",    "",             "Código de movimento remessa"],
        [18,    4,      "N",    "",             "Agência do Destinatário"],
        [22,    1,      "N",    "",             "Dígito da Ag do Destinatário"],
        [23,    9,      "N",    "",             "Número da conta corrente"],
        [32,    1,      "N",    "",             "Dígito verificador da conta"],
        [33,    9,      "N",    "",             "Conta cobrança destinatária FIDC"],
        [42,    1,      "N",    "",             "Dígito da conta cobrança destinatária FIDC"],
        [43,    2,      "A",    "Brancos",      "Reservado (uso Banco)"],
        [45,    13,     "N",    "Nosso Número", "Identificação do boleto no Banco"],
        [58,    1,      "A",    "",             "Tipo de cobrança"],
        [59,    1,      "N",    "",             "Forma de cadastramento"],
        [60,    1,      "N",    "",             "Tipo de documento"],
        [61,    1,      "A",    "Brancos",      "Reservado (uso Banco)"],
        [62,    1,      "A",    "Brancos",      "Reservado (uso Banco)"],
        [63,    15,     "N",    "Seu Número",   "Nº do documento"],
        [78,    8,      "N",    "DDMMAAAA",     "Data de vencimento do boleto"],
        [86,    15,     "N",    "",             "Valor nominal do boleto"],
        [101,   4,      "N",    "",             "Agência encarregada da cobrança FIDC"],
        [105,   1,      "N",    "",             "Dígito da Agência do Beneficiário FIDC"],
        [106,   1,      "A",    "Brancos",      "Reservado (uso Banco)"],
        [107,   2,      "N",    "",             "Espécie do boleto"],
        [109,   1,      "A",    "",             "Identif. de boleto Aceito/Não Aceito "],
        [110,   8,      "N",    "DDMMAAAA",     "Data de emissão do boleto"],
        [118,   1,      "N",    "",             "Código de juros de mora"],
        [119,   8,      "N",    "DDMMAAAA",     "Data de juros de mora"],
        [127,   15,     "N",    "",             "Valor de mora/dia ou taxa mensal"],
        [142,   1,      "N",    "",             "Código do desconto 1"],
        [143,   8,      "N",    "DDMMAAAA",     "Data do desconto 1"],
        [151,   15,     "N",    "",             "Valor ou percentual do desconto 1"],
        [166,   15,     "N",    "",             "Percentual do IOF a ser recolhido"],
        [181,   15,     "N",    "",             "Valor do abatimento"],
        [196,   25,     "A",    "",             "Identificação do boleto na empresa"],
        [221,   1,      "N",    "",             "Código para protesto"],
        [222,   2,      "N",    "",             "Número de dias para protesto"],
        [224,   1,      "N",    "",             "Código para baixa/devolução"],
        [225,   1,      "N",    "0",            "Reservado (uso Banco)"],
        [226,   2,      "N",    "",             "Número de dias para baixa/devolução"],
        [228,   2,      "N",    "",             "Código da moeda"],
        [230,   11,     "A",    "Brancos",      "Reservado (uso Banco)"]
    ];

    $strTableP = geraTabela($dados, $_POST['segmento_p']);
}
if (!empty($_POST['segmento_q'])) {
    $dados = [
        [1,     3,      "N",    "033",          "Código do Banco na compensação"],
        [4,     4,      "N",    "",             "Número do lote remessa"],
        [8,     1,      "N",    "3",            "Tipo de registro"],
        [9,     5,      "N",    "",             "Nº sequencial do registro no lote"],
        [14,    1,      "A",    "Q",            "Cód. segmento do registro detalhe"],
        [15,    1,      "A",    "Brancos",      "Reservado (uso Banco)"],
        [16,    2,      "N",    "",             "Código de movimento remessa"],
        [18,    1,      "N",    "",             "Tipo de inscrição do pagador"],
        [19,    15,     "N",    "",             "Número de inscrição do pagador"],
        [34,    40,     "A",    "",             "Nome do pagador"],
        [74,    40,     "A",    "",             "Endereço do pagador"],
        [114,   15,     "A",    "",             "Bairro do pagador"],
        [129,   5,      "N",    "",             "CEP do pagador"],
        [134,   3,      "N",    "",             "Sufixo CEP do pagador"],
        [137,   15,     "A",    "",             "Cidade do pagador"],
        [152,   2,      "A",    "",             "Unidade da Federação do pagador"],
        [154,   1,      "N",    "",             "Tipo de inscrição do beneficiário final"],
        [155,   15,     "N",    "",             "Número de inscrição do beneficiário final"],
        [170,   40,     "A",    "",             "Nome do beneficiário final"],
        [210,   3,      "N",    "000",          "Reservado (uso Banco)"],
        [213,   3,      "N",    "000",          "Reservado (uso Banco)"],
        [216,   3,      "N",    "000",          "Reservado (uso Banco)"],
        [219,   3,      "N",    "000",          "Reservado (uso Banco)"],
        [222,   19,     "A",    "Brancos",      "Reservado (uso Banco)"]
    ];

    $strTableQ = geraTabela($dados, $_POST['segmento_q']);
}
if (!empty($_POST['segmento_r'])) {
    $dados = [
        [1,     3,      "N",    "033",          "Código do Banco na compensação"],
        [4,     4,      "N",    "",             "Número do lote remessa"],
        [8,     1,      "N",    "3",            "Tipo de registro"],
        [9,     5,      "N",    "",             "Nº sequencial do registro no lote"],
        [14,    1,      "A",    "R",            "Cód. segmento do registro detalhe"],
        [15,    1,      "A",    "Brancos",      "Reservado (uso Banco)"],
        [16,    2,      "N",    "",             "Código de movimento remessa"],
        [18,    1,      "N",    "",             "Código do desconto 2"],
        [19,    8,      "N",    "DDMMAAAA",     "Data do desconto 2"],
        [27,    15,     "N",    "",             "Valor ou percentual do desconto 2"],
        [42,    1,      "N",    "",             "Código do desconto 3"],
        [43,    8,      "N",    "DDMMAAAA",     "Data do desconto 3"],
        [51,    15,     "N",    "",             "Valor ou percentual do desconto 3"],
        [66,    1,      "N",    "",             "Código da multa"],
        [67,    8,      "N",    "DDMMAAAA",     "Data da multa"],
        [75,    15,     "N",    "",             "Valor ou percentual da multa"],
        [90,    10,     "A",    "Brancos",      "Reservado (uso Banco)"],
        [100,   40,     "A",    "",             "Mensagem 3"],
        [140,   40,     "A",    "",             "Mensagem 4"],
        [180,   61,     "A",    "Brancos",      "Reservado (uso Banco)"]
    ];

    $strTableR = geraTabela($dados, $_POST['segmento_r']);
}
if (!empty($_POST['segmento_s'])) {
    $dados = [
        [1,     3,      "N",    "033",          "Código do Banco na compensação"],
        [4,     4,      "N",    "",             "Número do lote remessa"],
        [8,     1,      "N",    "3",            "Tipo de registro"],
        [9,     5,      "N",    "",             "Nº sequencial do registro no lote"],
        [14,    1,      "A",    "S",            "Cód. segmento do registro detalhe"],
        [15,    1,      "A",    "Brancos",      "Reservado (uso Banco)"],
        [16,    2,      "N",    "",             "Código de movimento remessa"]
    ];

    if (substr($_POST['segmento_s'], 18, 1) == '1') {
        $dadosCondicionais = [
            [18,    1,      "N",    "1",            "Identificação da impressão"],
            [19,    2,      "N",    "",             "Número da linha a ser impressa"],
            [21,    1,      "N",    "",             "Mensagem para recibo do pagador"],
            [22,    100,    "A",    "",             "Mensagem a ser impressa"],
            [122,   119,    "A",    "Brancos",      "Reservado (uso Banco)"]
        ];
        foreach ($dadosCondicionais as $linhaDadosCondicionais) {
            array_push($dados, $linhaDadosCondicionais);
        }
    } else if (substr($_POST['segmento_s'], 18, 1) == '2') {
        $dadosCondicionais = [
            [18,    1,      "N",    "2",            "Identificação da impressão"],
            [19,    40,     "A",    "",             "Mensagem 5"],
            [59,    40,     "A",    "",             "Mensagem 6"],
            [99,    40,     "A",    "",             "Mensagem 7"],
            [139,   40,     "A",    "",             "Mensagem 8"],
            [179,   40,     "A",    "",             "Mensagem 9"],
            [219,   22,     "A",    "Brancos",      "Reservado (uso Banco)"]
        ];
        foreach ($dadosCondicionais as $linhaDadosCondicionais) {
            array_push($dados, $linhaDadosCondicionais);
        }
    }

    $strTableS = geraTabela($dados, $_POST['segmento_s']);
}

?>
<html>

<head>
    <meta charset="UTF=8" />
    <title>Validador</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
</head>

<body>
    <div class="slick-carousel">
        <div class="container">
            <h1>Header/Trailer Remessa</h1>
            <form action="santander_v4.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-md-2" align="left" for="header">Header Arquivo</label>
                    <input class="col-md-6" type="text" id="header" name="header" maxlength="240">
                </div>
                <div class="form-group">
                    <label class="col-md-2" align="left" for="header_lote">Header Lote</label>
                    <input class="col-md-6" type="text" id="header_lote" name="header_lote" maxlength="240">
                </div>
                <div class="form-group row">
                    <label class="col-md-2" align="left" for="trailer_lote">Trailer Lote</label>
                    <input class="col-md-6" type="text" id="trailer_lote" name="trailer_lote" maxlength="240">
                </div>
                <div class="form-group">
                    <label class="col-md-2" align="left" for="trailer">Trailer Arquivo</label>
                    <input class="col-md-6" type="text" id="trailer" name="trailer" maxlength="240">
                </div>
                <input type="submit" value="Validar">
            </form>
        </div>
        <div class="container">
            <h1>Remessa</h1>
            <form action="santander_v4.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="segmento_p">Segmento P</label>
                    <input type="text" id="segmento_p" name="segmento_p">
                </div>
                <div class="form-group">
                    <label for="segmento_q">Segmento Q</label>
                    <input type="text" id="segmento_q" name="segmento_q">
                </div>
                <div class="form-group">
                    <label for="segmento_r">Segmento R</label>
                    <input type="text" id="segmento_r" name="segmento_r">
                </div>
                <div class="form-group">
                    <label for="segmento_s">Segmento S</label>
                    <input type="text" id="segmento_s" name="segmento_s">
                </div>
                <input type="submit" value="Validar">
            </form>
        </div>
        <div class="container">
            <h1>Retorno</h1>
            <form action="santander_v4.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="segmento_t">Segmento T</label>
                    <input type="text" id="segmento_t" name="segmento_t" maxlength="240">
                </div>
                <div class="form-group">
                    <label for="segmento_u">Segmento U</label>
                    <input type="text" id="segmento_u" name="segmento_u" maxlength="240">
                </div>
                <input type="submit" value="Validar">
            </form>
        </div>
    </div>
    <div class="tabelas">
        <?php
        if (!empty($_POST['header'])) {
            echo "  <div class='container result'>
                        <h1>Header</h1>                
                        {$strTableHeader}
                    </div>";
        }
        if (!empty($_POST['header_lote'])) {
            echo "  <div class='container result'>
                        <h1>Header Lote</h1>
                        {$strTableHeaderLote}
                    </div>";
        }
        if (!empty($_POST['trailer_lote'])) {
            echo "  <div class='container result'>
                        <h1>Trailer Lote</h1>
                        {$strTableTrailerLote}
                    </div>";
        }
        if (!empty($_POST['trailer'])) {
            echo "  <div class='container result'>
                        <h1>Trailer</h1>
                        {$strTableTrailer}
                    </div>";
        }
        if (!empty($_POST['segmento_t'])) {
            echo "  <div class='container result'>
                        <h1>Segmento T</h1>
                        {$strTableT}
                    </div>";
        }
        if (!empty($_POST['segmento_u'])) {
            echo "  <div class='container result'>
                        <h1>Segmento U</h1>
                        {$strTableU}
                    </div>";
        }
        if (!empty($_POST['segmento_p'])) {
            echo "  <div class='container result'>
                        <h1>Segmento P</h1>
                        {$strTableP}
                    </div>";
        }
        if (!empty($_POST['segmento_q'])) {
            echo "  <div class='container result'>
                        <h1>Segmento Q</h1>
                        {$strTableQ}
                    </div>";
        }
        if (!empty($_POST['segmento_r'])) {
            echo "  <div class='container result'>
                        <h1>Segmento R</h1>
                        {$strTableR}
                    </div>";
        }
        if (!empty($_POST['segmento_s'])) {
            echo "  <div class='container result'>
                        <h1>Segmento S</h1>
                        {$strTableS}
                    </div>";
        }
        ?>
    </div>
</body>

<script>
    $(document).ready(function() {
        $('.tabelas').slick({
            infinite: true,
            speed: 300,
            prevArrow: '<button type="button" class="slick-prev">Previous</button>',
            nextArrow: '<button type="button" class="slick-next">Next</button>',
            slidesToShow: 1,
            slidesToScroll: 1,
        });
    });

    $(document).ready(function() {
        $('.slick-carousel').slick({
            infinite: true,
            speed: 300,
            prevArrow: '<button type="button" class="slick-prev">Previous</button>',
            nextArrow: '<button type="button" class="slick-next">Next</button>',
            slidesToShow: 1,
            slidesToScroll: 1,
        });
    });
</script>

<style>
    label {
        text-align: left;
        display: block;
        margin-bottom: 0.2rem;
        margin-left: 10%;
        font-size: 1.1rem;
        font-weight: bold;
        color: #333;
    }

    input[type="text"] {
        display: block;
        margin: auto;
        width: 80%;
        font-size: 1rem;
        color: #555;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }


    input[type="text"]:focus {
        outline: none;
        border-color: #4d90fe;
        box-shadow: 0 0 0 0.2rem rgba(77, 144, 254, 0.25);
    }

    .slick-carousel {
        width: 45%;
        height: 400px;
        margin: 20px auto;
        border-radius: 15px;    }

    input {
        width: 70%;
    }

    table {
        border-collapse: collapse;
        width: 90%;
        margin: auto;
    }

    .tabelas {
        width: 95%;
        margin: auto;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #C0C0C0;
    }

    .erro:hover {
        background-color: red;
    }

    .ok:hover {
        background-color: green;
    }

    .campo_maior {
        width: 450px;
    }

    .container {
        width: 45%;
        background-color: #DEDEDE;
        border-radius: 15px;
    }

    h1 {
        text-align: center;
        font-size: 32px;
        margin-bottom: 30px;
    }

    form {
        text-align: center;
    }

    .form-group {
        margin-top: 5px;
    }

    input[type="submit"],
    button {
        margin-top: 10px;
        background-color: #4CAF50;
        color: #fff;
        padding: 10px 20px;
        font-size: 18px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 50%;
        height: 50px;
    }

    input[type="submit"]:hover {
        background-color: #3e8e41;
    }

    .result {
        height: auto;
        margin: auto;
        padding: 30px;
    }

    .ok {
        background-color: #98FB98;
    }

    .erro {
        background-color: #E9967A;
    }

    .slick-prev.slick-arrow:before,
    .slick-next.slick-arrow::before {
        color: black;
    }
</style>

</html>