<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>HOME</title>
</head>
<body>
      <!-- navbar section-->
    <nav >
        <div class="nav-contaner">
        <div id="logo">DHR</div>
        <div class="nav_left">
            <div ><a href="#home" class="nav_head">Home</a></div>
            <div ><a href="#about"class="nav_head">About Us</a></div>
            <div ><a href="#features"class="nav_head">Features</a></div>
            <div ><a href="#contact"class="nav_head">Contact</a></div>
        </div>
        </div>
    </nav> 
      <!-- Home section--> 
   <section class="section1" id="home">
    <div id="l1" class="home_3d"> 
        SAVE HISTORY <br>SAVE MONEY <br> MAKE A BETTER HEALTH
    </div>    
    <div id="l2">At Digital Health Record System, we believe in revolutionizing the healthcare industry by providing a modern and efficient solution for managing patient medical records.
         Our system stores all patient information in a secure database, accessible only to authorized doctors and their assistants. 
        Patients can easily view their basic information, 
        <div class="btn-class">
            <a href="signup.php"><button id="up">Sign Up</button></a>
            <a href="login.php"><button id="in">Sign In</button> </a>
        </div>
    </div>
   </section>
   <!-- features section-->
   <div class="section2" id="features">
    <header class="header">
      <p class="header_subtitle">DHR System</p>
      <h1 class="header_title">Our Main Features</h1>
      
    </header>
  
    <main class="card_grid">
      <section class="card card1">
        <h2 class="card_title">Electronic storage of patient medical records</h2>
        <p class="card_content">Electronic storage of patient medical records allows for efficient and 
            secure access to comprehensive medical information, 
            improving patient care and streamlining healthcare processes.</p>
        <img class="card_img" src="https://raw.githubusercontent.com/davidsonaguiar/frontendmentor/main/Four%20card%20feature%20section/images/icon-team-builder.svg" alt="Supervisor">
      </section>
  
      <section class="card card2">
        <h2 class="card_title">Secure access for doctors and doctor's assistants</h2>
        <p class="card_content">Secure access for doctors and doctor's assistants
             ensures patient confidentiality and 
            protects sensitive medical information from unauthorized access.</p>
        <img class="card_img" src="https://raw.githubusercontent.com/davidsonaguiar/frontendmentor/main/Four%20card%20feature%20section/images/icon-supervisor.svg" alt="page-home">
      </section>
  
      <section class="card card3">
        <h2 class="card_title">Prescription and medication management</h2>
        <p class="card-content">Prescription and medication management involves overseeing 
            the proper use and administration of 
            prescribed medications to ensure safe and effective treatment.</p>
        <img class="card_img" src="https://raw.githubusercontent.com/davidsonaguiar/frontendmentor/main/Four%20card%20feature%20section/images/icon-karma.svg" alt="Karma">
      </section>
  
      <section class="card card4">
        <h2 class="card_title">Admin panel for system management and control</h2>
        <p class="card_content">The Admin panel provides a centralized platform for 
            managing and controlling various aspects of the system, 
            such as user access, data management, and system settings.</p>
        <img class="card_img" src="https://raw.githubusercontent.com/davidsonaguiar/frontendmentor/main/Four%20card%20feature%20section/images/icon-calculator.svg" alt="Calculator">
      </section>
    </main>
  </div>
  <div class="section3" id="about">
    <div class="top">
        <h2>About Us</h2>
        <p>At Digital Health Record System, we believe in revolutionizing the healthcare industry by 
            providing a modern and efficient solution for managing patient medical records. Our system 
            stores all patient information in a secure database, accessible only to authorized doctors 
            and their assistants. Patients can easily view their basic information, while the admin panel 
            allows for complete control over all functions. With our advanced technology and user-friendly 
            interface, we aim to streamline the process of managing medical records, ultimately improving 
            the overall quality of patient care. Our team is dedicated to constantly updating and improving 
            our system to meet the ever-changing needs of the healthcare industry.
             Trust in Digital Health Record System for a seamless and secure way of managing patient records.</p>
    </div>
    <div class="bottom">
        <div class="about-flex"><span>OUR TEAM</span></div>
     <div class="card-flex-about">
        <div class="card-about">
          <img src="jubaer.jpg" alt="">
           <h3>Mohammad Jubaer</h3>
           <p>Pursuing CCE(IIUC) </p>
        </div>
        <div class="card-about">
          <img src="shahadat.jpg" alt="">
           <h3>Md Shahadat Hossain</h3>
           <p>Pursuing CCE(IIUC) </p>
        </div>
        <div class="card-about">
          <img src="" alt="">
           <h3>Mainul Hassan Emon</h3>
           <p>Pursuing CCE(IIUC) </p>
        </div>
     </div>

    </div>
  </div>
  <!--contact section-->
  <section class="Contact" id="contact">
    <div class="containercontact">
      <div class="cardcontact">
        <div class="left">
          <img src="ouraddress.jpg">
        </div>
        <div class="right">
          <h2>Contact Us</h2>
          <div class="contact">
            <div class="form-container">
            <form class="form" action="submit_form.php" method="POST">
        <div class="username">
            <input type="text" name="username" placeholder="Enter your Name">
        </div>
        <div class="useremail">
            <input type="email" name="useremail" placeholder="Enter your email" required>
        </div>
        <div class="usermessage">
            <textarea name="usermessage" placeholder="Enter your message" required></textarea>
        </div>
        <div class="usersubmit">
            <input type="submit" value="Contact Us">
        </div>
    </form>
            </div>
            <div class="address">
              <div class="email">
                <h4>Contact</h4>
                <p>mohammadjubaer47@gmail.com</p>
              </div>
              <div class="location">
                <h4>Based in</h4>
                <p>IIUC,<br>Chattogram</p>
              </div>
              <div class="social">
                <span><a href="#"><i class="fab fa-facebook"></i></a></span>
                <span><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></span>
                <span><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>