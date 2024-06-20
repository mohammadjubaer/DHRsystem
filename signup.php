


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
            <h2> Registration In Which Group</h2>
          </div>
          <div class="row clearfix">
            <div class="">
              <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                
                    <div class="input_field select_option">
                      <select name="role">
                      <option value="Doctor">Doctor</option>
                      <option value="Assistant">Assistant</option>
                      <option value="Patient">Patient</option>
                      </select>
                      <div class="select_arrow"></div>
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

       
        $role = htmlspecialchars($_POST['role']);
        if($role==="Doctor"){
          header("Location: doctorsr.php");
        }elseif ($role==="Patient") {
          header("Location: patientsr.php");
        }elseif ($role==="Assistant") {
          header("Location: assistantsr.php");
        }else {
          echo"Select any group";
        }
      
          
        
}
   

?>