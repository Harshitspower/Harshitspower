<?php
include('../db-new.php');
include('../db.php');
include('../Web-forms/includes/db1.php');
include('../Web-forms/includes/db-new1.php');

$sql = "SELECT * FROM gmail_send_data ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Data found
    $row = $result->fetch_assoc();
    $data = array(
        'subject' => $row['subject'],
        'message' => $row['message']
    );
    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // No data found
    header("HTTP/1.0 404 Not Found");
    echo json_encode(array('error' => 'No data found'));
}
?>