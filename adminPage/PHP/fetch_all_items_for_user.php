<?php
header("Content-Type: application/json");
include "../../PHP/config.php";
session_start();

// Check if 'tt' parameter is set

    // Prepare and execute the token check
   


    // Use get_result for safer fetching
    // $result = $stmt->get_result();
    // print_r($result);
    
    // $row = $result->fetch_assoc();
    // if (mySqli_num_rows) {
        // Token exists, fetch stock data


$query = "SELECT Name,imgPath,para,sp FROM stock";
        $res = $conn->query($query);

        if ($res) {
            echo json_encode($res->fetch_all(MYSQLI_ASSOC));
        } else {
            echo json_encode([
                "code" => 500,
                "message" => "Server Error"
            ]);
        }
    

$conn->close();

    // Clean up
    // $stmt->close();
   
?>
