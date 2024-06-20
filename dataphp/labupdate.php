<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "dhrsystem";
$conn = "";

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
if ($conn) {
    echo "You are connected";
} else {
    echo "Not connected";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Collect and sanitize input data
  $labtestID = htmlspecialchars($_POST['labtestID']);
  $result = htmlspecialchars($_POST['result']);

 

  // Hash the password before storing
  

  // Prepare and bind
  $query = "UPDATE LabTest SET Result = ? WHERE LabTestID = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ss", $result, $labtestID);

  // Execute the statement
  if ($stmt->execute()) {
    header("Location: success.php");
  } else {
    echo "Error: " . $stmt->error;
  }

  // Close the statement and connection
  $stmt->close();
  $conn->close();
}
?> 