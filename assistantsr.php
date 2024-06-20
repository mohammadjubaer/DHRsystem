
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css">
    <title>SIGNUP</title>
</head>
<body>
    <div class="form_wrapper">
        <div class="form_container">
          <div class="title_container">
            <h2> Registration Form</h2>
          </div>
          <div class="row clearfix">
            <div class="">
              <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <div class="input_field"> <span><i aria-hidden="true" class="fa fa-envelope"></i></span>
                <input type="text" name="name" placeholder="Name" required />
                </div>
                <div class="input_field"> <span><i aria-hidden="true" class="fa fa-lock"></i></span>
                <input type="email" name="email" placeholder="Email" required />

                </div>
                <div class="input_field"> <span><i aria-hidden="true" class="fa fa-lock"></i></span>
                <input type="password" name="password" placeholder="Password" required />
                </div>
                
                <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                <input type="text" name="doctorid" placeholder="Doctor ID" required />
                </div>
                <input class="button" type="submit" value="Register" />
             </form>
            </div>
          </div>
        </div>
    </div>
</body>
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
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']);
  $doctorid = htmlspecialchars($_POST['doctorid']);

  // Hash the password before storing
  

  // Prepare and bind
  $stmt = $conn->prepare("INSERT INTO assistants (name, email, password, doctorid) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $name, $email, $password, $doctorid);

  // Execute the statement
  if ($stmt->execute()) {
    header("Location: confermation.php");
  } else {
    echo "Error: " . $stmt->error;
  }

  // Close the statement and connection
  $stmt->close();
  $conn->close();
}
?>  
        