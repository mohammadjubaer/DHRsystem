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
  $doctorID = htmlspecialchars($_POST['doctorID']);
  $date = htmlspecialchars($_POST['date']);
  $testName = htmlspecialchars($_POST['testName']);
 

  // Hash the password before storing
  

  // Prepare and bind
  $stmt = $conn->prepare("INSERT INTO labtest (PatientID,DoctorID,Date,TestName) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $patientID, $doctorID, $date, $testName);

  // Execute the statement
  if ($stmt->execute()) {
    header("Location: success2.php");
  } else {
    echo "Error: " . $stmt->error;
  }

  // Close the statement and connection
  $stmt->close();
  $conn->close();
}
?> 