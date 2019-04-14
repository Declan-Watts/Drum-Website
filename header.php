 <!DOCTYPE html>
 <!-- TODO: make the links have the url have a get in them so if you need too login first, when you login, it will take you too the right page
<html>
  <head>
    <!-- This is the Title of the page and the style sheets/fonts/icons that are linked -->
    <title> Drum lessons </title>

    <link rel="stylesheet" type="text/css" href="CSS/index.css" />
    <link rel="stylesheet" href="https://unpkg.com/ionicons@4.1.2/dist/css/ionicons.min.css" />
    <link href='http://fonts.googleapis.com/css?family=Oleo+Script' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="icon" href="img/headinglogo2.png" />
  </head>
  <body>
  <!-- This is the side bar that appears when the burger menu is clicked -->
  <div id="sidenav">
    <a href="javascript:void(0)" id="slide-close" class="icon ion-md-close-circle-outline"></a>
    <div id="sidenav-wrapper">
      <h1>Menu</h1>
      <a href="index.php">
        Home
      </a>
      <?php if(!$_SESSION['logged_in']){ ?>
      <a href="login.php">
        Login
      </a>
      <?php } ?>
      <?php if($_SESSION['logged_in']){ ?>
      <a href="profile.php">
        My Profile
      </a>

      <a href="cart.php">
        My Cart <?php if(!empty($_SESSION['cart'])){
          $items = sizeof($_SESSION['cart']);
          echo "($items)";
        } else {
          echo "(0)";
        } ?>
      </a>
      <a href="logout.php">
        Logout
      </a>
    <?php } ?>
      <h1>Some more Great options to choose from</h1>
      <a href="under_construction.php">
        Recent News
      </a>
      <a href="under_construction.php">
        Up Comming Events
      </a>
      <a href="drum_booking.php">
        Book With Us
      </a>
      <a href="under_construction.php">
        See Our Teachers
      </a>
      <a href="under_construction.php">
        Who Are We?
      </a>
      <a href="equipmenthire.php">
        Buy/Hire Equipment
      </a>
      <a href="under_construction.php">
        Our Reviews
      </a>
      <a href="under_construction.php">
        Contact Us
      </a>
    </div>
  </div>
</body>
</html>
