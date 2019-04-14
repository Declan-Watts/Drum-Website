<?php
// TODO: Make this more informative
//This is for the Logout.php error that will show up if it isnt logged in, meaning that it will not be created.
error_reporting(0);
//This starts the session
session_start();
include_once 'header.php';
?>

<!DOCTYPE html>
<html>
  <header>
    <!-- This is the header of the page, with the first child being the bg image
    followed on by the logo, and then the burger menu-->
    <div class="header-bg"></div>
    <nav>
      <a href="index.php">
        <img src="img/headinglogo.png" />
      </a>
      <!-- This diplays the text saying that the link that they used was not found-->
      <a href="javascript:void(0)" id="slide-toggle" class="icon ion-md-menu"></a>
      <h1 style="z-index: 200; color: white; font: 400 100px/1.3'Oleo Script';">There was an email verification sent, Please accept two log in.</h1>
    </nav>
  </header>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
</script>
<script src="JS/index_functions.js">
</script>
<script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
</html>
