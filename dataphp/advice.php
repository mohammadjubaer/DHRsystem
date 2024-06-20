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
  $patientID = htmlspecialchars($_POST['patientID']);
  $date = htmlspecialchars($_POST['date']);
  $description = htmlspecialchars($_POST['description']);
 

  // Hash the password before storing
  

  // Prepare and bind
  $stmt = $conn->prepare("INSERT INTO advice (PatientID,Date,Description) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $patientID, $date, $description);

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