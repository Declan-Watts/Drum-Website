<?php
// TODO: Make the css better for this page
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

if(isset($_GET['id'])){
  $productID = $_GET['id'];
  $productimg = "img/product$productID.jpg";
  $sql = "SELECT Description, Price from inventory where Item_ID = $productID";
  $result = mysqli_query($db, $sql);
  $row = mysqli_fetch_array($result);
  $desc = $row['Description'];
  $price = $row['Price'];
}

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
    <h1>insert info</h1>
  </div>
  <div class="product-container">
    <div class="product-image">
      <img src=<?php echo"$productimg"; ?> />
    </div>
    <div class="product-brief">
      <p><?php echo "$desc";?></p>
    </div>
    <div class="product-add">
      <p> $<?php echo "$price";?></p>
      <form class="product" action="add_to_cart.php" method="post">
        <!-- TODO: Make the max number a dynamic amount depending on the database -->
        <input type="hidden" name="ID" value=<?php echo $productID;?>>
        <input type="number" name="quantity" min ="0" max="2" step="1" value="1">
        <input type="submit" name="add" value="submit">
      </form>
    </div>
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
