<?php
include 'conf.php'; // Make sure to include your configuration file

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize user input
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_STRING);

    // Prepare and execute the SQL INSERT statement
    $sql = "INSERT INTO contact_data (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "Thank you for your message! We have received it and will get back to you shortly.";
        
       
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); // Close the prepared statement
} else {
    echo "Invalid request.";
}
?>
