<?php
// TODO: Add more possibly wanted settings
//This is for the Logout.php error that will show up if it isnt logged in, meaning that it will not be created.
//error_reporting(0);
//This include checks if the user is logged in and if they are not logged in then it will redirect them to the login page
include('INC/connect.inc');
include('INC/mailsend.php');
include('INC/session.inc');
include_once 'header.php';
$db;

//This is started if the button for the password reset is clicked
if(isset($_POST['passsubmit'])){
  $passold = $_POST['passold'];
  $passnew = $_POST['passnew'];
  $passnewconf = $_POST['passnewconf'];
  $UID = $_SESSION['login_ID'];
  //This checks too see if the new passwords match
  if($passnew == $passnewconf){
    //This checks too see if the old password matches to the one in the database
    $passoldhash = hash('sha256', $passold);
    $sql = "SELECT ID from loginform WHERE Pass = '$passoldhash' and ID = $UID";
    if(mysqli_query($db, $sql)){
      //This creates the hashed version of the new password if the old one is correct
      //And then it uploads the new password too the databse replacing the old one
      $passnewhash = hash('sha256', $passnew);
      $sqlPassUpdate = "UPDATE loginform SET Pass = '$passnewhash' WHERE loginform.ID = $UID ";
      if(mysqli_query($db, $sqlPassUpdate)){
        echo "<script>location='profile.php?success'</script>";
      } else {
        echo "Sorry there was an issue in changing the password";
      }
    }else {
      echo "Old password was not correct";
    }
  } else {
    echo "Passwords did not match";
  }
}
// This works the same way pass reset does except at the end it creates a new varification
//email for the user to open in his email.
if(isset($_POST['emailsubmit'])){
  $email = $_POST['email'];
  $emailr = $_POST['emailrepeat'];
  $UID = $_SESSION['login_ID'];
  $random = rand();
  $hash = hash('sha256', $random);
  $uname = $_SESSION['login_user'];

  if($email == $emailr){
    $sql = "UPDATE loginform SET Email = '$email', Verifybit = '$hash' WHERE loginform.ID = $UID";
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
      <tr><td><strong>Verification:</strong> </td><td>digitech.cas.school.nz:8080/declan/verify.php?email='$email'&hash=$hash</td></tr>
      <tr style='background: #2980b9;'><td></td><td></td>
      </table>
      </body></html>
      ";
        Mail::sendMail('Verification Email', $registeremail, $email);
        echo "email verification was sent, please click the link";
    } else {
      echo "Error occured at this stage";
    }
  } else {
    echo "Emails did not match";
  }
}

 ?>
 <!DOCTYPE html>
 <html>
   <header>
     <!-- This is the header of the page, with the first child being the bg image
     followed on by the logo, and then the burger menu and motto. -->
     <div class="header-bg"></div>
     <nav>
       <a href="index.php">
         <img src="img/headinglogo.png" />
       </a>
       <a href="javascript:void(0)" id="slide-toggle" class="icon ion-md-menu"></a>
         <h1>Hello <?=ucwords($_SESSION['login_user']) ?>!</h1>
       </div>
       <!-- This is the code to display the users avatar-->
       <div class="profileIMG">
         <img src=<?=$_SESSION['Avatar'] ?> width="180" height="180">
       </div>
     </nav>
   </header>
   <div class="menus">
     <ul>
       <li><a href="profile.php">User Home</a></li>
       <li><a href="attendance.php">Attendance/upcomming events</a></li>
       <li><a href="application.php">Application/Order Details</a></li>
       <li><a href="report.php">Reports</a></li>
       <li><a href="contactprofile.php">Contact Details</a></li>
       <li style = "float: right;"><a class='active' href="settings.php">Settings</a></li>
     </ul>
   </div>
   <!-- This is the breif section of the code -->
   <div class="headings">
     <!-- This is the code to welcome the user to the website-->
     <h1>Settings</h1>
   </div>
   <div class="Settings">
     <hr>
     <form class="settingsform" action="#" method="post">
       <div class="titles">
         <h1>Change Password</h1>
       </div>
       <input type="password" name="passold" placeholder="Old Password" required>
       <input type="password" name="passnew" placeholder="New Password" required>
       <input type="password" name="passnewconf" placeholder="Repeat New Password" required>
       <input type="submit" name="passsubmit" value="Submit">
     </form>
     <hr>
     <form class="settingsform" action="#" method="post">
       <div class="titles">
         <h1>Change Email</h1>
       </div>
       <input type="email" name="email" placeholder="Enter New Email" required>
       <input type="email" name="emailrepeat" placeholder="Repeat Email" required>
       <input type="submit" name="emailsubmit" value="Submit">
     </form>
     <hr>
     <!-- This uses the upload.php page to change the profile piccture -->
     <form class="settingsform" action="upload.php" method="post" enctype="multipart/form-data">
       <div class="titles">
         <h1>Update Profile Image</h1>
       </div>
       <input type="file" name="fileupload" required>
       <input type="submit" name="filesubmit" value="Submit">
     </form>
     <hr style="padding: 0 0 100px;">
   </div>
   <?php include_once 'footer.php';
   ?>
   <!-- This is the javascript that is used to make the animations work -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
   </script>
   <script src="JS/index_functions.js">
   </script>
 </body>
 </html>
