<?php
 session_start();
           
 $name = $_SESSION['name'];
 $email = $_SESSION['email'];
 $table = $_SESSION['table'];
 $id="";
 $name= strtoupper($name);
 $db_server = "localhost";
 $db_user = "root";
 $db_pass = "";
 $db_name = "dhrsystem";
 $conn = "";
 
 $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
 if ($conn) {
     echo" ";
 } else {
     echo "Not connected";
 }
 $stmt = $conn->prepare("SELECT DoctorID FROM $table WHERE email = ?");
    $stmt->bind_param("s", $email);

    // Execute the statement
    $stmt->execute();

    // Store the result
    $stmt->store_result();

    // Check if a user with the given email exists
    if ($stmt->num_rows > 0) {
        // Bind the result
        $stmt->bind_result($id);
        
        // Fetch the result
        $stmt->fetch();

        $_SESSION['id']=$id;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Panel</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: url("background.jpg");
      background-repeat: no-repeat;
      background-size: cover;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px;
    }
  .grid-container {
  display: grid;
  grid-template-columns: 1fr 4fr;
  gap: 10px;
}
    h1 {
      color: #333;
    }
    .button-container {
      display: flex;
      flex-direction: row;
      align-items: center;
      gap: 10px;
      margin-top: 20px;
      justify-content: center;
    }
    .button-container button {
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }
    .button-container button:hover {
      background-color: #45a049;
    }
    .check-info-btn {
      background-color: #008CBA;
    }
    .check-info-btn:hover {
      background-color: #005f73;
    }
   
  .form-container {
    display: none;
    flex-direction: column;
    align-items: center;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
    gap: 10px;
    width: 300px;
    margin-top: 40px;
  }

  .form-container h2 {
    margin-bottom: 20px;
    color: #333;
  }

  .form-container input, .form-container textarea , .form-container select{
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  .form-container button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
  }

  .form-container button:hover {
    background-color: #45a049;
  }
  .tab {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }
    .tab button {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      margin-right: 10px;
      border-radius: 5px;
    }
    .tab button:hover {
      background-color: #45a049;
    }
    .tabcontent {
      display: none;
    }
    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    .data-table th, .data-table td {
      border: 1px solid #ddd;
      padding: 8px;
    }
    .data-table th {
      background-color: #4CAF50;
      color: white;
      text-align: left;
    }
    .data-table tr:nth-child(even) {
      background-color: #f2f2f2;
    }
    .data-table tr:hover {
      background-color: #ddd;
    }
    .input-field {
      text-align: center;
      margin-top: 10px;
      margin-bottom: 20px;
    }
    .input-field input {
      padding: 10px;
      width: 200px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    #patent-info{
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      margin-right: 10px;
      border-radius: 5px;
    }


  </style>
</head>
<body>
<div class="grid-container">
  <div class="grid-item">  
  <h1>Doctor Panel</h1>
  <p>
  <?php echo"<h2> DEAR SIR $name  </h2> " ;
        echo"<h2> YOUR ID: $id  </h2> " ;
  ?>
</p>
</div>
<div class="grid-item">
  
 
  <form action="dataphp/combine.php" method="post">
    
    <button id="patent-info" type="submit" >ADD PATIENT INFO</button>
  </form>
  

  <div class="input-field">
    <form method="get" action="">
      <input type="text" name="patientID" placeholder="Enter Patient ID" value="<?php echo isset($_GET['patientID']) ? htmlspecialchars($_GET['patientID']) : ''; ?>" required />
      <input type="submit" value="Search" />
    </form>
  </div>

  <div class="tab">
    <button onclick="openTab(event, 'diagnosis')">Diagnosis</button>
    <button onclick="openTab(event, 'advice')">Advice</button>
    <button onclick="openTab(event, 'labtest')">Lab Tests</button>
    <button onclick="openTab(event, 'medication')">Medication</button>
    <button onclick="openTab(event, 'history')">History</button>
    <button onclick="openTab(event, 'vitalsigns')">VitalSigns</button>
  </div>

  <div id="diagnosis" class="tabcontent">
    <?php if (isset($_GET['patientID'])) { $table_name = 'diagnosis'; include 'dataphp/fetch_dataDoc.php'; } ?>
  </div>

  <div id="advice" class="tabcontent">
    <?php if (isset($_GET['patientID'])) { $table_name = 'advice'; include 'dataphp/fetch_dataDoc.php'; } ?>
  </div>

  <div id="labtest" class="tabcontent">
    <?php if (isset($_GET['patientID'])) { $table_name = 'labtest'; include 'dataphp/fetch_dataDoc.php'; } ?>
  </div>

  <div id="medication" class="tabcontent">
    <?php if (isset($_GET['patientID'])) { $table_name = 'medication'; include 'dataphp/fetch_dataDoc.php'; } ?>
  </div>

  <div id="history" class="tabcontent">
    <?php if (isset($_GET['patientID'])) { $table_name = 'history'; include 'dataphp/fetch_dataDoc.php'; } ?>
  </div>
  <div id="vitalsigns" class="tabcontent">
    <?php if (isset($_GET['patientID'])) { $table_name = 'vitalsigns'; include 'dataphp/fetch_dataDoc.php'; } ?>
  </div>

</div>
    

  <script>
    

  function openTab(evt, tableName) {
      var i, tabcontent, tablinks;

      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display =  'none' ;
      }

      document.getElementById(tableName).style.display = "block";
    }

    // Automatically open the first tab if a patientID is set
    <?php if (isset($_GET['patientID'])) { ?>
      document.getElementById('diagnosis').style.display = 'block';
    <?php } ?>
  </script>
</body>
</html>
