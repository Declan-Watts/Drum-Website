<?php
include('INC/connect.inc');
//This checks a users session and blocks/allows a user too a page
//depending on if they are logged in or not

$db;
session_start();
$user_check=$_SESSION['login_user'];

$sql = "SELECT User FROM loginform WHERE User='$user_check'";

$ses_sql=mysqli_query($db, $sql);

$row = mysqli_fetch_assoc($ses_sql);

$login_session = $row['User'];
// $security = $row['Security'];

if(!isset($login_session)){
  mysql_close($db);
  header('Location: login.php');
}
 ?>
