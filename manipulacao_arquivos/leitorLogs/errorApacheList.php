<?php
$path = "error.log";
$arquivo = fopen($path, "r");
$erros = array();

while (!feof($arquivo)) {
    $linha = fgets($arquivo);
    // preg_match(pattern, input, matches, flags, offset)
    if (preg_match('/^\[[^\]]+\] \[([^\]]+)\] \[client ([^\]]+)\] (.*)$/', $linha, $matches)) {
        $timestamp = strtotime(str_replace("[", "", substr($matches[1], 0, strpos($matches[1], " "))));
        $tipo = substr($matches[1], strpos($matches[1], " "));
        $errorMessage = $matches[3];
        $erros[] = array(
            "timestamp" => $timestamp,
            "tipo" => $tipo,
            "errorMessage" => $errorMessage
        );
    }
}

fclose($arquivo);

usort($erros, function ($a, $b) {
    return $a["timestamp"] - $b["timestamp"];
});

echo "<h1>Relatório de Erros do Apache</h1>";
echo "<table border='1px'>";
echo "<tr><th width='150px'>Data/Hora</th><th width='200px'>Tipo</th><th width='800px'>Mensagem</th></tr>";

$background = '';
foreach ($erros as $erro) {
    //$background = $erro["tipo"] == 'warn' ? 'style="color:yellow;"': '';
    //$background = $erro["tipo"] == 'error' ? 'style="color:red;"': $background;
    echo "<tr>";
    echo "<td align='center'>" . date("d/m/Y H:i:s", $erro["timestamp"]) . "</td>";
    echo "<td align='center' {$background}>" . $erro["tipo"] . "</td>";
    echo "<td>" . $erro["errorMessage"] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>






