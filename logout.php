<?php
session_start();
if(session_destroy()){ // Destroying all sessions
  header("Location: index.php"); // Redirecting To Home Page
} else {
  echo "There was an error logging out";
}
?>
