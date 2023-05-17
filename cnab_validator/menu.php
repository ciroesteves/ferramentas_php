<?php
    $nomeArquivo = $_SERVER['PHP_SELF'];
    $idImgBanco = "";
    if (strpos($nomeArquivo, "santander") !== false || strpos($nomeArquivo, "bradesco") !== false) {
        $idImgBanco = "#san_image { box-shadow: 0 0 30px rgba(254, 0, 0, 2);}";
    } else if (strpos($nomeArquivo, "itau") !== false) {
        $idImgBanco = "#it_image { box-shadow: 0 0 30px rgba(236, 112, 0, 2);}";
    } else if (strpos($nomeArquivo, "bbrasil") !== false) {
        $idImgBanco = "#bb_image { box-shadow: 0 0 30px rgba(253, 252, 50, 2);}";
    } else if (strpos($nomeArquivo, "caixa") !== false) {
        $idImgBanco = "#cx_image { box-shadow: 0 0 30px rgba(24, 94, 156, 2);}";
    }
?>

<nav class='menu'>
    <ul>
        <li><a href='#'><img id="bb_image" src="bb.png"></a></li>
        <li><a href='santander_v4.php'><img id="san_image" src="san.png"></a></li>
        <li><a href='itau_400.php'><img id="it_image" src="it.png"></a></li>
        <li><a href='#'><img id="brad_image" src="brad.jpg"></a></li>
        <li><a href='#'><img id="cx_image" src="cx.png"></a></li>
    </ul>
</nav>

<style>
    img {
        border-radius: 50%;
        width: 100px;

    }

    <?= $idImgBanco ?> 

    .menu ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: space-around;
    }

    .menu li {
        display: inline-block;
    }

    body {
        background-color: gray;
    }
</style>