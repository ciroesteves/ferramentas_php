<?php
require 'vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Configurações do servidor SMTP
$smtpHost = getenv('SMTP_HOST');
$smtpPort = getenv('SMTP_PORT');
$smtpUsername = getenv('SMTP_USERNAME');
$smtpPassword = getenv('SMTP_PASSWORD');

echo $smtpHost;
/*
// Use as variáveis para configurar o PHPMailer
$mail->Host = $smtpHost;
$mail->Port = $smtpPort;
$mail->Username = $smtpUsername;
$mail->Password = $smtpPassword;

// Informações do remetente e destinatário
$mail->setFrom('ciro.esteves@hotmail.com', 'Ciro');
$mail->addAddress('ciro.esteves05@gmail.com', 'Ciro destino');

// Assunto e corpo do e-mail
$mail->Subject = 'Email de teste';
$mail->Body = 'Estou realizando um teste.';
*/
?>