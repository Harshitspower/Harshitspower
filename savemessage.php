<?php

include('../db-new.php');
include('../db.php');
include('../Web-forms/includes/db1.php');
include('../Web-forms/includes/db-new1.php');

// Check if data is sent via POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from POST request
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Check if professional ID is provided
    if (isset($_POST['professionalId'])) {
        $professionalId = $_POST['professionalId'];

        // Prepare SQL query
        $sql = "INSERT INTO gmail_send_data (subject, message, professionalId) VALUES (?, ?, ?)";

        // Prepare statement
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            // Bind parameters
            $stmt->bind_param("sss", $subject, $message, $professionalId);

            // Execute statement
            if ($stmt->execute()) {
                echo "Data saved successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close statement
            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error: Professional ID is not provided.";
    }
} else {
    echo "Error: Invalid request method.";
}

// Close connection
$conn->close();
?>