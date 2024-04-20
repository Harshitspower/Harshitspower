<?php

// Start session
session_start();


// Include Google Client Library
require_once 'vendor/autoload.php';


// Initialize Google Client
$client = new Google_Client();
$client->setAuthConfig('client_credentials.json'); // Path to your client credentials JSON file
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/Dashboard-CS/gmailbulk/oauth2callback.php');
$client->setAccessType('offline'); //Added for Refresh Token
$client->setApprovalPrompt('force'); //Added for Refresh Token
$client->addScope(Google_Service_Oauth2::USERINFO_EMAIL);
$client->addScope(Google_Service_Oauth2::USERINFO_PROFILE);
$client->addScope("https://www.googleapis.com/auth/gmail.compose");
$client->addScope('https://www.googleapis.com/auth/gmail.send');
$client->addScope('https://www.googleapis.com/auth/gmail.settings.basic');
$client->addScope('https://www.googleapis.com/auth/gmail.settings.sharing');

$originUrl = isset($_GET['originUrl']) ? $_GET['originUrl'] : '';

// Store origin URL in the session
$_SESSION['origin_url'] = $originUrl;

$authUrl = $client->createAuthUrl();

echo json_encode(['authUrl' => $authUrl]);
exit;

?>