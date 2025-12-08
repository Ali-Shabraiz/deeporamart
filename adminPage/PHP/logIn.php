<?php
include "../../PHP/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $name  = $_GET['Name'];
    $pass  = $_GET['pass'];
    $email = $_GET['email'];

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT token FROM our_staff WHERE password = ? AND name = ? AND email = ?");
    $stmt->bind_param("sss", $pass, $name, $email);
    $stmt->execute();

    $stmt->bind_result($token);

    if ($stmt->fetch()) {
        session_start();
        $_SESSION['user']  = $name;
        $_SESSION['token'] = $token;

        header('Location: ../data.php');
        exit;
    } else {
        echo "No record found.";
    }

    $stmt->close();
    $conn->close();
}
?>
