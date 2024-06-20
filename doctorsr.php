<?php

include("database.php");

?>


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
                <input type="text" name="specialty" placeholder="Specialty" required /> 
                </div>
                  
                <input class="button" type="submit" value="Register" />
              </form>
            </div>
          </div>
        </div>
    </div>
</body>
<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){

        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        
        $name = htmlspecialchars($_POST['name']);
        $specialty = htmlspecialchars($_POST['specialty']);
      
        
        $sql= "INSERT INTO Doctors (Name,Email,Password,Specialty)
               VALUES ('$name','$email','$password','$specialty')";
        mysqli_query($conn,$sql);
        header("Location: confermation.php");
        exit();  
        
}
        mysqli_close($conn);    
        
?>