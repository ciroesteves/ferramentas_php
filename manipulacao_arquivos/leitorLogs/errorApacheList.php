<?php
$path = "error.log";
$arquivo = fopen($path, "r");
$erros = array();

while (!feof($arquivo)) {
    $linha = fgets($arquivo);
    // preg_match(pattern, input, matches, flags, offset)
    if (preg_match('/\[php\:(.+?)\]/', $linha, $matches)) {
        $tipoErro = $matches[1];
    }
    if (preg_match('/\[(.+?) (\d+:\d+:\d+)/', $linha, $matches)) {
        $dataHora = strtotime($matches[1] . ' ' . $matches[2]);
        $dataHoraErro = strftime('%d/%m/%Y %H:%M:%S', $dataHora);
    }

    if (preg_match('/line ([\d.:]+)/', $linha, $matches)) {
        $linhaErro = $matches[1];
    }

    if (preg_match('/\: (.+) in/', $linha, $matches)) {
        $mensagemErro = $matches[1];
    }

    if (preg_match('/in (.+) on/', $linha, $matches)) {
        $referer = $matches[1];
    }
    
    $erros[] = array(
        "timestamp"=>$dataHoraErro,
        "tipo"=>$tipoErro,
        "linha"=>$linhaErro,
        "mensagem"=>$mensagemErro,
        "arquivo"=>$referer
    );
}

fclose($arquivo);

echo "<h1>Relatório de Erros do Apache</h1>";
echo "<table>";
echo "<tr><th width='200px'>Data/Hora</th><th width='100px'>Tipo</th><th width='500px'>Mensagem</th><th width='450px'>Arquivo</th><th width='100px'>Linha</th></tr>";

$background = '';
foreach ($erros as $erro) {
    echo "<tr>";
    echo "<td align='center'>" . $erro["timestamp"] . "</td>";
    echo "<td align='center'>" . $erro["tipo"] . "</td>";
    echo "<td>" . $erro["mensagem"] . "</td>";
    echo "<td>" . $erro["arquivo"] . "</td>";
    echo "<td align='center'>" . $erro["linha"] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>

<style>
    table {
        border-collapse: collapse;
        width: 90%;
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
</style>