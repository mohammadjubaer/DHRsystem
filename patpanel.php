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
 $stmt = $conn->prepare("SELECT PatientID FROM $table WHERE email = ?");
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
  <title>Patient Panel</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f8ff;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px;
    }
    h1 {
      color: #333;
    }
    h2{
      color: #345;
    }
    p{
      padding: 0px;
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
.grid-container {
  display: grid;
  grid-template-columns: 1fr 4fr;
  gap: 10px;
}

  </style>
</head>
<body>
<div class="grid-container">
  <div class="grid-item">  
    <h1>Patient Panel</h1>
  <p>
  <?php echo"<h2> HI $name  </h2> " ;
        echo"<h2> YOUR ID: $id  </h2> " ;
  ?>
</p>
</div>
  <div class="grid-item">
    <div class="input-field">
    <form method="get" action="">
      <input type="text" name="patientID" placeholder="Enter Your Patient ID" value="<?php echo isset($_GET['patientID']) ? htmlspecialchars($_GET['patientID']) : ''; ?>" required />
      <input type="submit" value="Search" />
    </form>
  </div>
  <div class="tab">
    <button onclick="openTab(event, 'advice')">Advice</button>
    <button onclick="openTab(event, 'medication')">Medication</button> 
  </div>
  <div id="advice" class="tabcontent">
    <?php if (isset($_GET['patientID'])) { $table_name = 'advice'; include 'dataphp/fetch_data.php'; } ?>
  </div>
  <div id="medication" class="tabcontent">
    <?php if (isset($_GET['patientID'])) { $table_name = 'medication'; include 'dataphp/fetch_data.php'; } ?>
  </div>
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
  </script>
</body>
</html>
