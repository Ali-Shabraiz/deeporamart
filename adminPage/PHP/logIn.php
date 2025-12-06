<?php
include "../../PHP/config.php";
    $name = $_POST['Name'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
    $stmt = $conn->prepare("SELECT * FROM our_staff WHERE password = ? AND name = ? AND email = ?");
    $stmt->bind_param("sss", $pass,$name,$email);
    $stmt->execute();
    $result = $stmt->get_result();

if ($result->num_rows > 0) {
     session_start();
     $_SESSION['user'] = $_POST['Name'];
     header('Location: ./data.html');
} else {
    echo "No record found.";
}

    $stmt->close();
    $conn->close();


?>