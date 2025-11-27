<?php
    include "../../PHP/config.php";
    $id = $_POST['id'];
    $query = "DELETE FROM `stock` WHERE `ID` = '$id'";
    $result = mysqli_query($conn, $query) or die("Failed to run Query");
    mysqli_close($conn);
?>