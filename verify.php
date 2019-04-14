<?php
//This includes the connect.inc file, that connects to the database
include('INC/connect.inc');
//This checks that the hash and email in the url is not empty
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    //verify
    $email = $_GET['email']; // Set email variable
    $hash = $_GET['hash']; // Set hash variable
    //This creates the sql to check if the email and hash are in the database
    $sql = "SELECT email.Verifybit FROM loginform AS email WHERE Email=$email AND Verifybit='$hash'";
    $result=mysqli_query($db, $sql);
      //If it is tru then the user will be made active and will be able to log in
      if(mysqli_num_rows($result)==1){
        $sql_set_active = "UPDATE loginform SET Active = 1, Verifybit = 'Verified' WHERE loginform.Email = $email";
        if(mysqli_query($db, $sql_set_active)){
          header('location: login.php');
        } else {
          $_SESSION['error'] = 'Verification ';
          header('location: error.php');
        }
      } else {
        $_SESSION['error'] = 'Verification ';
        header('location: error.php');
      }
} else {
  $_SESSION['error'] = 'Verification ';
  header('location: error.php');
}
?>
