<?php
// Database credentials
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "dhrsystem";

// Create connection
$conn = new mysqli($db_server, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$username = $_POST['username'];
$useremail = $_POST['useremail'];
$usermessage = $_POST['usermessage'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO contact_form (name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $useremail, $usermessage);

// Execute the statement
if ($stmt->execute()) {
    header("Location: \DHR\dataphp\success3.php");
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
