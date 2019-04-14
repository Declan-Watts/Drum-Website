<?php

include('INC/connect.inc');
include('INC/session.inc');

$db;


$order_ID = $_POST['orderidNew'];
$UID = $_SESSION['login_ID'];
//This gets all of the information needed from the database and then uses it
//too create all the required variables.
$sql = "SELECT o.Order_ID, o.FName, o.LName, o.Email, o.Phone, o.Status FROM orders as o WHERE o.Order_ID=$order_ID";
$sql2 = "SELECT o_i.Quantity, i.Description FROM orders_inventory as o_i INNER JOIN inventory as i on o_i.Item_ID = i.Item_ID WHERE o_i.Order_ID = $order_ID";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);
$result2 = mysqli_query($db, $sql2);
$fname = $row['FName'];
$lname = $row['LName'];
$email = $row['Email'];
$phone = $row['Phone'];
$status = $row['Status'];
//This then echos all of the variables to display the information required in the application
//pop up
echo "<div class='formhead'>";
echo "<h2>Order ID: $order_ID</h2>";
echo "</div>";
echo "<hr>";
echo "<div class='appinfo'>";
echo "<h1>Contact Info</h1>";
echo "<hr>";
echo "<p>First Name: $fname</p>";
echo "<p>Last Name: $lname</p>";
echo "<p>Email: $email</p>";
echo "<p>Phone Number: $phone</p>";
echo "</div>";
echo "<hr>";
echo "<div class='appinfo'>";
echo "<h1>Order Info</h1>";
while ($row = mysqli_fetch_array($result2)){
  $item_name = $row['Description'];
  $quantity = $row['Quantity'];
  echo "<hr>";
  echo "<p>Item: $item_name</p>";
  echo "<p>Quantity: $quantity</p>";
}
echo "<hr>";
echo "<p>Status: $status</p>";
echo "<hr>";
echo "</div>";
echo "<hr>";
 ?>
