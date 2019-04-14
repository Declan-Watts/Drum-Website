<?php
// TODO: Allow to change their contact information
//This is for the Logout.php error that will show up if it isnt logged in, meaning that it will not be created.
error_reporting(0);
//This include checks if the user is logged in and if they are not logged in then it will redirect them to the login page
include('INC/connect.inc');
include('INC/session.inc');
include_once 'header.php';

$db;

$UID = $_SESSION['login_ID'];
//Gets the data from the database that is needed for the users contact info
$sql = "SELECT ParentID, ParentFN, ParentLN, Contact_Email, PH FROM parents WHERE ID = $UID";
//This get the result from the database, and then adds them too variables.
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);
$fname = $row['ParentFN'];
$lname = $row['ParentLN'];
$email = $row['Contact_Email'];
$phone = $row['PH'];

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
       <li><a class="active" href="contactprofile.php">Contact Details</a></li>
       <li style = "float: right;"><a href="settings.php">Settings</a></li>
     </ul>
   </div>
   <!-- This is the breif section of the code -->
   <div class="headings">
     <!-- This is the code to welcome the user to the website-->
     <h1>Contact Information</h1>
   </div>
   <div class="brief">
     <!-- This does an echo of all of the information that is needed for
      the contact information page -->
     <p>First Name: <?php echo "$fname";?></p>
     <hr>
     <p>Last Name: <?php echo "$lname";?></p>
     <hr>
     <p>Email: <?php echo "$email";?></p>
     <hr>
     <p>Phone Number: <?php echo "$phone";?></p>
     <hr>
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
