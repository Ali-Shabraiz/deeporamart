<?php
include "../../PHP/config.php";
$id = $_POST['idd'];          
$promoCode = $_POST['promoCode'];          

if ($conn->connect_error) {
    die("Connection failed");
}
$stmt = $conn->prepare("UPDATE users SET promoCode = ? WHERE ID = ?");
$stmt->bind_param("si", $promoCode, $id);
$stmt->execute();
$stmt->close();
$conn->close();
?>
