<?php

if (!empty($_FILES['arquivo']['tmp_name'])) {
    echo "opa";
}

?>
<html>

<head>
    <meta charset="UTF=8" />
    <title>Form Arquivo</title>
</head>

<body>
    <div class="row" id="forms">
        <div class="container">
            <div>
                <h1 class="col-md-6">Santander v4</h1>
                <h3 align="center">CNAB Remessa</h3>
            </div>
            <form action="santander_v4.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="arquivo">Arquivo:</label>
                    <input type="file" id="arquivo" name="arquivo" accept=".csv, .txt">
                </div>
                <input type="submit" value="Validar">
            </form>
        </div>
        <div class="container">
            <div>
                <h1 class="col-md-6">Santander v4</h1>
                <h3 align="center">CNAB Retorno</h3>
            </div>
            <form action="santander_v4.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="arquivo">Arquivo:</label>
                    <input type="file" id="arquivo" name="arquivo" accept=".csv, .txt">
                </div>
                <input type="submit" value="Validar">
            </form>
        </div>
    </div>
    <div class="container" id="result">
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
            <tr>
                <td>Trecho</td>
                <td>Padrão</td>
                <td>OK</td>
                <td>Tipo</td>
                <td>Descrição</td>
                <td>Pos_ini</td>
                <td>Pos_fim</td>
            </tr>


        </table>
    </div>
</body>

<style>
    table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  border: 1px solid #ddd;
  text-align: left;
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
        width: 90%;
        height: auto;
    }

    #forms {
        display: flex;
    }

    .container {
        width: 750px;
        margin: 20px auto;
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

    form {
        text-align: center;
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
</style>