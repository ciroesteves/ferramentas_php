<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$envFilePath = '.env';
$envVariables = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($envVariables as $line) {
    if (strpos($line, '=') !== false) {
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        // Define a variável de ambiente somente se ela ainda não estiver definida
        if (!getenv($key)) {
            putenv("$key=$value");
        }
    }
}

// Configurações do servidor SMTP
$smtpHost = getenv('SMTP_HOST');
$smtpPort = getenv('SMTP_PORT');
$smtpSecure = getenv('SMTP_SECURE');
$smtpUsername = getenv('SMTP_USERNAME');
$smtpPassword = getenv('SMTP_PASSWORD');


try {
    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->Host = $smtpHost;
    $mail->SMTPAuth = true;
    $mail->Username = $smtpUsername;
    $mail->Password = $smtpPassword;
    $mail->SMTPSecure = $smtpSecure;
    $mail->Port = $smtpPort;

    // Informações do remetente e destinatário
    $mail->setFrom($smtpUsername, 'Ciro');
    $mail->addAddress('ciro.esteves@hotmail.com', 'Nome do Destinatário');

    // Assunto e corpo do e-mail
    $mail->Subject = 'Assunto do E-mail de teste da ferramenta';
    $mail->Body = 'Corpo do E-mail do SMPT 549658';

    // Configurar formato do e-mail
    $mail->isHTML(true);

    // Enviar o e-mail
    $mail->send();
    echo 'E-mail enviado com sucesso!';
} catch (Exception $e) {
    echo 'Erro ao enviar o e-mail: ' . $mail->ErrorInfo;
}

?>