<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>LOGIN</title>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="user-box">
            <input type="text" name="email" required="">
            <label>Email</label>
          </div>
          <div class="user-box">
            <input type="password" name="password" required="">
            <label>Password</label>
          </div>
          <div class="user-box">
              <select name="role">
              <option value="Doctors">Doctor</option>
              <option value="Assistants">Assistant</option>
              <option value="Patients">Patient</option>
              </select>
           </div>
          <button type="submit">
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              Submit
            </button>
          <a style="padding-left: 20px;" href="signup.php">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            SIGN UP
          </a>
        </form>
        <?php
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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Collect and sanitize input data
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $role = htmlspecialchars($_POST['role']);

            // Prepare and bind
            $stmt = $conn->prepare("SELECT name, email, password, approved FROM $role WHERE email = ?");
            $stmt->bind_param("s", $email);

            // Execute the statement
            $stmt->execute();

            // Store the result
            $stmt->store_result();

            // Check if a user with the given email exists
            if ($stmt->num_rows > 0) {
                // Bind the result
                $stmt->bind_result($name, $email, $hashed_password, $approved);

                // Fetch the result
                $stmt->fetch();

                // Check if user is approved
                if ($approved) {
                    // Verify the password
                    if ($password === $hashed_password) {
                        // Start a session and store user information
                        session_start();

                        $_SESSION['name'] = $name;
                        $_SESSION['email'] = $email;
                        $_SESSION['table'] = $role;
                        if ($role === "Doctors") {
                            header("Location: docpanel2.php");
                        } elseif ($role === "Assistants") {
                            header("Location: assispanel.php");
                        } elseif ($role === "Patients") {
                            header("Location: patpanel.php");
                        }
                    } else {
                        echo "<p style='color:red;'>Invalid password.</p>";
                    }
                } else {
                    echo "<p style='color:red;'>Your account has not been approved yet.</p>";
                }
            } else {
                echo "<p style='color:red;'>No user found with that email address.</p>";
            }

            // Close the statement and connection
            $stmt->close();
            $conn->close();
        }
        ?>
      </div>
</body>
</html>
