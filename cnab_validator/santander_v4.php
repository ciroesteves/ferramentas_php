<?php
$strTable = '';
if (!empty($_POST['segmento_t'])) {
    $dados = [
        [1, 3, "N", "033", "Código do Banco na compensação"],
        [4, 4, "N", "", "Número do lote retorno"],
        [8, 1, "N", "3", "Tipo de registro"],
        [9, 5, "N", "", "Nº sequencial do registro no lote"],
        [14, 1, "A", "T", "Cód. segmento do registro detalhe"],
        [15, 1, "A", "Brancos", "Reservado (uso Banco)"],
        [16, 2, "A", "", "Código de movimento (ocorrência)"],
        [18, 4, "N", "", "Agência do Beneficiário"],
        [22, 1, "N", "", "Dígito da Agência do Beneficiário"],
        [23, 9, "N", "", "Número da conta corrente"],
        [32, 1, "N", "", "Dígito verificador da conta"],
        [33, 8, "A", "Brancos", "Reservado (uso Banco)"],
        [41, 13, "N", "Nosso Número", "Identificação do boleto no Banco"],
        [54, 1, "A", "", "Código da carteira"],
        [55, 15, "A", "Seu Número", "Nº do documento de cobrança"],
        [70, 8, "N", "DDMMAAAA", "Data do vencimento do boleto"],
        [78, 15, "N", "", "Valor nominal do boleto"],
        [93, 3, "N", "", "Nº do Banco Cobrador / Recebedor"],
        [96, 4, "N", "", "Agência Cobradora / Recebedora"],
        [100, 1, "N", "", "Dígito da Agência do Beneficiário"],
        [101, 25, "A", "", "Identif. do boleto na empresa"],
        [126, 2, "N", "", "Código da moeda "],
        [128, 1, "N", "", "Tipo de inscrição Pagador"],
        [129, 15, "N", "", "Número de inscrição Pagador"],
        [144, 40, "A", "", "Nome do Pagador"],
        [184, 10, "A", "", "Conta Cobrança"],
        [194, 15, "N", "", "Valor da Tarifa/Custas"],
        [209, 10, "A", "", "Identificação para rejeições, tarifas, custas, liquidações, baixas e PIX."],
        [219, 22, "A", "", "Reservado (uso Banco)"]
    ];

    foreach ($dados as $dado) {
        $pos = $dado[0] + $dado[1] - 1;
        $trecho = substr($_POST['segmento_t'], $dado[0] - 1, $dado[1]);

        $is_ok = "ERRO";
        if ($trecho == $dado[3]) {
            $is_ok = "OK";
        } else if ($dado[2] == "N" && $dado[3] == "") {
            $is_ok = is_numeric($trecho) ? "OK" : "ERRO";
        } else if ($dado[2] == "A" && $dado[3] == "") {
            $is_ok = "";
        } else if ($dado[3] == "Brancos" && empty(trim($trecho))) {
            $is_ok = "OK";
        }

        $strTable .= "<tr>
        <td>{$trecho}</td> 
        <td>{$dado[3]}</td>
        <td>{$is_ok}</td>
        <td>{$dado[2]}</td>
        <td>{$dado[4]}</td>
        <td>{$dado[0]}</td>
        <td>{$pos}</td>
    </tr>";
    }
    
}else{
    $strTable .= "<tr><td>Não há informações.</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
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
            <h1>Santander v4 - Header/Trailer</h1>
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
            <h1>Santander v4 - Remessa</h1>
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
            <h1>Santander v4 - Retorno</h1>
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
    <div class="container" id="result">
        <h1>Segmento T</h1>
        <table>
            <tr>
                <th class="campo_maior">Trecho</th>
                <th class="campo_maior">Padrão</th>
                <th>?</th>
                <th>Tipo</th>
                <th class="campo_maior">Descrição</th>
                <th>Pos_ini</th>
                <th>Pos_fim</th>
            </tr>
            <?php
            echo $strTable;
            ?>


        </table>
    </div>
</body>

<script>
    $(document).ready(function() {
        $('.slick-carousel').slick({
            dots: false,
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
        height: 50%;
        margin: 20px auto;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    input {
        width: 70%;
    }

    table {
        border-collapse: collapse;
        width: 100%;
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
        background-color: #f5f5f5;
    }

    .campo_maior {
        width: 450px;
    }

    #result {
        width: 95%;
        height: auto;
        margin: 20px auto;
    }

    #forms {
        display: flex;
    }

    .container {
        width: 45%;
        background-color: #f9f9f9;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
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

    body {
        background-color: red;
    }
</style>