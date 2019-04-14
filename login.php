<?php
// TODO: Use a GET to load the user onto the correct page that they were trying too enter into
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
//This is the variable that will be set to true if there is an error
$error = false;

//This checks if the user is looged in or not
if($_SESSION['logged_in']){
  $_SESSION['logged_in'] = True;
} else {
  $_SESSION['logged_in'] = False;
}
//This sets the message for the session to display a certain text if i want it too
$_SESSION['message'] = '';
//This code is run once the LOGIN form submit button is pressed
if(isset($_POST['submit'])){
  //This sets the post values to variables to be used in arrays and so on.
  $uname=strtolower($_POST["username"]);
  $password=$_POST["password"];
  $passh = hash("sha256", $password);
  $error = false;
  //This creates the sql to be entered into the database
  $sql="SELECT name.Avatar, name.ID FROM loginform AS name WHERE User='".$uname."' AND Pass='".$passh."' AND Active = 1";
  $result=mysqli_query($db, $sql);
  $row = mysqli_fetch_array($result);
  $avatarimg = $row['Avatar'];
  $UID = $row['ID'];
  //If the user was found then the sessions will be set to logged in and avatar image will be set to the avatar directory and the logged in user will be set to the username that was entered into the form
  if(mysqli_num_rows($result)==1){
    $_SESSION['login_user']=$uname;
    $_SESSION['login_ID']=$UID;
    $_SESSION['logged_in'] = True;
    $_SESSION['Avatar']=$avatarimg;
    echo "<script>location='profile.php'</script>";
  }
  else {
    $error = true;
  }
}

$verify = False;
/*

This was used earlier on in the websites life but has been removed due too me deciding that
only parents of students will have accounts meaning you have too apply for a place to have
an account on the website.

//This code will run when the submit button is pressed on the form, and all the inputs that are required are filled.
if(isset($_POST['register'])){

    //Making sure passwords match
    if($_POST['password'] == $_POST['confirmpassword']){
      //This sets all the Post data to a variable so it will become ready to be used
      $uname = strtolower($_POST['username']);
      $email = strtolower($_POST['email']);
      $password = $_POST['password'];
      $passh = hash("sha256", $password); //Hashing the Password
      $random = rand();
      $hash = hash("sha256", $random); //hashing the random string of numbers
      //This creates the sql to insert the user into the database
      $sql = "INSERT INTO loginform (ID, User, Email, Avatar, Verifybit, Pass) VALUES (NULL, '$uname', '$email', 'image/default.jpg', '$hash', '$passh')";
      //This inserts the user into the database and then sends a verification email to the users email address
      if(mysqli_query($db, $sql)){
        $registeremail = "
        <html><body>
        <br>
        <br>
        Thanks for signing up!
        <br>
        Your Account has been created, but you cant login until you verify your email.
        <br>
        Your Account details are below aswell as your email Verification link.
        <br>
        <br>
        <br>
        <table rules='all' style='border-color: #666;' cellpadding='10'>
        <tr style='background: #2980b9;'><td></td><td></td>
        <tr style='background: #eee;'><td><strong>Name:</strong> </td><td>$uname</td></tr>
        <tr><td><strong>Email:</strong> </td><td>$email</td></tr>
        <tr style='background: #eee;'><td><strong>Password:</strong> </td><td>$password</td></tr>
        <tr><td><strong>Verification:</strong> </td><td>digitech.cas.school.nz:8080/declan/verify.php?email='$email'&hash=$hash</td></tr>
        <tr style='background: #2980b9;'><td></td><td></td>
        </table>
        </body></html>
        ";
          Mail::sendMail('Verification Email', $registeremail, $email);
          $verify = True;
      }
      else{
        $_SESSION['message'] = "Username or Email Already Taken!";
      }
    }
    else {
      $_SESSION['message'] = "Passwords did not match!";
    }
} */

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

    <!-- This is the blue box behind the form-->
    <div class="container">
      <!-- This is the LOGIN form-->
      <div class="form">
        <form class="login-form" action="login.php" method="post">
          <!-- These are the error messages-->
          <?php if($error){ ?>
          <div class="error"><p>Username or Password is Incorrect<p></div>
          <?php } ?>
          <?php if($verify){ ?>
          <div class="verify"><p>Email Verification has been Sent!</p></div>
        <?php } ?>
        <div class="alert"><?= $_SESSION['message'] ?></div>
          <div class="form-input">
            <input type="text" name="username" placeholder="User Name" required>
          </div>
          <div class="form-input">
            <input type="password" name="password" placeholder="Password" required>
          </div>
          <input type="submit" name="submit" value="Login" class="btn-login">
          <p class="message"> Not a booked with us?  <a href='drum_booking.php'> Book Here?</a></p>
          <p class="forgotPass">Forgot your Passowrd?   <a href='forgotpass.php'>Click Here! </a></p>

        </form>
        <!-- This is the register form

        This was used earlier on in the websites life but has been removed due too me deciding that
        only parents of students will have accounts meaning you have too apply for a place to have
        an account on the website.

        <form class="registration-form" action="login.php" method="post">
          <div class="alert"><?= $_SESSION['message'] ?></div>
          <div class="form-input">
           <input type="text" placeholder="User Name" name="username" required />
          </div>
          <div class="form-input">
           <input type="email" placeholder="Email" name="email" required />
          </div>
          <div class="form-input">
           <input type="password" placeholder="Password" id="password" name="password" required />
          </div>
          <div class="form-input">
           <input type="password" placeholder="Confirm Password" id="confirm_password" name="confirmpassword" required />
          </div>
          <input type="submit" name="register" value="Register" class="btn-register">
          <p class="message"> Already have an account, <a href='#'> Login?</a></p>
        </form>
      -->
    </div>
    </div>
  </header>
</body>
<!-- These are the java script links, forthe animations used for the code-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
</script>
<script src="JS/index_functions.js">
</script>
<script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
</html>
