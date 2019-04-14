<?php
//This is for the Logout.php error that will show up if it isnt logged in, meaning that it will not be created.
error_reporting(0);
//This includes the connect.inc file, that connects to the database
include('INC/connect.inc');
//This connects to the php code that will send an email when called
include('INC/mailsend.php');
//This connects to the database
$db;
//This starts the session
session_start();
include_once 'header.php';
//This creats the two variables to check if an error happens throughout this page
$error = False;
$errorA = False;
//This code runs once the submit button has been pressed
if(isset($_POST['forgotsubmit'])){
  //This sets all the Post data to a variable so it will become ready to be used
  $email = strtolower($_POST['email']);
  //This creats a random verification key so it blocks other people from being able to change the password of someones account
  $random = rand();
  $hash = hash("sha256", $random);
  //This creats the sql to get the username, email and active status of the user to make sure that the account is a real account and is there
  $sql = "SELECT User, Active FROM loginform WHERE Email = '$email'";
  $result=mysqli_query($db, $sql);
  if(mysqli_num_rows($result)==1){
    $row = mysqli_fetch_array($result);
    $uname = $row['User'];
    $active = $row['Active'];
    //If the user has not been activated then they will get an error telling them that the users account has not beena activated
    if($active == 0){
      $errorA = True;
    }else{
      //If the user was found and it was activated then it will run this code, which creats an sql that will update the verifybit table with the generated hash for the verification link
      $sqlF = "UPDATE loginform SET Verifybit = '$hash' WHERE Email = '$email'";
      if(mysqli_query($db, $sqlF)){
        //Once the verifubit table has been updated, then an email will be sent out with the reset link containing the verify hash and the eamil in the link, aswell with the user name and email of that user
        $forgotpasswordemail = "
        <html><body>
        <br>
        <br>
        Here is your Password Reset Email!
        <br>
        Your Account details are below aswell as your Password Reset link.
        <br>
        <br>
        <br>
        <table rules='all' style='border-color: #666;' cellpadding='10'>
        <tr style='background: #2980b9;'><td></td><td></td>
        <tr style='background: #eee;'><td><strong>Name:</strong> </td><td>$uname</td></tr>
        <tr><td><strong>Email:</strong> </td><td>$email</td></tr>
        <tr><td><strong>Reset:</strong> </td><td>digitech.cas.school.nz:8080/declan/passwordreset.php?email='$email'&hash=$hash</td></tr>
        <tr style='background: #2980b9;'><td></td><td></td>
        </table>
        </body></html>
      ";
        Mail::sendMail('Password Reset', $forgotpasswordemail, $email);
      } else {
        $error = True;
      }
    }
  } else {
    $error = True;
  }
}


?>

<!DOCTYPE html>
<html>
  <head>
    <title> Login </title>
    <link rel="stylesheet" type="text/css" href="CSS/login.css" />
    <link rel="stylesheet" href="https://unpkg.com/ionicons@4.1.2/dist/css/ionicons.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Oleo+Script" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  </head>
  <header>
    <!-- This is the header of the page, with the first child being the bg image
    followed on by the logo, and then the burger menu and motto. -->
    <div class="header-bg"></div>
    <nav>
      <a href="index.php">
        <img src="img/headinglogo.png" />
      </a>
      <a href="javascript:void(0)" id="slide-toggle" class="icon ion-md-menu"></a>
    </nav>
    <div class="container">
      <div class="form">
        <!-- This is the form that the user has to fill out -->
        <form class="login-form" action="#" method="post">
          <!-- This displays the errors for the user -->
          <?php if($errorA){ ?>
          <div class="error"><p>Account has not been Activated<p></div>
          <?php } ?>
          <?php if($error){ ?>
          <div class="verify"><p>Account has not been found!</p></div>
        <?php } ?>
          <div class="form-input">
            <input type="email" name="email" placeholder="Email" required>
          </div>

          <input type="submit" name="forgotsubmit" value="Submit" class="btn-login">

        </form>
    </div>
    </div>
  </header>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
</script>
<script src="JS/index_functions.js">
</script>
<script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
</html>
