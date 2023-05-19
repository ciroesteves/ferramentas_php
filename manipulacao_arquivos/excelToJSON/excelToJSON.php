<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (!empty($_FILES['arquivo']['tmp_name'])) {

    $arquivo = $_FILES['arquivo']['tmp_name'];
    $spreadsheet = IOFactory::load($arquivo);
    $pagina = $spreadsheet->getActiveSheet();
    $qtd_linhas = $pagina->getHighestRow();
    $qtd_colunas = $pagina->getHighestColumn();
    $dados = array();

    $header = $pagina->rangeToArray('A1:' . $qtd_colunas . '1', null, true, false)[0];

    for ($linha = 2; $linha <= $qtd_linhas; $linha++) {
        $dados_linha = $pagina->rangeToArray('A' . $linha . ':' . $qtd_colunas . $linha, null, true, false)[0];
        $campo = array_combine($header, $dados_linha);
        $dados[] = $campo;
    }

    $json = json_encode($dados, JSON_PRETTY_PRINT);
}

?>
<html>

<head>
    <meta charset="UTF=8" />
    <title>Form Arquivo</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <h1 class="col-md-6">Excel em JSON</h1>
        </div>
        <form action="excelToJSON.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="arquivo">Arquivo:</label>
                <input type="file" id="arquivo" name="arquivo"  accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
            </div>
            <input type="submit" value="Transformar">
        </form>
        <?php
        if (!empty($arquivo)) {
            echo "<textarea>
            {$json}
            </textarea>";
        }
        ?>
    </div>
</body>

<style>
    .container {
        max-width: 500px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    h1 {
        text-align: center;
        font-size: 32px;
        margin-bottom: 30px;
    }

    textarea {
        height: 50%;
        width: 100%;
        padding: 10px;
        font-size: 16px;
        margin-bottom: 20px;
        border: none;
        border-radius: 5px;
        background-color: #f2f2f2;
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
        width: 100%;
        height: 50px;
    }

    input[type="submit"]:hover {
        background-color: #3e8e41;
    }
</style>