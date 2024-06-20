<?php

$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "dhrsystem";
$patientID ="";
$date="";

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
if (!$conn) {
    echo "Not connected";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $patientID = htmlspecialchars($_POST['patientID']);
    $date = htmlspecialchars($_POST['date']);

    // History section
    if (!empty($_POST['historyDescription'])) {
        $historyDescription = htmlspecialchars($_POST['historyDescription']);
        $stmt = $conn->prepare("INSERT INTO history (PatientID, Date, Description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $patientID, $date, $historyDescription);
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    // Advice section
    if (!empty($_POST['adviceDescription'])) {
        $adviceDescription = htmlspecialchars($_POST['adviceDescription']);
        $stmt = $conn->prepare("INSERT INTO advice (PatientID, Date, Description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $patientID, $date, $adviceDescription);
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    // Medication section
    if (!empty($_POST['medicationName'])) {
        foreach ($_POST['medicationName'] as $index => $medicationName) {
            if (!empty($medicationName)) {
                $dosage = htmlspecialchars($_POST['dosage'][$index]);
                $frequency = htmlspecialchars($_POST['frequency'][$index]);
                $duration = htmlspecialchars($_POST['duration'][$index]);
                $stmt = $conn->prepare("INSERT INTO medication (PatientID, DatePrescribed, Name, Dosage, Frequency, Duration) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $patientID, $date, $medicationName, $dosage, $frequency, $duration);
                if (!$stmt->execute()) {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            }
        }
    }

    // Lab Test section
    if (!empty($_POST['testName'])) {
        foreach ($_POST['testName'] as $index => $testName) {
            if (!empty($testName)) {
                $doctorID = htmlspecialchars($_POST['doctorID'][$index]);
                $stmt = $conn->prepare("INSERT INTO labtest (PatientID, DoctorID, Date, TestName) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $patientID, $doctorID, $date, $testName);
                if (!$stmt->execute()) {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            }
        }
    }

    // Diagnosis section
    if (!empty($_POST['diagnosis'])) {
        $doctorID = htmlspecialchars($_POST['doctorID'][0]); // Use the first doctorID for diagnosis
        $diagnosis = htmlspecialchars($_POST['diagnosis']);
        $stmt = $conn->prepare("INSERT INTO diagnosis (PatientID, DoctorID, Date, DiagnosisText) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $patientID, $doctorID, $date, $diagnosis);
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    session_start();
           
    $_SESSION['patient'] = $patientID;
    $_SESSION['date'] = $date;

    header("Location: \DHR\prescription.php");
}




?>
