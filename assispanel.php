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
 $stmt = $conn->prepare("SELECT AssistantID FROM $table WHERE email = ?");
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
  <title>Assistant Panel</title>
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
    .button-container {
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-top: 20px;
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
  <h1>Assistant Panel</h1>
  <p>
  <?php echo"<h2> HELLO $name  </h2> " ;
        echo"<h2> YOUR ID: $id  </h2> " ;
  ?>
</p>
</div>
  <div class="grid-item">
  
  <div class="button-container">
    <button onclick="toggleForm('vitalSignsForm')">Add vital Signs</button>
    <button onclick="toggleForm('labTestForm')">Add Lab Result</button>
  </div>
  <div id="vitalSignsForm" class="form-container" style="display: none;">
  <h2>Add Vital Signs</h2>
  <form id="vitalSignsFormContent" action="dataphp/vital.php" method="post" >
    <input type="text" name="patientID" placeholder="Patient ID" required />
    <input type="date" name="date" required />
    <input type="number" step="0.1" name="temperature" placeholder="Temperature" required />
    <input type="text" name="bloodPressure" placeholder="Blood Pressure" required />
    <input type="number" name="heartRate" placeholder="Heart Rate" required />
    <input type="number" name="respiratoryRate" placeholder="Respiratory Rate" required />
    <button type="submit">Submit</button>
  </form>
</div>

<div id="labTestForm" class="form-container" style="display: none;">
  <h2>Add Lab Result</h2>
  <form id="labTestFormContent" action="dataphp/labupdate.php" method="post" >
    <input type="text" name="labtestID" placeholder="labtest ID" required />
    <textarea name="result" placeholder="Result" required></textarea>
    <button type="submit">Submit</button>
  </form>
</div>
</div>

  <script>
    function toggleForm(formId) {
  let form = document.getElementById(formId);
  form.style.display = form.style.display === 'none' || form.style.display === '' ? 'flex' : 'none';
  
}
    
  // Reset form after submission
  event.target.reset();
  // Hide form after submission
  document.getElementById('historyForm').style.display = 'none';
  </script>
</body>
</html>
