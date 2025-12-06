<?php
include "../../PHP/config.php";
    $name = $_POST['Name'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
    echo $name;
    echo $pass;
    echo $email;
    $stmt = $conn->prepare("SELECT * FROM our_staff WHERE password = ?");
    $stmt->bind_param("s", $pass);
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