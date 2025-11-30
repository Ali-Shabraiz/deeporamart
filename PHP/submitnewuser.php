<?php
// Database connection

include 'config.php';
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement (safe from SQL injection)
$stmt = $conn->prepare("INSERT INTO users (Name, Email, Phone,gender, bio) VALUES (?,?,?,?,?)");

// Bind parameters: "sssss" = all 5 values are strings
$stmt->bind_param("sssss", $name, $email, $phone,$DOB,$gender, $bio);

// Get data from POST request
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$gender = $_POST['gender'];
$bio = $_POST['bio'];

// Execute query
if ($stmt->execute()) {
    echo "Record inserted successfully!";
} else {
    echo "Error inserting record: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
