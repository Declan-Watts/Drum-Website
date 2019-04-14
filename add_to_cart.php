<?php

// TODO: Make more robust
session_start();
if(isset($_POST['add'])){
  if(!empty($_POST['quantity'])){
    $productID = (int)$_POST['ID'];
    $quantity = (int)($_POST['quantity']);
    $itemArray = array($productID => $productID);

    if(!empty($_SESSION['cart'])){
        echo "here";
        if(empty($_SESSION['cart'][$productID])){
          $_SESSION['cart'][$productID] = $quantity;
        } else {
          $_SESSION['cart'][$productID] += $quantity;
        }
    }
    else{
      echo "here3";
      $_SESSION['cart'] = $itemArray;
    }
  }
}
header("location: equipmenthire.php");
?>
