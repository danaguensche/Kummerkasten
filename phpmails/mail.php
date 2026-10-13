<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Access-Control-Allow-Origin: https://kuka');
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

$data = json_decode(file_get_contents('php://input'), true);

if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['error' => 'Ungültige Anfrage']);
    exit;
}

$gender   = htmlspecialchars($data['gender'] ?? 'Keine Angabe', ENT_QUOTES, 'UTF-8');
$category = htmlspecialchars($data['category'], ENT_QUOTES, 'UTF-8');
$building = htmlspecialchars($data['building'], ENT_QUOTES, 'UTF-8');
$group    = htmlspecialchars($data['group'], ENT_QUOTES, 'UTF-8');
$message  = trim($data['message'] ?? '');
$date     = htmlspecialchars($data['date'] ?? '', ENT_QUOTES, 'UTF-8');
$time     = htmlspecialchars($data['time'] ?? '', ENT_QUOTES, 'UTF-8');

if ($category === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Kategorie darf nicht leer sein']);
    exit;
}

if ($building === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Gebäude darf nicht leer sein']);
    exit;
}

if ($group === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Gruppe darf nicht leer sein']);
    exit;
}

if ($message === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Nachricht darf nicht leer sein']);
    exit;
}

$messageHtml = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));
$messageText = trim($message);

$mailBody = "
<html>
<body style='font-family: Arial, sans-serif; color: #333; max-width: 600px;'>
    <h2>Neuer Kummerkasten-Eintrag</h2>
    <table style='width:100%; border-collapse: collapse; margin-bottom:16px;'>
        <tr>
            <td style='padding:8px; font-weight:bold; width:140px;'>Datum</td>
            <td style='padding:8px;'>{$date} um {$time} Uhr</td>
        </tr>
        <tr>
            <td style='padding:8px; font-weight:bold;'>Geschlecht</td>
            <td style='padding:8px;'>{$gender}</td>
        </tr>
        <tr>
            <td style='padding:8px; font-weight:bold;'>Kategorie</td>
            <td style='padding:8px;'>{$category}</td>
        </tr>
    </table>
    <h3>Nachricht</h3>
    <div style='background:#f9f9f9; padding:12px 16px; border-radius:4px;'>
        {$messageHtml}
    </div>
</body>
</html>
";

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = getenv('SMTP_HOST');
    $mail->Port       = (int)getenv('SMTP_PORT');
    $mail->SMTPAuth   = true;
    $mail->Username   = getenv('SMTP_USER');
    $mail->Password   = getenv('SMTP_PASS');
    $mail->CharSet    = 'UTF-8';

    $secure = getenv('SMTP_SECURE');
    if ($secure === 'tls') {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    } elseif ($secure === 'ssl') {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    }

    $mail->setFrom(getenv('MAIL_FROM'), getenv('MAIL_FROM_NAME'));
    $mail->addAddress(getenv('MAIL_TO'));

    $mail->isHTML(true);
    $mail->Subject = "Kummerkasten: {$category} - {$date}";
    $mail->Body    = $mailBody;
    $mail->AltBody = "Kategorie: {$category}\nGeschlecht: {$gender}\nDatum: {$date} {$time}\n\nNachricht:\n{$messageText}";

    $mail->send();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'E-Mail konnte nicht gesendet werden']);
}
