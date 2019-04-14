<?php
//This is for the Logout.php error that will show up if it isnt logged in, meaning that it will not be created.
error_reporting(0);
//This starts the session
session_start();
include_once 'header.php';
// TODO: Make Phone version of the website
 ?>


<!DOCTYPE html>
<html>
<meta name=”viewport” content=”width=device-width, initial-scale=1″>
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
  <header>
    <!-- This is the header of the page, with the first child being the bg image
    followed on by the logo, and then the burger menu and motto. -->
    <div class="header-bg"></div>
    <nav>
      <a href="index.php">
        <img src="img/headinglogo.png" />
      </a>
      <a href="javascript:void(0)" id="slide-toggle" class="icon ion-md-menu"></a>
      <div class="motto">
        <h1>Learn to play Drums, Learn to play them well!</h1>
      </div>
    </nav>
    <div class="scrolldown">
      <p>Scroll Down for More Infomation</p>
       <a href="javascript:void(0)" id= "scrolldownarrow1" class="icon ion-md-arrow-dropdown"></a>
       <a href="javascript:void(0)" id= "scrolldownarrow1" class="icon ion-md-arrow-dropdown"></a>
    </div>
  </header>
  <!-- This is the heading above each card -->
  <div class="headings">
    <h1>Want Lessons?</h1>
  </div>
  <!-- This is the card, and the card txt, and the link to the next page -->
  <div class="card-window">
    <div id="c1" class="card"></div>
    <div class="cardtxt">
      <h1><a href="drum_booking.php" id="ct">Book With Us!</a></h1>
    </div>
  </div>
  <!-- This is the heading above each card -->
  <div class="headings">
    <h1>What Do We Offer?</h1>
  </div>
  <!-- This is the card, and the card txt, and the link to the next page -->
  <div class="card-window">
    <div id="c2" class="card"></div>
    <div class="cardtxt">
      <h1><a href="#" id="ct">Find Out!</a></h1>
    </div>
  </div>
  <!-- This is the heading above each card -->
  <div class="headings">
    <h1>Need Gear?</h1>
  </div>
  <!-- This is the card, and the card txt, and the link to the next page -->
  <div class="card-window">
    <div id="c3" class="card"></div>
    <div class="cardtxt">
      <h1><a href="equipmenthire.php" id="ct">Purchace/Hire</a></h1>
    </div>
  </div>
  <!-- This is the heading above each card -->
  <div class="headings">
    <h1>Got Any Questions?</h1>
  </div>
  <!-- This is the card, and the card txt, and the link to the next page -->
  <div class="card-window">
    <div id="c4" class="card"></div>
    <div class="cardtxt">
      <h1><a href="#" id="ct">Contact Us!</a></h1>
    </div>
  </div>
  <!-- This is the breif section of the code -->
  <div class="headings">
    <h1>Brief</h1>
  </div>
  <div class="brief">
    <p>My name is Declan Watts and I offer drum lessons. Feel free to email any questions too Declan.drumming@gmail.com</p>
  </div>
  <?php include_once 'footer.php';
  ?>
</body>
  <!-- This is the javascript that is used to make the animations work -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
  </script>
  <script src="JS/index_functions.js">
  </script>
</html>
