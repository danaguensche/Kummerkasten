<?php

define('SMTP_HOST',     'mail.firma.de');       // SMTP-Server
define('SMTP_PORT',     587);                   // 587 für TLS, 465 für SSL
define('SMTP_SECURE',   'tls');                 // 'tls' oder 'ssl'
define('SMTP_USER',     'absender@firma.de');
define('SMTP_PASS',     'passwort');
define('MAIL_TO',       'empfaenger@firma.de');
define('MAIL_FROM',     'kummerkasten@firma.de');
define('MAIL_FROM_NAME','Kummerkasten');


require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// CORS-Header
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Methode nicht erlaubt']);
    exit;
}

$body = file_get_contents('php://input');
$data = json_decode($body, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Ungültige Anfrage']);
    exit;
}

$gender   = htmlspecialchars($data['gender']   ?? 'Keine Angabe', ENT_QUOTES, 'UTF-8');
$category = htmlspecialchars($data['category'] ?? 'Keine Angabe', ENT_QUOTES, 'UTF-8');
$message  = htmlspecialchars($data['message']  ?? '', ENT_QUOTES, 'UTF-8');
$date     = htmlspecialchars($data['date']     ?? '', ENT_QUOTES, 'UTF-8');
$time     = htmlspecialchars($data['time']     ?? '', ENT_QUOTES, 'UTF-8');

if (empty(trim($message))) {
    http_response_code(400);
    echo json_encode(['error' => 'Nachricht darf nicht leer sein']);
    exit;
}

$mailBody = "
<html>
<body style='font-family: Arial, sans-serif; color: #333; max-width: 600px;'>
    <h2 style='color: #283593; border-bottom: 2px solid #283593; padding-bottom: 8px;'>
        Neuer Kummerkasten-Eintrag
    </h2>
    <table style='width: 100%; border-collapse: collapse; margin-bottom: 16px;'>
        <tr>
            <td style='padding: 8px; background: #f5f5f5; font-weight: bold; width: 140px;'>Datum</td>
            <td style='padding: 8px; border-bottom: 1px solid #eee;'>{$date} um {$time} Uhr</td>
        </tr>
        <tr>
            <td style='padding: 8px; background: #f5f5f5; font-weight: bold;'>Geschlecht</td>
            <td style='padding: 8px; border-bottom: 1px solid #eee;'>{$gender}</td>
        </tr>
        <tr>
            <td style='padding: 8px; background: #f5f5f5; font-weight: bold;'>Kategorie</td>
            <td style='padding: 8px; border-bottom: 1px solid #eee;'>{$category}</td>
        </tr>
    </table>
    <h3 style='color: #283593;'>Nachricht</h3>
    <div style='background: #f9f9f9; border-left: 4px solid #283593; padding: 12px 16px; border-radius: 4px;'>
        {$message}
    </div>
    <p style='color: #999; font-size: 12px; margin-top: 24px;'>
        Diese E-Mail wurde automatisch vom Kummerkasten-System versendet.
    </p>
</body>
</html>
";

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USER;
    $mail->Password   = SMTP_PASS;
    $mail->SMTPSecure = SMTP_SECURE;
    $mail->Port       = SMTP_PORT;
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
    $mail->addAddress(MAIL_TO);

    $mail->isHTML(true);
    $mail->Subject = "Kummerkasten: {$category} - {$date}";
    $mail->Body    = $mailBody;
    $mail->AltBody = "Kategorie: {$category}\nGeschlecht: {$gender}\nDatum: {$date} {$time}\n\nNachricht:\n{$message}";

    $mail->send();

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'E-Mail konnte nicht gesendet werden: ' . $mail->ErrorInfo]);
}