<?php

// TODO: Allow the user too check a box too say that they are already a current user, or check if they are currently logged in
// TODO: Tidy up functions to make this more readable and legable, also try turn this into a class
error_reporting(0);
//This includes the connect.inc file, that connects to the database
include('INC/connect.inc');
//This connects to the php code that will send an email when called
include('INC/mailsend.php');
//This connects to the database
$db;
//This starts the session
session_start();
include_once 'header.php';
//This is the sql for getting what days are open for lessons
$sql="SELECT Day, Time FROM days_teaching WHERE Booked IS NULL";
//This is creating the variable to connect to the database and then put in the sql
$result=mysqli_query($db, $sql);
//This creates the array for the times that are open and free
$ARR_BOOK = [];
//This creats the days that i am currently teaching
$ARR_DAYS = ['Tues', 'Fri', 'Sat'];
//This loops through the data that was collected about what days i have available, and then adds them to the array
while($row = mysqli_fetch_array($result)){
  $ARR_BOOK[] = $row;
}

// TODO: Make this page join into a success page

//This checks if the parents are in the database and if they are in the database then it will then grab the ID of that parent and return it
function ParentCheck($parentfn, $parentln, $email, $db){
  $sql_parent_check = "SELECT ParentID FROM parents WHERE ParentFN = '$parentfn' AND ParentLN = '$parentln' AND Contact_Email = '$email'";
  $resultp = mysqli_query($db, $sql_parent_check);
  if(mysqli_num_rows($resultp)==1){
    $rowp = mysqli_fetch_array($resultp);
    $PID = $rowp['ParentID'];
    echo "Hello";
    return $PID;
  } else {

  }
}

//This checks if the student of the parent is in the database, and if it is then it will grab its ID, and then run the applicatoin Insert function
//If the student is not found it will add the student then run through this code again
function StudentCheck($studentfn, $studentln, $PID, $time, $studentage, $studentgender, $db){
  $sql_student_check = "SELECT StudentID FROM students WHERE StudentFN = '$studentfn' AND StudentLN = '$studentln' AND ParentID = $PID";
  $resultc = mysqli_query($db, $sql_student_check);
  echo "Student is being checked";
  if(mysqli_num_rows($resultc)==1){
    echo "Student Has Been Checked";
    $rowc = mysqli_fetch_array($resultc);
    $SID = $rowc['StudentID'];
    ApplicationInsert($PID, $SID, $time, $db);
  } else {
    echo "Student is being added 1";
    StudentAdd($PID, $studentfn, $studentln, $studentage, $studentgender, $db);
  }
}

//This adds the student to the data base and then runs the student check funciton
function StudentAdd($PID, $studentfn, $studentln, $studentage, $studentgender, $db){
   $sql_student_add = "INSERT INTO students (StudentID, ParentID, StudentFN, StudentLN, Student_Age, Student_Gender, ID) VALUES (NULL, $PID, '$studentfn', '$studentln', $studentage, '$studentgender', NULL)";
   echo "$sql_student_add";
  if(mysqli_query($db, $sql_student_add)){
    echo "Student Has Been added";
    StudentCheck($studentfn, $studentln, $PID, $time, $studentage, $studentgender, $db);
  }
}

//This adds an applicatoin to the applicatoin table of the data base and then also sends an email out confirming the booking
function ApplicationInsert($PID, $SID, $time, $db){
  $sql = "INSERT INTO applications (APP_ID, ParentID, StudentID, Time, Status) VALUES (NULL, $PID, $SID, '$time', 'Pending')";
  if(mysqli_query($db, $sql)){
    header("location: Success.php");
    $body = "Thank You for Sending through the Application for $time. The application is currently in the Pending Status and you will be notified when this changes.";
    Mail::sendMail('Booking Application', $body, $email);
  } else {
    header("location: error.php");
  }
}

