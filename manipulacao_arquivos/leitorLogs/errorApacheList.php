<?php
$path = "error.log";
$arquivo = fopen($path, "r");
$warns = $errors = $notices = $others = array();
$countErrors = $countNotices = $countWarns = $countOthers = 0;
$tabelaErros = $detalhesErros = $tabelaWarns = $detalhesWarns = $tabelaNotices = $detalhesNotices = $tabelaOthers = $detalhesOthers = "";

function geraRelatorio($dados, $tipo)
{
    $tabela = "<table> 
            <thead>
                <tr><th width='200px'>Data/Hora</th><th width='500px'>Mensagem</th><th width='450px'>Arquivo</th><th width='100px'>Linha</th></tr>
            </thead>";
    $tabela .= "<tbody'>";
    foreach ($dados as $dado) {
        $tabela .= "<tr class='detalhes'>
    <td align='center'>{$dado['timestamp']}</td>
    <td>{$dado['mensagem']}</td>
    <td>{$dado['arquivo']}</td>
    <td align='center'>{$dado['linha']}</td>
    </tr>";
    }
    $tabela .= "</tbody></table>";
    return $tabela;
}

while (!feof($arquivo)) {
    // Pegando trechos da linha
    $linha = fgets($arquivo);
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
    // Salvando os trechos em suas respectivas subdivisões
    if (strpos($tipoErro, "warn") !== false) {
        $warns[] = array(
            "timestamp" => $dataHoraErro,
            "tipo" => $tipoErro,
            "linha" => $linhaErro,
            "mensagem" => $mensagemErro,
            "arquivo" => $referer
        );
        $countWarns++;
    } else if (strpos($tipoErro, "notice") !== false) {
        $notices[] = array(
            "timestamp" => $dataHoraErro,
            "tipo" => $tipoErro,
            "linha" => $linhaErro,
            "mensagem" => $mensagemErro,
            "arquivo" => $referer
        );
        $countNotices++;
    } else if (strpos($tipoErro, "error") !== false) {
        $errors[] = array(
            "timestamp" => $dataHoraErro,
            "tipo" => $tipoErro,
            "linha" => $linhaErro,
            "mensagem" => $mensagemErro,
            "arquivo" => $referer
        );
        $countErrors++;
    } else {
        $others[] = array(
            "timestamp" => $dataHoraErro,
            "tipo" => $tipoErro,
            "linha" => $linhaErro,
            "mensagem" => $mensagemErro,
            "arquivo" => $referer
        );
        $countOthers++;
    }
}
fclose($arquivo);

if(!empty($errors)){
    $ultimoMensagemError = end($errors);
    $tabelaErros = geraRelatorio($errors, 'error');
    $detalhesErros = "error";
}else {
    $ultimoMensagemError = array(
        "timestamp" => "-",
        "mensagem" => "",
        "arquivo" => ""
    );
}
if(!empty($warns)){
    $ultimoMensagemWarn = end($warns);
    $tabelaWarns = geraRelatorio($warns, 'warn');
    $detalhesWarns = "warn";
}else {
    $ultimoMensagemWarn = array(
        "timestamp" => "-",
        "mensagem" => "",
        "arquivo" => ""
    );
}
if(!empty($notices)){
    $ultimoMensagemNotice = end($notices);
    $tabelaNotices = geraRelatorio($notices, 'notice');
    $detalhesNotices = "notice";
}else {
    $ultimoMensagemNotice = array(
        "timestamp" => "-",
        "mensagem" => "",
        "arquivo" => ""
    );
}
if(!empty($others)){
    $ultimoMensagemOther = end($others);
    $tabelaOthers = geraRelatorio($others, 'other');
    $detalhesOthers = "other";
}else {
    $ultimoMensagemOther = array(
        "timestamp" => "-",
        "mensagem" => "",
        "arquivo" => ""
    );
}

echo    "<h1>Relatório de Erros do Apache</h1>
        <div>
        <table>
            <thead>
            <tr><th>Tipo</th><th>Quantidade</th><th>Última Data/Hora</th><th colspan='2'>Última Mensagem</th></tr>
            </thead>
            <tbody>
            <tr><th><a href='#' onclick='verDetalhes({$detalhesErros})'>Fatal Errors</a></th><th>{$countErrors}</th><th>{$ultimoMensagemError['timestamp']}</th><th colspan='2'>{$ultimoMensagemError['mensagem']}" . " - " . "{$ultimoMensagemError['arquivo']}</th></tr>
            <tr id='{$detalhesErros}' style='display: none;'><td colspan='5'>{$tabelaErros}</tr></td>
            <tr><th><a href='#' onclick='verDetalhes({$detalhesWarns})'>Warnings</a></th><th>{$countWarns}</th><th>{$ultimoMensagemWarn['timestamp']}</th><th colspan='2'>{$ultimoMensagemWarn['mensagem']}" . " - " . "{$ultimoMensagemWarn['arquivo']}</th></tr>
            <tr id='{$detalhesWarns}' style='display: none;'><td colspan='5'>{$tabelaWarns}</tr></td>
            <tr><th><a href='#' onclick='verDetalhes({$detalhesNotices})'>Notices</a></th><th>{$countNotices}</th><th>{$ultimoMensagemNotice['timestamp']}</th><th colspan='2'>{$ultimoMensagemNotice['mensagem']}" . " - " . "{$ultimoMensagemNotice['arquivo']}</th></tr>
            <tr id='{$detalhesNotices}' style='display: none;'><td colspan='5'>{$tabelaNotices}</tr></td>
            <tr><th><a href='#' onclick='verDetalhes({$detalhesOthers})'>Outros</a></th><th>{$countOthers}</th><th>{$ultimoMensagemOther['timestamp']}</th><th colspan='2'>{$ultimoMensagemOther['mensagem']}" . " - " . "{$ultimoMensagemOther['arquivo']}</th></tr>
            <tr id='{$detalhesOthers}' style='display: none;'><td colspan='5'>{$tabelaOthers}</tr></td>
            </tbody>
        </table>
        </div>";

?>

<script>
    function verDetalhes(id) {
        if(id){
            if (id.style.display === "none") {
            id.style.display = "";
        } else {
            id.style.display = "none";
        }
        }      
    }
</script>

<style>
    table {
        border-collapse: collapse;
        width: 100%;
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

    tr .detalhes:hover {
        background-color: #C0C0C0;
    }
</style>