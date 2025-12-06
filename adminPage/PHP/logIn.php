<?php
include "../../PHP/config.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $name = $_GET['Name'];
    $pass = $_GET['pass'];
    $email = $_GET['email'];
}
    $stmt = $conn->prepare("SELECT * FROM our_staff WHERE password = ? AND name = ? AND email = ?");
    $stmt->bind_param("sss", $pass,$name,$email);
    $stmt->execute();
    $result = $stmt->get_result();
if ($result->num_rows > 0) {
     session_start();
     $_SESSION['user'] = $_GET['Name'];
     header('Location: ../data.php');
} else {
    echo "No record found.";
}

    $stmt->close();
    $conn->close();


?>