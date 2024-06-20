<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "dhrsystem";

$patientID = isset($_GET['patientID']) ? $_GET['patientID'] : '';

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if($_SESSION['id'] != $patientID){
    echo"ENTER YOUR ID";
}else{

switch ($table_name) {
    case 'diagnosis':
        $sql = "SELECT Date, DiagnosisText FROM diagnosis WHERE patientid = '$patientID'";
        break;
    case 'advice':
        $sql = "SELECT Date, Description FROM advice WHERE patientid = '$patientID'";
        break;
    case 'labtest':
        $sql = "SELECT Date, TestName, Result FROM labtest WHERE patientid = '$patientID'";
        break;
    case 'medication':
        $sql = "SELECT DatePrescribed, Name, Dosage, Frequency, Duration FROM medication WHERE patientid = '$patientID'";
        break;
    case 'history':
        $sql = "SELECT Date, Description FROM history WHERE patientid = '$patientID'";
        break;
    case 'vitalsigns':
        $sql = "SELECT Date, Temperature, BloodPressure, HeartRate, RespiratoryRate FROM vitalsigns WHERE patientid = '$patientID'";
        break;
    default:
        die("Invalid table name");
}

$result = mysqli_query($conn, $sql);

if ($result === false) {
    echo "Error: " . mysqli_error($conn);
} else {
    if (mysqli_num_rows($result) > 0) {
        echo '<table class="data-table">';
        echo '<tr>';
        // Fetch table headers dynamically
        $fields = mysqli_fetch_fields($result);
        foreach ($fields as $field) {
            echo '<th>' . ucfirst($field->name) . '</th>';
        }
        echo '</tr>';
        // Fetch table rows dynamically
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            foreach ($row as $value) {
                echo '<td>' . htmlspecialchars($value) . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "0 results";
    }
}
}

mysqli_close($conn);
?>




