
<?php
//This is for the Logout.php error that will show up if it isnt logged in, meaning that it will not be created.
//error_reporting(0);
//This include makes sure the user has logged in otherwise it will redirect them to the login page.
include('INC/session.inc');
//This includes the connect.inc file, that connects to the database
include('INC/connect.inc');
//This connects to the php code that will send an email when called
include('INC/mailsend.php');
//This connects to the database
$db;
include_once 'header.php';
// TODO: Fix the CSS on the this page

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
      <div class="motto">
        <h1>What is on offer, Down Below!</h1>
      </div>
    </nav>
    <div class="scrolldown">
      <p>Scroll Down for More Infomation</p>
       <a href="javascript:void(0)" id= "scrolldownarrow1" class="icon ion-md-arrow-dropdown"></a>
       <a href="javascript:void(0)" id= "scrolldownarrow1" class="icon ion-md-arrow-dropdown"></a>
    </div>
  </header>
  <!-- This is the heading above the card -->
  <div class="headings">
    <h1>Products</h1>
  </div>
  <!-- This is the card, and the card txt, and the link to the next page -->
  <div class="card-windowb">
    <div id="c1b" class="cardb"><div class="cardtxtb">
      <h1><a href="product.php?id=1" class="hirelnk" data-hire='1' id="ctb">DrumKit</a></h1>
    </div></div>
    <div id="c2b" class="cardb2">
      <div class="cardtxtb2">
        <h1><a href="product.php?id=2" class="hirelnk" data-hire='2' id="ctb">Drumsticks</a></h1>
      </div></div>
  </div>
  <!-- This is the card, and the card txt, and the link to the next page -->
  <div class="card-windowb">
    <div id="c3b" class="cardb"><div class="cardtxtb">
      <h1><a href="product.php?id=3" class="hirelnk" data-hire='3' id="ctb">Drumbook</a></h1>
    </div></div>
    <div id="c4b" class="cardb2"><div class="cardtxtb2">
      <h1><a href="product.php?id=4" class="hirelnk" data-hire='4' id="ctb">Drumpads</a></h1>
    </div></div>
  </div>
  <!-- This is the breif section of the code -->
  <div class="headings">
    <h1>Brief</h1>
  </div>
  <div class="brief">
    <p>Comming Soon</p>
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
