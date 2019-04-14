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
// TODO: Fix the css styling for the cart
// TODO: Fix the current bugs with the cart and make it more robust
$db;
include_once 'header.php';
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
  <div class="cart">
    <div class="cart-title">
      Shopping Cart
    </div>
  <?php
  if(!empty($_SESSION['cart'])){
    $count = 0;
    foreach ($_SESSION['cart'] as $ID => $quantity) {
      $count += 1;
      $sql = "SELECT Name, Price from inventory where Item_ID = $ID";
      $result = mysqli_query($db, $sql);
      $row = mysqli_fetch_array($result);
      $name = $row['Name'];
      $price = $row['Price'] * $quantity;
      $productimg = "img/product$ID.jpg";
      $id_Quantity = "quantity-txt$count";
      $id_Price = "price-txt$count";
      $id_Product = "id-product$count";
      $id_remove = "id-remove$count"
      ?>
      <div class="product-container">
        <div class="button">
          <!--<a href="javascript:void(0)" id="remove_btn" class="icon ion-md-close-circle-outline"></a>-->
        </div>
        <div class="product-image">
          <img src=<?php echo"$productimg"; ?> />
        </div>
        <div class="cart-brief">
          <p> <?php echo "$name";?></p>
        </div>
        <div class="product-add">
            <!-- TODO: Make the max number a dynamic amount depending on the database -->
            <input id = <?php echo "$id_Product"; ?> type="hidden" name="ID" value=<?php echo $ID;?>>
            <input id = <?php echo "$id_Price"; ?> type="hidden" name="price" value=<?php echo $price;?>>
            <div class="quantity">
              <button class="plus-btn" type="button" name="button">+</button>
              <input id=<?php echo "$id_Quantity"; ?> type="number" name="name" min ="0" max="2" step="1" value=<?php echo $quantity;?> style="">
              <button class="minus-btn" type="button" name="button">-</button>
            </div>
            <div class="total-price"></div>
          <p> $<?php echo "$price";?></p>
        </div>
      </div>
      <?php
    }
  }
  ?>
  <div class="order">
    <button type="button" name="order" id="order-button">Place Order</button>
  </div>
  <?php
 include_once 'footer.php';
  ?>
</body>
  <!-- This is the javascript that is used to make the animations work -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
  </script>
  <script src="JS/index_functions.js">
  </script>
  <script>
  //TODO : Make a input value to get the quantity, And then carry on with the rest
  $('#order-button').on('click', function(e){
    e.preventDefault();
    var preloader = $('.spinner-wrapper');
    preloader.fadeIn(100);
    var array = [];
    var count = <?php
    if(!empty($_SESSION['cart'])){
      $count = sizeof($_SESSION['cart']) + 1;
    } else {
      $count = 0;
    }
    echo "$count";
    ?>;
    for(i=1; i < count; i++){
      var num = i.toString(),
          id_quantity = "quantity-txt" + num,
          id_price = "price-txt" + num,
          id_product = "id-product" + num;
      var quantity = document.getElementById(id_quantity).value,
          price = document.getElementById(id_price).value,
          product = document.getElementById(id_product).value;
      var product_array = [product, quantity, price];
      array.push(product_array);
    }
    $.ajax({
      type: "POST",
      url: "placeorder.php",
      data: { orderarray : array},
      success: function() {
        alert("Order has been placed")
        var newUrl = "profile.php";
        window.location.href = newUrl;
      }
    });
  });
  $('.minus-btn').on('click', function(e){
    e.preventDefault();
    var $this = $(this);
    var $input = $this.closest('div').find('input');
    var value = parseInt($input.val());

    if(value > 1) {
      value = value - 1;
    } else {
      value = 0;
    }

    $input.val(value);

  });

  $('.plus-btn').on('click', function(e){
    e.preventDefault();
    var $this = $(this);
    var $input = $this.closest('div').find('input');
    var value = parseInt($input.val());

    if(value < 2) {
      value = value + 1;
    } else {
      value = 2;
    }

    $input.val(value);

  });
  </script>
  </body>
</html>