//This adds a user too the database if the parent is not currently a registered parent in the database
function UserAdd($parentfn, $parentln, $email, $phone, $db){
  echo "useradd";
    $username = $parentfn.'.'.$parentln;
    $pass = rand();
    $passh = hash("sha256", $pass);
    $random = rand();
    $hash = hash("sha256", $random);
    $sqluser_add = "INSERT INTO loginform (ID, User, Email, Avatar, Verifybit, Pass) VALUES (NULL, '$username', '$email', 'image/default.jpg', '$hash', '$passh')";
    echo "$sqluser_add";
    if(mysqli_query($db, $sqluser_add)){
      echo "Hello2";
        $sql_user_search = "SELECT * FROM loginform WHERE Email='$email' ";
        $result=mysqli_query($db, $sql_user_search);
        $row = mysqli_fetch_array($result);
        $UID = $row['ID'];
        $sql_parent_add = "INSERT INTO parents (ID, ParentID, ParentFN, ParentLN, Contact_Email, PH) VALUES ($UID, NULL, '$parentfn', '$parentln', '$email', $phone)";
        if(mysqli_query($db, $sql_parent_add)){
          $unamepass = array($username, $pass, $hash);
          return $unamepass;
        }
      }
}
//This uses variable variables to create the different div ID and Classes and other data required
function CardCreator($DATA){
  //$Data[0] stands for the day, e.g. Tues, Fri, Sat, and this just adds count too it e.g. countSAT, countFRI
  ${'count'.$DATA[0]} += 1;
  //This creates the variables with their information, and then adds it too a variable to be stored into an array
  //This creates the Time of the available slot tag
  ${$DATA[0].${'count'.$DATA[0]}} = $DATA[1];
  $Day1 = ${$DATA[0].${'count'.$DATA[0]}};
  //This creats a variable to make it visible
  ${$DATA[0].'V'.${'count'.$DATA[0]}} = "visible";
  $DayV1 = ${$DATA[0].'V'.${'count'.$DATA[0]}};
  //This creates the available tag
  ${$DATA[0].'A'.${'count'.$DATA[0]}} = "Available";
  $DayA1 = ${$DATA[0].'A'.${'count'.$DATA[0]}};
  //This puts all of the data into an array
  $daydata = array($Day1, $DayV1, $DayA1);
  //This returns the array
  return $daydata;
}

