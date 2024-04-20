<?php
// Start session
session_start();

include('../db-new.php');
include('../db.php');
include('../Web-forms/includes/db1.php');
include('../Web-forms/includes/db-new1.php');
// Include Google Client Library
require_once 'vendor/autoload.php'; // Path to your autoload.php file


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

try {
    if (isset($_GET["code"])) {
        // Fetch access token using the authorization code
        $client->authenticate($_GET['code']);
        $_SESSION['access_token'] = $client->getAccessToken();
    }

    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
        $client->setAccessToken($_SESSION['access_token']);

        $access_token = $client->getAccessToken();

        if ($client->isAccessTokenExpired()) {
            // Refresh the access token
            $client->fetchAccessTokenWithRefreshToken();
            $_SESSION['access_token'] = $client->getAccessToken();
        }

        $google_service = new Google_Service_Oauth2($client);
        $data = $google_service->userinfo->get();
        
        $_SESSION['email'] = $data->email;
        $access_token = $_SESSION['access_token'];
        $email = $data->email;

        $sql = "SELECT * FROM gmailauthentication WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // User already exists, update access token
            $sql_update = "UPDATE gmailauthentication SET access_token = '" . json_encode($access_token) . "' WHERE email = '$email'";
            if ($conn->query($sql_update) === TRUE) {
                echo "Access token updated successfully!";
            } else {
                echo "Error updating access token: " . $conn->error;
            }
        } else {
            // User doesn't exist, insert new record
            $sql_insert = "INSERT INTO gmailauthentication (access_token, email) VALUES ('" . json_encode($access_token) . "', '$email')";
            if ($conn->query($sql_insert) === TRUE) {
                echo "Authentication code saved successfully!";
            } else {
                echo "Error inserting authentication code: " . $conn->error;
            }
        }

        // Redirect to main page
        // Determine the authentication type based on the origin URL
        $originUrl = isset($_SESSION['origin_url']) ? $_SESSION['origin_url'] : '';
        $authenticationType = '';

        if ($originUrl == "http://localhost/Dashboard-CS/DIR3-KYC(Web)/home.php") {
            $authenticationType = 'authenticationtype=DIR3-KYC(Web)';
        } elseif ($originUrl == "http://localhost/Dashboard-CS/gmailbulk/gmailbulk.php") {
            $authenticationType = 'authenticationtype=Gmailbulking';
        }

        // Redirect to the origin URL with authenticationtype parameter
        $redirectUrl = $originUrl;
        if ($authenticationType) {
            $redirectUrl .= (parse_url($redirectUrl, PHP_URL_QUERY) ? '&' : '?') . $authenticationType;
        }
        header('Location: ' . $redirectUrl);
        exit;
       }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>