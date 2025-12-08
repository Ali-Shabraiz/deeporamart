<?php
header("Content-Type: application/json");
include "../../PHP/config.php";
session_start();

// Check if 'tt' parameter is set
if (isset($_GET['tt'])) {
    $tokenInput = $_GET['tt']; // Remove extra spaces/newlines
    $token_value = $tokenInput;

    // Prepare and execute the token check
   


    // Use get_result for safer fetching
    // $result = $stmt->get_result();
    // print_r($result);
    
    // $row = $result->fetch_assoc();
    // if (mySqli_num_rows) {
        // Token exists, fetch stock data

        $stmt = $conn->prepare("SELECT token FROM our_staff WHERE token = ?");
$stmt->bind_param("s", $token_value);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
$query = "SELECT * FROM stock";
        $res = $conn->query($query);

        if ($res) {
            echo json_encode($res->fetch_all(MYSQLI_ASSOC));
        } else {
            echo json_encode([
                "code" => 500,
                "message" => "Server Error"
            ]);
        }
    } else {
        // 'tt' parameter not provided
        echo json_encode([
            "code" => 400,
            "message" => "Invalid Method"
        ]);
    }
}
else {
        // Token not found
        echo json_encode([
            "code" => 403,
            "message" => "You are not a valid User"
        ]);
    }

$conn->close();
$stmt->close();



        
     

    // Clean up
    // $stmt->close();
   
?>
