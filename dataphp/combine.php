<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Combined Form</title>
  <style>
    .form-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      justify-items: center;
      background-color: #387B9A;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-top: 20px;
      gap: 10px;
      width: 100%;
      margin-top: 40px;
      color: #FFFFFF;
    }

    .form-container h2, .form-container h3 {
        margin-bottom: 20px;
        color: #FFFFFF;
    }

    .form-container input, .form-container textarea, .form-container select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-color: #70AFCE;
      color: #FFFFFF;
      font-size: larger;
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

    .add-section {
      background-color: #007BFF;
      margin-top: 10px;
    }

    .add-section:hover {
      background-color: #0056b3;
    }

    .remove-section {
      background-color: #FF0000;
      margin-top: 10px;
    }

    .remove-section:hover {
      background-color: #cc0000;
    }

    .section {
      margin-bottom: 20px;
    }
  </style>
  <script>
    function addSection(sectionType) {
      const section = document.getElementById(sectionType + 'Section');
      const clone = section.cloneNode(true);
      clone.querySelectorAll('input').forEach(input => input.value = '');
      clone.querySelector('.remove-section').style.display = 'inline-block';
      document.getElementById(sectionType + 'Container').appendChild(clone);
    }

    function removeSection(button) {
      button.parentElement.remove();
    }
  </script>
</head>
<body>
  <div id="combinedForm" class="form-container">
    <h2>Add Patient Information</h2>
    <form action="\DHR\dataphp\combined.php" method="post">
      <!-- Common Inputs -->
      <input type="text" name="patientID" placeholder="Patient ID" required />
      <input type="date" name="date" required />
      
      <!-- History Section -->
      <h3>History</h3>
      <textarea name="historyDescription" placeholder="History Description"></textarea>
      
      <!-- Advice Section -->
      <h3>Advice</h3>
      <textarea name="adviceDescription" placeholder="Advice Text"></textarea>
      
      <!-- Medication Section -->
      <h3>Medication</h3>
      <div id="medicationContainer">
        <div id="medicationSection" class="section">
          <input type="text" name="medicationName[]" placeholder="Medication Name" />
          <input type="text" name="dosage[]" placeholder="Dosage" />
          <input type="text" name="frequency[]" placeholder="Frequency" />
          <input type="text" name="duration[]" placeholder="Duration" />
          <button type="button" class="remove-section" onclick="removeSection(this)" style="display:none;">Remove</button>
        </div>
      </div>
      <button type="button" class="add-section" onclick="addSection('medication')">Add Medication</button>
      
      <!-- Lab Test Section -->
      <h3>Lab Test</h3>
      <div id="labTestContainer">
        <div id="labTestSection" class="section">
          <input type="text" name="doctorID[]" placeholder="Doctor ID" />
          <input type="text" name="testName[]" placeholder="Test Name" />
          <button type="button" class="remove-section" onclick="removeSection(this)" style="display:none;">Remove</button>
        </div>
      </div>
      <button type="button" class="add-section" onclick="addSection('labTest')">Add Lab Test</button>
      
      <!-- Diagnosis Section -->
      <h3>Diagnosis</h3>
      <textarea name="diagnosis" placeholder="Diagnosis"></textarea>
      
      <button type="submit">Submit</button>
    </form>
  </div>
</body>
</html>
