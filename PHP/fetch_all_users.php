<?php
    header("Content-type: Application/JSON");
    include "config";
    $query = "SELECT * FROM `users`";
    $result = mysqli_query($connection, $query) or die("Failed to run Query");
    $assoc = mysqli_fetch_all($result,MYSQLI_ASSOC);
    echo json_encode($assoc);
    mysqli_close($connection);  
?>