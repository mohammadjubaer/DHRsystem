<?php
// Database connection parameters
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "dhrsystem";
session_start();
           
$patientID= $_SESSION['patient'];
$date= $_SESSION['date'] ;

try {
    $pdo = new PDO("mysql:host=$db_server;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

function fetchPrescriptionData($pdo, $patientID, $date) {
    // Fetch diagnosis and patient/doctor information
    $stmt = $pdo->prepare("
        SELECT 
            Doctors.Name AS doctorName,
            Doctors.Specialty AS doctorSpecialty,
            Doctors.Email AS doctorContact,
            Patients.Name AS patientName,
            Patients.Age AS patientAge,
            Patients.Gender AS patientGender,
            Patients.ContactNumber AS patientContact,
            VitalSigns.Temperature,
            VitalSigns.BloodPressure,
            VitalSigns.HeartRate,
            VitalSigns.RespiratoryRate,
            Diagnosis.DiagnosisText
        FROM 
            Diagnosis
            JOIN Doctors ON Diagnosis.DoctorID = Doctors.DoctorID
            JOIN Patients ON Diagnosis.PatientID = Patients.PatientID
            LEFT JOIN VitalSigns ON Diagnosis.PatientID = VitalSigns.PatientID AND Diagnosis.Date = VitalSigns.Date
        WHERE 
            Diagnosis.PatientID = :patientID
            AND Diagnosis.Date = :date
    ");
    $stmt->bindParam(':patientID', $patientID);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Fetch medications
    $stmt = $pdo->prepare("
        SELECT 
            Name AS medicationName,
            Dosage,
            Frequency,
            Duration
        FROM 
            Medication
        WHERE 
            PatientID = :patientID
            AND DatePrescribed = :date
    ");
    $stmt->bindParam(':patientID', $patientID);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $result['medications'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch lab tests
    $stmt = $pdo->prepare("
        SELECT 
            TestName,
            Result
        FROM 
            LabTest
        WHERE 
            PatientID = :patientID
            AND Date = :date
    ");
    $stmt->bindParam(':patientID', $patientID);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $result['labTests'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}


    $prescriptionData = fetchPrescriptionData($pdo, $patientID, $date);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        .prescription-display {
            margin-top: 20px;
            border: 1px solid #000;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
            position: relative;
        }
        .prescription-header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .logo {
            width: 80px;
            margin-right: 20px;
        }
        .doctor-info {
            flex: 1;
        }
        .patient-info, .prescription-details {
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
        }
        .footer .contact-info, .footer .timing-info {
            display: inline-block;
        }
        .footer .contact-info {
            margin-right: 20px;
        }
        @media print {
            body {
                margin: 0;
                font-size: 12pt;
            }
            .no-print {
                display: none;
            }
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</head>
<body>
    <h1>Prescription</h1>
   
        <button type="button" onclick="downloadPDF()">Download as PDF</button>


    <div class="prescription-display" id="prescriptionDisplay">
        <?php if (!$prescriptionData): ?>
            <p>No prescription data found for the given patient ID and date.</p>
        <?php else: ?>
            <div class="prescription-header">
                <img src="data:image/png;base64, YOUR_BASE64_IMAGE_DATA" class="logo" alt="Logo">
                <div class="doctor-info">
                    <h2>Dr. <?= htmlspecialchars($prescriptionData['doctorName']) ?></h2>
                    <div><?= htmlspecialchars($prescriptionData['doctorSpecialty']) ?></div>
                    <div>Contact: <?= htmlspecialchars($prescriptionData['doctorContact']) ?></div>
                </div>
            </div>
            <div class="patient-info">
                <h3>Patient Information</h3>
                <div><strong>Name:</strong> <?= htmlspecialchars($prescriptionData['patientName']) ?></div>
                <div><strong>Age:</strong> <?= htmlspecialchars($prescriptionData['patientAge']) ?></div>
                <div><strong>Gender:</strong> <?= htmlspecialchars($prescriptionData['patientGender']) ?></div>
                <div><strong>Contact:</strong> <?= htmlspecialchars($prescriptionData['patientContact']) ?></div>
            </div>
            <div class="prescription-details">
                <h3>Prescription Details</h3>
                <?php foreach ($prescriptionData['medications'] as $medication): ?>
                    <div><strong>Medication:</strong> <?= htmlspecialchars($medication['medicationName']) ?></div>
                    <div><strong>Dosage:</strong> <?= htmlspecialchars($medication['Dosage']) ?></div>
                    <div><strong>Frequency:</strong> <?= htmlspecialchars($medication['Frequency']) ?></div>
                    <div><strong>Duration:</strong> <?= htmlspecialchars($medication['Duration']) ?></div>
                    <hr>
                <?php endforeach; ?>

                <div><strong>Vital Signs</strong></div>
                <div>Temperature: <?= htmlspecialchars($prescriptionData['Temperature']) ?></div>
                <div>Blood Pressure: <?= htmlspecialchars($prescriptionData['BloodPressure']) ?></div>
                <div>Heart Rate: <?= htmlspecialchars($prescriptionData['HeartRate']) ?></div>
                <div>Respiratory Rate: <?= htmlspecialchars($prescriptionData['RespiratoryRate']) ?></div>
                <hr>
                <div><strong>Lab Tests</strong></div>
                <?php foreach ($prescriptionData['labTests'] as $labTest): ?>
                    <div>Test Name: <?= htmlspecialchars($labTest['TestName']) ?></div>
                    <div>Result: <?= htmlspecialchars($labTest['Result']) ?></div>
                    <hr>
                <?php endforeach; ?>

                <div><strong>Diagnosis</strong></div>
                <div><?= htmlspecialchars($prescriptionData['DiagnosisText']) ?></div>
            </div>
            <div class="footer">
                <div class="contact-info">
                    <strong>Contact:</strong> <?= htmlspecialchars($prescriptionData['doctorContact']) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function downloadPDF() {
            const element = document.getElementById('prescriptionDisplay');
            html2pdf().from(element).save('prescription.pdf');
        }
    </script>
</body>
</html>