<?php
//This is for the Logout.php error that will show up if it isnt logged in, meaning that it will not be created.
error_reporting(0);
//This includes the connect.inc file, that connects to the database
include('INC/connect.inc');

session_start();
include_once 'header.php';

//These are the variables to check for errors
$errorP = False;
$error = True;
//This checks that the hash and email in the url is not empty
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    //verify
    $email = $_GET['email']; // Set email variable
    $hash = $_GET['hash']; // Set hash variable
    //This creates the sql to check if the email and the verify hash are in the database and are linked with eachother
    $sql = "SELECT email.Email, email.Verifybit FROM loginform AS email WHERE Email=$email AND Verifybit='$hash'";
    $result=mysqli_query($db, $sql);
      //If sql is true then the code will run otherwise an error will happen and the page will be relocated to error.php
      if(mysqli_num_rows($result)==1){
        } else {
          $_SESSION['error'] = 'Reset ';
          echo "<script>location='error.php'</script>";
        }
      } else {
        $_SESSION['error'] = 'Reset ';
        echo "<script>location='error.php'</script>";
      }
//When the reset submit button is pressed the code underneath will run
if(isset($_POST['resetsubmit'])){
  //This sets all the Post data to a variable so it will become ready to be used
  $password = $_POST['password'];
  $confirm = $_POST['confirm-password'];
  $passh = hash('sha256', $password);
  //checks that the passwords match
  if($password == $confirm){
    //creates the sql to update the password that belongs to the email in the url
    $sql = "UPDATE loginform SET Pass = '$passh', Verifybit='Verified' WHERE Email = $email";
    //updates the passowrd and redirects the user to the login page
    if(mysqli_query($db, $sql)){
      echo "<script>location='login.php'</script>";
    } else {
      $error = True;
    }
  } else {
    $errorP = True;
  }
}
 ?>
 <html>
   <head>
     <title> Login </title>
     <link rel="stylesheet" type="text/css" href="CSS/login.css" />
     <link rel="stylesheet" href="https://unpkg.com/ionicons@4.1.2/dist/css/ionicons.min.css" />
     <link href="https://fonts.googleapis.com/css?family=Oleo+Script" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
   </head>
   <header>
     <body>
       <div class="spinner-wrapper">
       <div class="spinner">
     <div class="rect1"></div>
     <div class="rect2"></div>
     <div class="rect3"></div>
     <div class="rect4"></div>
     <div class="rect5"></div>
   </div>
   </div>
     <!-- This is the header of the page, with the first child being the bg image
     followed on by the logo, and then the burger menu and motto. -->
     <div class="header-bg"></div>
     <nav>
       <a href="index.php">
         <img src="img/headinglogo.png" />
       </a>
       <a href="javascript:void(0)" id="slide-toggle" class="icon ion-md-menu"></a>
     </nav>
     <!-- This is the background begind the form-->
     <div class="container">
       <!-- This is the form-->
       <div class="form">
         <form class="login-form" action="#" method="post">
           <!-- These are the error messages-->
           <?php if($errorP){ ?>
           <div class="error"><p>Passwords did not match<p></div>
           <?php } ?>
           <?php if($error){ ?>
           <div class="verify"><p>An Error occured, Please try again Later</p></div>
         <?php } ?>
           <div class="form-input">
             <input type="password" name="password" placeholder="New Password" required>
           </div>
           <div class="form-input">
             <input type="password" name="confirm-password" placeholder="Confirm Password" required>
           </div>

           <input type="submit" name="resetsubmit" value="Reset" class="btn-login">

         </form>
     </div>
     </div>
   </header>
 </body>
 <!-- This is the javascript that is used to make the animations work -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
 </script>
 <script src="JS/index_functions.js">
 </script>
 <script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
 </html>
