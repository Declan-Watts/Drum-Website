<?php
// TODO: Make more robust and accurate
// TODO: Make the emails more well made
include('INC/connect.inc');
include('INC/mailsend.php');
session_start();
$myArray = $_POST['orderarray'];
$order_id = rand();
$user_id = $_SESSION['login_ID'];
$sql = "SELECT * FROM parents WHERE ID = $user_id";
$result=mysqli_query($db, $sql);
$row = mysqli_fetch_array($result);
$FName = $row['ParentFN'];
$LName = $row['ParentLN'];
$Email = $row['Contact_Email'];
$Phone = $row['PH'];
$sqlinsert = "INSERT INTO orders (ID, Order_ID, Status, FName, LName, Email, Phone) VALUES ($user_id, $order_id, 'Pending', '$FName', '$LName', '$Email', $Phone)";
if(mysqli_query($db, $sqlinsert)){
  foreach ($myArray as $value) {
    $PID = $value[0];
    $quantity = $value[1];
    $sqlproduct = "INSERT INTO orders_inventory (Order_invID, Item_ID, Order_ID, Quantity) VALUES (NULL, $PID, $order_id, $quantity)";
    if(mysqli_query($db, $sqlproduct)){
    }
  }
  Mail::sendMail('Verification Email', "Thank you for your order, your order number is $order_id, your order Status is: Pending. We will contact you when we have more information.", "declan.drumming@gmail.com");
  $_SESSION['cart'] = [];
} else {
}
?>
