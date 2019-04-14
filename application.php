<?php
//This is for the Logout.php error that will show up if it isnt logged in, meaning that it will not be created.
error_reporting(0);
//This include checks if the user is logged in and if they are not logged in then it will redirect them to the login page
include('INC/session.inc');
include('INC/connect.inc');
include_once 'header.php';
$db;
$UID = $_SESSION['login_ID'];
 ?>
<!DOCTYPE html>
<html>
  <header>
    <!-- This is the header of the page, with the first child being the bg image
     followed on by the logo, and then the burger menu and motto. -->
    <div class="header-bg"></div>
    <nav>
      <!-- DD Logo -->
      <a href="index.php">
        <img src="img/headinglogo.png" />
      </a>
      <a href="javascript:void(0)" id="slide-toggle" class="icon ion-md-menu"></a>
      <h1>Hello
        <?=ucwords($_SESSION['login_user']) ?>!</h1>
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
      <li><a class="active" href="application.php">Application/Order Details</a></li>
      <li><a href="report.php">Reports</a></li>
      <li><a href="contactprofile.php">Contact Details</a></li>
      <li style="float: right;"><a href="settings.php">Settings</a></li>
    </ul>
  </div>
  <!-- This is the breif section of the code -->
  <div class="headings">
    <!-- This is the code to welcome the user to the website-->
    <h1>Applications</h1>
  </div>
  <hr>
  <div class="applications">
    <?php
    //Applications Get
    //This first gets all of the different applications ID and Status that the client's account has put through into the database.
     $sql = "SELECT app.APP_ID, app.Status FROM applications as app INNER JOIN parents on app.ParentID = parents.ParentID WHERE parents.ID = $UID";
     $result = mysqli_query($db, $sql);
     if(mysqli_num_rows($result) > 0){
       //If there is more than one result, it will then display all of the applications as card for the user to click on, which will then use AJAX to load the information through load-app.php
       while($row = mysqli_fetch_array($result)){
         $App_ID = $row['APP_ID'];
         $App_status = $row['Status'];
         ?>
    <div class='book_card' style='visibility: visible'>
      <a class='applnk' href='#' data-timeslot=<?php echo"$App_ID"; ?>>
        <p1>Application ID:
          <?php echo "$App_ID"; ?>
        </p1>
        <br>
        <p1>Status:</p1>
        <p2>
          <?php echo "$App_status"; ?>
          <p2>
      </a>
    </div>
    <?php
       }
     } else {
       ?>
    <h1> There is No Applications </h1>
    <?php
     }
     ?>
  </div>
  <hr>
  <div class="headings">
    <!-- This is the code to welcome the user to the website-->
    <h1>Orders</h1>
  </div>
  <hr>
  <div class="applications">
    <?php
    //This works the same way that Applicatoins works except it does it for the users orders
     $sql = "SELECT Order_ID, Status FROM orders WHERE ID=$UID";
     $result = mysqli_query($db, $sql);
       while($row = mysqli_fetch_array($result)){
         $Order_ID = $row['Order_ID'];
         $Order_status = $row['Status'];
         ?>
    <div class='book_card' style='visibility: visible'>
      <a class='orderlnk' href='#' data-timeslot=<?php echo" $Order_ID"; ?>>
        <p1>Order ID:
          <?php echo "$Order_ID"; ?>
        </p1>
        <br>
        <p1>Status:</p1>
        <p2>
          <?php echo "$Order_status"; ?>
          <p2>
      </a>
    </div>
    <?php
       }
     ?>
  </div>
  <hr style="padding: 0 0 100px;">
  <!-- This is the darck background behind the form-->
  <div class="bg-model" style="display: none;">
    <!-- This is the white box where the information is-->
    <div class="model-content" style="display: none;">
      <!-- This is the content inside of the white box -->
      <div class="model-content-inner">
        <div class="formhead">
          <a href="javascript:void(0)" id="form-close" class="icon ion-md-close-circle-outline" style="z-index: 400;"></a>
        </div>
        <div id="information">
        </div>
      </div>
    </div>
  </div>
  <?php include_once 'footer.php';
  ?>
   <!-- This is the javascript that is used to make the animations work -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
   </script>
   <script src="JS/index_functions.js">
   </script>
   <script>
     $(document).ready(function(){
       $(".orderlnk").click(function(e){
         //prevent default link click
         e.preventDefault();
         var orderid = $(this).data('timeslot');
         $("#information").load("load-orders.php", {
           orderidNew: orderid
         });
         //get the data from the link that was clicked
         //modify the form so when the user submits it the field is sent
         //tip, you can change the input from type="text" to type="hidden"
         //so the user cannot see it, but for example purpose it's easier to show it.
         $('.bg-model').fadeIn(1000);
         $('.model-content').show(1000);
       });
      $(".applnk").click(function(e){
        //prevent default link click
        e.preventDefault();
        var appid = $(this).data('timeslot');
        $("#information").load("load-app.php", {
          appidNew: appid
        });
        //get the data from the link that was clicked
        //modify the form so when the user submits it the field is sent
        //tip, you can change the input from type="text" to type="hidden"
        //so the user cannot see it, but for example purpose it's easier to show it.
        $('.bg-model').fadeIn(1000);
        $('.model-content').show(1000);
      });
       $('#form-close').click(function(e){
         e.preventDefault();
         $('.bg-model').fadeOut(500);
         $('.model-content').fadeOut(300);
       });
     });
   </script>
 </body>
</html>
