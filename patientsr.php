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
                    <input type="number" name="age" placeholder="Age" required />
                    </div>
                  
                  
                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                    <input type="text" name="contactnumber" placeholder="Contact Number" required />
                    
                    </div>
                  
                
                    <div class="input_field radio_option">
                      <input type="radio" name="radiogroup1" id="rd1" value="Male">
                      <label for="rd1">Male</label>
                     <input type="radio" name="radiogroup1" id="rd2" value="Female">
                     <label for="rd2">Female</label>
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
        $age = htmlspecialchars($_POST['age']);
        $contactnumber = htmlspecialchars($_POST['contactnumber']);
        $gender = isset($_POST['radiogroup1']) ? htmlspecialchars($_POST['radiogroup1']) : '';
       
        
        $sql= "INSERT INTO patients (Name,Email,Password,Age,Gender,ContactNumber)
               VALUES ('$name','$email','$password','$age','$gender','$contactnumber')";
        mysqli_query($conn,$sql);
        header("Location: confermation.php"); 
        exit(); 
        
}
        mysqli_close($conn);    
        
?>