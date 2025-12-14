<?php
include "./config.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $pass  = $_GET['pass'];
    $email = $_GET['email'];

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT * FROM users WHERE promoCode = ? AND email = ?");
    $stmt->bind_param("ss", $pass,  $email);
    $stmt->execute();

    // $stmt->bind_result($promoCode);

    if ($stmt->fetch()) {
        session_start();
        $_SESSION['email']  = $email;
        $_SESSION['token'] = $pass;

        header('Location: ../workplace/');
        exit;
    } else {
        header('Location: ../');
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>
