<?php
session_start();

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    // User is authenticated
    echo json_encode(['authenticated' => true]);
} else {
    // User is not authenticated
    echo json_encode(['authenticated' => false]);
}
?>