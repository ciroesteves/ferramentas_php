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
            <form action="itau_400.php" method="POST" enctype="multipart/form-data">
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