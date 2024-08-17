<?php
// update.php
// Establish a connection to the MySQL database
$servername = "localhost";
$username   = "root";
$password   = "217200";
$dbname     = "IOT";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if userID is provided
$userID = null;
$user = array();
$message = '';

if (isset($_GET['userID'])) {
    $userID = intval($_GET['userID']);

    // Retrieve user data
    $sql = "SELECT first_name, last_name, Gmail FROM user WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        die("User not found.");
    }
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update user data
    $userID = intval($_POST['userID']);
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];

    $sql = "UPDATE user SET first_name = ?, last_name = ?, Gmail = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $firstName, $lastName, $email, $userID);

    if ($stmt->execute()) {
        $message = "Update successful";
    } else {
        $message = "Error updating record: " . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="c.css">
    <style>
        body 
        {
            background-image: url("college.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
}

        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Ensure transparency */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 600px;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center content horizontally */
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            width: 100%; /* Make inputs fill container width */
        }

        button {
            background-color: #007bff; /* Blue color for update button */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%; /* Make button fill container width */
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            color: green;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }

        .message.error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Update User Information</h1>
        <form method="post">
            <input type="hidden" name="userID" value="<?php echo htmlspecialchars($userID); ?>">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['Gmail']); ?>" required>
            <button type="submit">Update</button>
        </form>
        <?php if (!empty($message)): ?>
            <p class="message <?php echo strpos($message, 'Error') === false ? '' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php endif; ?>
    </div>
</body>
</html>
