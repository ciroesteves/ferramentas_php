<?php
include_once "menu.php";

$strTableHeader             = $strTableHeaderLote   = $strTableTrailer          =
    $strTableTrailerLote    = '';

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
        if (trim($trecho) == $padrao) {
            return "OK";
        } else if (($padrao == "DDMMAA")) {
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
        [1,     1,      "N",    "0",                "IDENTIFICAÇÃO DO REGISTRO HEADER"],
        [2,     1,      "N",    "1",                "TIPO DE OPERAÇÃO - REMESSA"],
        [3,     7,      "A",    "REMESSA",          "IDENTIFICAÇÃO POR EXTENSO DO MOVIMENTO "],
        [10,    2,      "N",    "01",               "IDENTIFICAÇÃO DO TIPO DE SERVIÇO"],
        [12,    15,     "A",    "COBRANCA",         "IDENTIFICAÇÃO POR EXTENSO DO TIPO DE SERVIÇO "],
        [27,    4,      "N",    "",                 "AGÊNCIA MANTENEDORA DA CONTA"],
        [31,    2,      "N",    "00",               "COMPLEMENTO DE REGISTRO "],
        [33,    5,      "N",    "",                 "NÚMERO DA CONTA CORRENTE DA EMPRESA"],
        [38,    1,      "N",    "",                 "DÍGITO DE AUTO CONFERÊNCIA AG/CONTA EMPRESA"],
        [39,    8,      "A",    "",                 "COMPLEMENTO DO REGISTRO"],
        [47,    30,     "A",    "",                 "NOME POR EXTENSO DA EMPRESA MÃE "],
        [77,    3,      "N",    "341",              "Nº DO BANCO NA CÂMARA DE COMPENSAÇÃO "],
        [80,    15,     "A",    "BANCO ITAU SA",    "NOME POR EXTENSO DO BANCO COBRADOR "],
        [95,    6,      "N",    "DDMMAA",           "DATA DE GERAÇÃO DO ARQUIVO"],
        [101,   294,    "A",    "",                 "COMPLEMENTO DO REGISTRO"],
        [395,   6,      "N",    "000001",           "NÚMERO SEQÜENCIAL DO REGISTRO NO ARQUIVO"]

    ];

    $strTableHeader = geraTabela($dados, $_POST['header']);
}
if (!empty($_POST['header_lote'])) {
    $dados = [
        [1,     1,      "N",    "0",                "IDENTIFICAÇÃO DO REGISTRO HEADER"],
        [2,     1,      "N",    "1",                "TIPO DE OPERAÇÃO - REMESSA"],
        [3,     7,      "A",    "REMESSA",          "IDENTIFICAÇÃO POR EXTENSO DO MOVIMENTO "],
        [10,    2,      "N",    "01",               "IDENTIFICAÇÃO DO TIPO DE SERVIÇO"],
        [12,    15,     "A",    "COBRANCA",         "IDENTIFICAÇÃO POR EXTENSO DO TIPO DE SERVIÇO "],
        [27,    4,      "N",    "",                 "AGÊNCIA MANTENEDORA DA CONTA"],
        [31,    2,      "N",    "00",               "COMPLEMENTO DE REGISTRO "],
        [33,    5,      "N",    "",                 "NÚMERO DA CONTA CORRENTE DA EMPRESA"],
        [38,    1,      "N",    "",                 "DÍGITO DE AUTO CONFERÊNCIA AG/CONTA EMPRESA"],
        [39,    8,      "A",    "Brancos",          "COMPLEMENTO DO REGISTRO"],
        [47,    30,     "A",    "",                 "NOME POR EXTENSO DA EMPRESA MÃE "],
        [77,    3,      "N",    "341",              "Nº DO BANCO NA CÂMARA DE COMPENSAÇÃO "],
        [80,    15,     "A",    "BANCO ITAU SA",    "NOME POR EXTENSO DO BANCO COBRADOR "],
        [95,    6,      "N",    "DDMMAA",           "DATA DE GERAÇÃO DO ARQUIVO"],
        [101,   294,    "A",    "Brancos",          "COMPLEMENTO DO REGISTRO"],
        [395,   6,      "N",    "000001",           "NÚMERO SEQÜENCIAL DO REGISTRO NO ARQUIVO"]
    ];

    $strTableHeaderLote = geraTabela($dados, $_POST['header_lote']);
}
if (!empty($_POST['trailer'])) {
    $dados = [
        [1,     1,      "N",    "9",          "IDENTIFICAÇÃO DO REGISTRO TRAILER"],
        [2,   393,      "A",    "Brancos",    "COMPLEMENTO DO REGISTRO"],
        [395,   6,      "N",    "",           "NÚMERO SEQÜENCIAL DO REGISTRO NO ARQUIVO"]
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