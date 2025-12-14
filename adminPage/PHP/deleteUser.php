<?php
include "../../PHP/config.php";
$id = $_POST['idd'];                    

if ($conn->connect_error) {
    die("Connection failed");
}
$stmt = $conn->prepare("DELETE FROM users WHERE ID = ?");
$stmt->bind_param("i",  $id);
$stmt->execute();
$stmt->close();
$conn->close();
?>
