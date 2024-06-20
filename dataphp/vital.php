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
  $bloodPressure = htmlspecialchars($_POST['bloodPressure']);
  $date = htmlspecialchars($_POST['date']);
  $temperature = htmlspecialchars($_POST['temperature']);
  $heartRate = htmlspecialchars($_POST['heartRate']);
  $respiratoryRate = htmlspecialchars($_POST['respiratoryRate']);
 

  // Hash the password before storing
  

  // Prepare and bind
  $stmt = $conn->prepare("INSERT INTO vitalsigns (PatientID,Date,Temperature,BloodPressure,HeartRate,RespiratoryRate) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssss", $patientID, $date, $temperature, $bloodPressure,$heartRate,$respiratoryRate);

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