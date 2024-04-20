<?php
// Start session
session_start();

// Include the autoload file
require_once __DIR__ . '/vendor/autoload.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['access_token'])) {
    http_response_code(403); // Forbidden
    echo json_encode(['error' => 'You are not authenticated']);
    exit;
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the user is authenticated    
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['captionSubject']) || !isset($data['captionMessage']) || !isset($data['emails'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Subject, message, and recipient email are required']);
        exit;
    }
    // Retrieve form data
    $captionSubject = $data['captionSubject'];
    $captionMessage = $data['captionMessage'];
    $emails = $data['emails'];
    $attachmentFile = isset($_FILES['attachmentFile']) ? $_FILES['attachmentFile'] : null;

    // Get email and access token from session
    $email = $_SESSION['email'];
    $accessToken = $_SESSION['access_token']['access_token'];

    // Initialize Google client
    $client = new Google_Client();
    $client->setAccessToken($accessToken);

    // Initialize Gmail service
    $service = new Google_Service_Gmail($client);

    $sendAsList = $service->users_settings_sendAs->listUsersSettingsSendAs('me');
    $signature = '';

    foreach ($sendAsList->getSendAs() as $sendAs) {
        if ($sendAs->getIsPrimary()) {
            $signature = $sendAs->getSignature();
            break;
        }
    }

    // Append signature to the message body
    $captionMessage .= "<br><br>" . $signature;
    $captionMessage = str_replace(
        array('<span class="ql-font-serif">', '</span>', '<span class="ql-font-monospace">'),
        array('<span style="font-family: serif;">', '</span>', '<span style="font-family: monospace;">'),
        $captionMessage
    );
    // $captionMessage = '<div style="font-family: Times New Roman, serif;">' . $captionMessage . '</div>';

    // Prepare the email content with inline styles
    $mime = "From: $email\r\n"
        . "To: " . implode(',', $emails) . "\r\n"
        . "Subject: $captionSubject\r\n"
        . "MIME-Version: 1.0\r\n"
        . "Content-Type: multipart/mixed; boundary=\"boundary_separator\"\r\n\r\n";

    // Adding message body with inline styles
    $mime .= "--boundary_separator\r\n"
    . "Content-Type: text/html; charset=UTF-8\r\n"
    . "Content-Transfer-Encoding: quoted-printable\r\n"
    . "\r\n"
    . quoted_printable_encode($captionMessage)
    . "\r\n";

    // Attach file if provided
    if ($attachmentFile && $attachmentFile['tmp_name']) {
        $fileContent = file_get_contents($attachmentFile['tmp_name']);
        $attachment = base64_encode($fileContent);
        $mime .= "--boundary_separator\r\n"
            . "Content-Type: application/octet-stream; name=\"" . $attachmentFile['name'] . "\"\r\n"
            . "Content-Disposition: attachment; filename=\"" . $attachmentFile['name'] . "\"\r\n"
            . "Content-Transfer-Encoding: base64\r\n"
            . "\r\n"
            . $attachment
            . "\r\n";
    }

    $mime .= "--boundary_separator--";

    // Send email
    try {
        $msg = new Google_Service_Gmail_Message();
        $msg->setRaw(strtr(base64_encode($mime), '+/', '-_'));
        $sentEmail = $service->users_messages->send('me', $msg);
        echo json_encode(['success' => true]); // Send success response
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'An error occurred while sending email', 'details' => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}
?>