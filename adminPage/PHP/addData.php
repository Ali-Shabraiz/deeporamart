<?php
include "../../PHP/config.php";
$date = date("j/m/Y H:iA");
// Target directory for image upload
$targetDir = "../../assets/img/";
$imagePath = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $sp = $_POST['sp'];
    $price = $_POST['op'];

    // Validate and upload the image
    if (isset($_FILES['itemImage']) && $_FILES['itemImage']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['itemImage']['tmp_name'];
        $originalName = basename($_FILES['itemImage']['name']);
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($extension, $allowed)) {
            // Generate unique filename
            $uniqueName = uniqid("img_") . "." . $extension;
            $destination = $targetDir . $uniqueName;

            // Move the uploaded file
            if (move_uploaded_file($tmpName, $destination)) {
                $imagePath = $uniqueName; // Save this to DB
            } else {
                die("Error moving uploaded image.");
            }
        } else {
            die("Invalid image type. Only JPG, JPEG, PNG, GIF allowed.");
        }
    } else {
           
        die("Image upload failed. Please select a valid image.");
    }

    // Insert into DB using prepared statements
    $stmt = $conn->prepare("INSERT INTO stock (Name, imgPath, op, sp) VALUES (?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssdd", $name,$imagePath,$price,$sp);

    if ($stmt->execute()) {
        echo "Item added successfully.";
    } else {
        echo "Database error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
