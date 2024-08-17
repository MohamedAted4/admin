<?php
$servername = "localhost";
$username   = "root";
$password   = "217200";
$dbname     = "IOT";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if studentID is provided
if (isset($_POST['userID'])) {
    $userID = intval($_POST['userID']); // Ensure the userID is an integer to prevent SQL injection

    // Delete user from the user table
    $sql_user = "DELETE FROM user WHERE user_id = ?";
    $stmt = $conn->prepare($sql_user);
    $stmt->bind_param("i", $userID);

    if ($stmt->execute()) {
        echo "User and all related data have been removed.";
    } else {
        echo "Error removing user: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    echo "User ID not provided.";
}

mysqli_close($conn);
?>
