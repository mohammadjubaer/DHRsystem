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

// Approve doctor
if (isset($_POST['approve_doctor'])) {
    $doctor_id = $_POST['doctor_id'];
    $conn->query("UPDATE doctors SET approved = TRUE WHERE DoctorID = $doctor_id");
}

// Approve assistant
if (isset($_POST['approve_assistant'])) {
    $assistant_id = $_POST['assistant_id'];
    $conn->query("UPDATE assistants SET approved = TRUE WHERE AssistantID = $assistant_id");
}

// Get counts
$doctor_count = $conn->query("SELECT COUNT(*) as count FROM doctors")->fetch_assoc()['count'];
$assistant_count = $conn->query("SELECT COUNT(*) as count FROM assistants")->fetch_assoc()['count'];
$patient_count = $conn->query("SELECT COUNT(*) as count FROM patients")->fetch_assoc()['count'];

// Get unapproved doctors and assistants
$unapproved_doctors = $conn->query("SELECT * FROM doctors WHERE approved = FALSE");
$unapproved_assistants = $conn->query("SELECT * FROM assistants WHERE approved = FALSE");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Page</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

h1, h2 {
    color: #333;
}

ul {
    list-style-type: none;
    padding: 0;
}

li {
    margin: 10px 0;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <h2>Data Summary</h2>
    <ul>
        <li>Number of Doctors: <?= $doctor_count ?></li>
        <li>Number of Assistants: <?= $assistant_count ?></li>
        <li>Number of Patients: <?= $patient_count ?></li>
    </ul>

    <h2>Approve Doctors</h2>
    <?php while ($doctor = $unapproved_doctors->fetch_assoc()): ?>
        <p>
            <?= isset($doctor['Name']) ? $doctor['Name'] : 'No Name' ?> 
            (<?= isset($doctor['Email']) ? $doctor['Email'] : 'No Email' ?>)
        <form method="POST" style="display:inline;">
            <input type="hidden" name="doctor_id" value="<?= $doctor['DoctorID'] ?>">
            <button type="submit" name="approve_doctor">Approve</button>
        </form>
        </p>
    <?php endwhile; ?>

    <h2>Approve Assistants</h2>
    <?php while ($assistant = $unapproved_assistants->fetch_assoc()): ?>
        <p>
            <?= isset($assistant['Name']) ? $assistant['Name'] : 'No Name' ?> 
            (<?= isset($assistant['Email']) ? $assistant['Email'] : 'No Email' ?>)
        <form method="POST" style="display:inline;">
            <input type="hidden" name="assistant_id" value="<?= $assistant['AssistantID'] ?>">
            <button type="submit" name="approve_assistant">Approve</button>
        </form>
        </p>
    <?php endwhile; ?>

    <h2>Table Data Summary</h2>
    <?php
    $tables = ['medication', 'labtest', 'advice', 'vitalsigns', 'diagnosis'];
    foreach ($tables as $table) {
        $result = $conn->query("SELECT COUNT(*) as count FROM $table")->fetch_assoc();
        echo "<p>Number of $table: " . $result['count'] . "</p>";
    }
    ?>

</body>
</html>
<?php
$conn->close();
?>
