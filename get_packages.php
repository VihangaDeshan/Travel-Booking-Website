<?php
include 'conf.php';

// Initialize an array to store travel packages
$packages = [];

// SQL query to retrieve travel packages
$sql = "SELECT * FROM packages";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $packages[] = $row;
        }
    } else {
        // Handle the case where no packages are found (optional).
        // You can set an error message or an empty array.
        // Example: $packages = ['error' => 'No packages found'];
    }
} else {
    // Handle any database query errors.
    // Example: $packages = ['error' => $conn->error];
}

// Output travel packages as JSON
echo json_encode($packages);

// Debugging: Log the JSON data before sending it
error_log(json_encode($packages)); // This will log the JSON data to your server's error log

$conn->close();
?>