//This code will run when the submit button is pressed on the form, and all the inputs that are required are filled.
if(isset($_POST['submit'])){
  //This sets all the Post data to a variable so it will become ready to be used
  $time = $_POST['my_fld'];
  $studentfn = $_POST['StudentF'];
  $studentln = $_POST['StudentL'];
  $studentage = $_POST['StudentAge'];
  $studentgender = $_POST['Gender'];
  $parentfn = $_POST['ParentF'];
  $parentln = $_POST['ParentL'];
  $email = strtolower($_POST['ContactEmail']);
  $phone = $_POST['Ph'];
  //This checks for the parent to see if the parent is in the database, and then checks for the student, and then sends an email out
  if(null !== ParentCheck($parentfn, $parentln, $email, $db)){
    $PID = ParentCheck($parentfn, $parentln, $email, $db);
    StudentCheck($studentfn, $studentln, $PID, $time, $studentage, $studentgender, $db);
  } else {
    //If the parent was not found this code will be run and it will create a user, and then repeat the code above, and then send the user his/her account deatils
    $userarray = UserAdd($parentfn, $parentln, $email, $phone, $db);
    $username = $userarray[0];
    $pass = $userarray[1];
    $hash = $userarray[2];
    if(null !== ParentCheck($parentfn, $parentln, $email, $db)){
      // TODO: Set up correctly with new database systems.
      // TODO: Make Username lowecase
      // TODO: Set up the student acount creation
      $PID = ParentCheck($parentfn, $parentln, $email, $db);
      StudentCheck($studentfn, $studentln, $PID, $time, $studentage, $studentgender, $db);
      $applicationemail = "
      <html><body>
      <br>
      <br>
      Thanks for sending through your Application for lessons at $time!
      <br>
      Your Account has been created, but you cant login until you verify your email.
      <br>
      Your Account details are below aswell as your email Verification link.
      <br>
      <br>
      <br>
      <table rules='all' style='border-color: #666;' cellpadding='10'>
      <tr style='background: #2980b9;'><td></td><td></td>
      <tr style='background: #eee;'><td><strong>Name:</strong> </td><td>$username</td></tr>
      <tr><td><strong>Email:</strong> </td><td>$email</td></tr>
      <tr style='background: #eee;'><td><strong>Password:</strong> </td><td>$pass</td></tr>
      <tr><td><strong>Verification:</strong> </td><td>digitech.cas.school.nz:8080/declan/verify.php?email='$email'&hash=$hash</td></tr>
      <tr style='background: #2980b9;'><td></td><td></td>
      </table>
      </body></html>
      ";
      Mail::sendMail('Verification Email', $applicationemail, $email);
    }
  }
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
        <h1>Scroll Down For Booking!</h1>
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
  <!-- This is the darck background behind the form-->
  <div class="bg-model" style="display: none;">
    <!-- This is the white box where the form is-->
    <div class="model-content" style="display: none;">
      <!-- This is the content inside of the white form box -->
      <div class="model-content-inner">
        <!-- This is the form -->
      <form id="Booking_form" method="POST" action="#">
        <div class="form_input">
          <!-- This is the X close button on the top right hand corner -->
          <div class="formhead">
              <a href="javascript:void(0)" id="form-close" class="icon ion-md-close-circle-outline"></a>
            <h2>Please Fill Out</h2>
          </div>
          <!-- This is the form for the person to fill out -->
         <input type="hidden" name="my_fld" id="my_fld" value="" />
         <input type="text" name="StudentF" placeholder="Childs First Name" required>
         <input type="text" name="StudentL" placeholder="Childs Last Name" required>
         <input type="text" name="StudentAge" placeholder="Childs Age" required>
           <input type="radio" name="Gender" value="Male">
           <label for="GenderB">Boy</label>
           <input type="radio" name="Gender" value="Female">
           <label for="GenderG">Girl</label>
           <input type="radio" name="Gender" value="Other">
           <label for="GenderO">Other</label>
         <input type="text" name="ParentF" placeholder="Parents First Name" required>
         <input type="text" name="ParentL" placeholder="Parents Last Name" required>
         <input type="email" name="ContactEmail" placeholder="Contact Email" required>
         <input type="text" name="Ph" placeholder="Phone Number" required>
         <input type="submit" name="submit" value="Submit!">
         </div>
      </form>
    </div>
    </div>
  </div>
  <!-- This ist he divs for the differnet days, there are 3 currently -->
  <div class="days">
    <div class="drums_day1">
      <div class="date_title">
        <h1>Tuesday<h1>
      </div>
      <!-- This uses a function called CardCreator to create the variables and add them into an array
      ready to be used to below to create a card using the Information that had been gathored from
      the database -->
      <?php
      $counting = 0;
      foreach ($ARR_BOOK as $DATA) {
        if($DATA[0] === 'Tues'){
          $dayarray = CardCreator($DATA);
          $day1 = $dayarray[0];
          $dayv1 = $dayarray[1];
          $daya1 = $dayarray[2];
          $counting += 1;
          echo "<div class='book_card' id= $day1 style='visibility: $dayv1'>";
          echo "<a class='booklnk' href='#' data-timeslot= $day1>";
          echo "<p1>$day1</p1>";
          echo "<p2>$daya1</p2>";
          echo "</a>";
          echo "</div>";
        }
      }

      if($counting < 1){
        echo "<div class='book_card' id= Tues1 style='visibility: visible'>";
        echo "<a class='booklnk' href='#' data-timeslot= WaitingT>";
        echo "<p1>None Available</p1>";
        echo "<p2>Join the Waiting List!</p2>";
        echo "</a>";
        echo "</div>";
      }
      ?>
    </div>
    <div class="drums_day2">
      <div class="date_title">
        <h1>Friday<h1>
      </div>
      <?php
      $counting = 0;
      foreach ($ARR_BOOK as $DATA) {
        if($DATA[0] === 'Fri'){
          $dayarray = CardCreator($DATA);
          $day1 = $dayarray[0];
          $dayv1 = $dayarray[1];
          $daya1 = $dayarray[2];
          $counting += 1;
          echo "<div class='book_card' id= $day1 style='visibility: $dayv1'>";
          echo "<a class='booklnk' href='#' data-timeslot= $day1>";
          echo "<p1>$day1</p1>";
          echo "<p2>$daya1</p2>";
          echo "</a>";
          echo "</div>";
        }
      }

      if($counting < 1){
        echo "<div class='book_card' id= Fri1 style='visibility: visible'>";
        echo "<a class='booklnk' href='#' data-timeslot= WaitingF>";
        echo "<p1>None Available</p1>";
        echo "<p2>Join the Waiting List!</p2>";
        echo "</a>";
        echo "</div>";
      }
      ?>
    </div>
    <div class="drums_day3">
      <div class="date_title">
        <h1>Saturday<h1>
      </div>
      <?php
      $counting = 0;
      foreach ($ARR_BOOK as $DATA) {
        if($DATA[0] === 'Sat'){
          $dayarray = CardCreator($DATA);
          $day1 = $dayarray[0];
          $dayv1 = $dayarray[1];
          $daya1 = $dayarray[2];
          $counting += 1;
          echo "<div class='book_card' id= $day1 style='visibility: $dayv1'>";
          echo "<a class='booklnk' href='#' data-timeslot= $day1>";
          echo "<p1>$day1</p1>";
          echo "<p2>$daya1</p2>";
          echo "</a>";
          echo "</div>";
        }
      }

      if($counting < 1){
        echo "<div class='book_card' id= Sat1 style='visibility: visible'>";
        echo "<a class='booklnk' href='#' data-timeslot= WaitingS>";
        echo "<p1>None Available</p1>";
        echo "<p2>Join the Waiting List!</p2>";
        echo "</a>";
        echo "</div>";
      }
      ?>
    </div>
  </div>
<?php include_once 'footer.php';
?>
</body>
  <!-- This is the card, and the card txt, and the link to the next page -->
  <!-- This is the javascript that is used to make the animations work -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
  </script>
  <script src="JS/index_functions.js">
  </script>
  <script>
  $('.booklnk').click(function(e){
//prevent default link click
e.preventDefault();
//get the data from the link that was clicked
var timeslot = $(this).data('timeslot');
//modify the form so when the user submits it the field is sent
//tip, you can change the input from type="text" to type="hidden"
//so the user cannot see it, but for example purpose it's easier to show it.
$('#my_fld').val(timeslot);
$('.bg-model').fadeIn(1000);
$('.model-content').show(1000);


return false; //helps prevent double click link access
});

$('#form-close').click(function(e){
  e.preventDefault();
  $('.bg-model').fadeOut(500);
  $('.model-content').fadeOut(300);
});
  </script>
</html>
