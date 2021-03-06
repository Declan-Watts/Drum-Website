<?php
//This is for the Logout.php error that will show up if it isnt logged in, meaning that it will not be created.
// error_reporting(0);
//This include checks if the user is logged in and if they are not logged in then it will redirect them to the login page
include('INC/session.inc');
include_once 'header.php';
// TODO: Fix the css for this page and fill the brief, profile image and welcome text

 ?>
 <!DOCTYPE html>
 <html>
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
       <li><a class="active" href="profile.php">User Home</a></li>
       <li><a href="attendance.php">Attendance/upcomming events</a></li>
       <li><a href="application.php">Application/Order Details</a></li>
       <li><a href="report.php">Reports</a></li>
       <li><a href="contactprofile.php">Contact Details</a></li>
       <li style = "float: right;"><a href="settings.php">Settings</a></li>
     </ul>
   </div>
   <!-- This is the breif section of the code -->
   <div class="headings">
     <!-- This is the code to welcome the user to the website-->
     <h1>Welcome <?=$_SESSION['login_user'] ?></h1>
   </div>
   <div class="brief">
     <p>This is your profile page, You can view your orders and change your settings here.</p>
   </div>
   <?php include_once 'footer.php';
   ?>
 </body>
   <!-- This is the javascript that is used to make the animations work -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
   </script>
   <script src="JS/index_functions.js">
   </script>
 </body>
 </html>
