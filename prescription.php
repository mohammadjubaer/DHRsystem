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
            LabTestID
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
        *{
    margin: 0;
    padding: 0;
}

h1,h2,h3,h4{
    padding-bottom: 3px;
}
h6{
    font-size: large;
    padding-top: 5px;
}
h5{
    padding-bottom: 30px;
    font-size: larger;
}
#prescriptionDisplay{
    display: grid;
    grid-template-columns: 1.2fr 2fr;
    grid-template-rows: .7fr .2fr 3fr 3fr 1.5fr;
    gap: 10px;
    height:950px;
    width: 650px ;
   
   
}
.doctor-info{
    display: flex;
    flex-direction: column;
    padding-left: 30px;
    grid-area:1/1/2/3;
   
    gap: 5px;

}
.patient-infor{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    justify-items: baseline;
    padding-left: 30px;
    padding-bottom: 30px;
    gap: 5px;
   
    grid-area:2/1/3/3;
 
}
.vital-info{
    grid-area:3/1/4/2;
    display: flex;
    flex-direction: column;
    justify-content: center;
    justify-items: center;
    gap: 5px;
    padding-left: 10px;

}
.lab-test{
    grid-area:4/1/5/2;
    display: flex;
    flex-direction: column;
    justify-content: center;
    justify-items: center;
    gap: 5px;
    padding-left: 10px;
   

}
.medication-info{
    grid-area:3/2/5/3;
    display: flex;
    flex-direction: column;
    justify-content: center;
    justify-items: center;
    padding-top: 50px;
    gap: 5px;
   
   
 }
.pres-footer{
    grid-area:5/1/6/3;
    display: flex;
    flex-direction: column;
    justify-content: center;
    justify-items: end;
    gap: 5px;
    padding-left: 10px;

}
.outer{
    display: flex;
    flex-direction: column;
    justify-content: center;
    justify-items: center;
    height: 80%;
    width: 70%;
   margin-left: 150px;
    background: #99FF99;
    box-sizing: border-box;
    box-shadow: 0 15px 25px rgba(0,0,0,.6);
    border-radius: 10px;

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
        hr{
            height: 1.5px;
            background-color: black;
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
    <div class="outer">

    <div class="prescription-display" id="prescriptionDisplay">

       
        <div class="doctor-info">
                    <h2> <?= htmlspecialchars($prescriptionData['doctorName']) ?></h2>
                    <div><?= htmlspecialchars($prescriptionData['doctorSpecialty']) ?></div>
                    <div>Contact: <?= htmlspecialchars($prescriptionData['doctorContact']) ?></div>
                    <hr>
                </div>
     
        <div class="patient-infor">
                <div><strong>Name:</strong> <?= htmlspecialchars($prescriptionData['patientName']) ?></div>
                <div><strong>Age:</strong> <?= htmlspecialchars($prescriptionData['patientAge']) ?></div>
                <div><strong>Gender:</strong> <?= htmlspecialchars($prescriptionData['patientGender']) ?></div> <hr>
        
            </div>
        <div class="vital-info">
                <div>Temperature: <?= htmlspecialchars($prescriptionData['Temperature']) ?></div><br>
                <div>Blood Pressure: <?= htmlspecialchars($prescriptionData['BloodPressure']) ?></div><br>
                <div>Heart Rate: <?= htmlspecialchars($prescriptionData['HeartRate']) ?></div> <br>
                <div>Respiratory Rate: <?= htmlspecialchars($prescriptionData['RespiratoryRate']) ?></div> <br>
        </div>
        <div class="lab-test">
        <?php foreach ($prescriptionData['labTests'] as $labTest): ?>
                    <div>Test Name: <?= htmlspecialchars($labTest['TestName']) ?></div>
                    <div>labTestID: <?= htmlspecialchars($labTest['LabTestID']) ?></div> <br>
                    <hr>
                <?php endforeach; ?>
        </div>
        <div class="medication-info">
        <?php foreach ($prescriptionData['medications'] as $medication): ?>
                    <div><strong>Medication:</strong> <?= htmlspecialchars($medication['medicationName']) ?><strong>Dosage:</strong> <?= htmlspecialchars($medication['Dosage']) ?></div>
                    <br>
                    <div><strong>Frequency:</strong> <?= htmlspecialchars($medication['Frequency']) ?></div> <br>
                    <div><strong>Duration:</strong> <?= htmlspecialchars($medication['Duration']) ?></div> <br>
                    <hr>
                <?php endforeach; ?>
                <br>
                <br>
                <br>
                <div><?= htmlspecialchars($prescriptionData['DiagnosisText']) ?></div>  
        </div>
        <div class="pres-footer">
        <div class="contact-info">
                <strong>Contact:</strong> <?= htmlspecialchars($prescriptionData['doctorContact']) ?>
                </div>
        </div>
        <!-- Display the prescription here -->
    </div>
    </div>
    <script>
        function downloadPDF() {
            const element = document.getElementById('prescriptionDisplay');
            html2pdf().from(element).save('prescription.pdf');
        }
    </script>
</body>
</html>
