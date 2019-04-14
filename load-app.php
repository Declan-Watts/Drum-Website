<?php

include('INC/connect.inc');
include('INC/session.inc');

$db;


$app_ID = $_POST['appidNew'];
$UID = $_SESSION['login_ID'];
//This gets all of the information needed from the database and then uses it
//too create all the required variables.
$sql = "SELECT p.ParentFN, p.ParentLN, p.Contact_Email, p.PH, a.Status FROM parents as p INNER JOIN applications as a on p.ParentID = a.ParentID WHERE a.APP_ID=$app_ID";
$sql2 = "SELECT s.StudentFN, s.StudentLN, s.Student_Age, s.Student_Gender FROM students as s INNER JOIN applications as a on s.StudentID = a.StudentID WHERE a.APP_ID=$app_ID";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);
$result2 = mysqli_query($db, $sql2);
$row2 = mysqli_fetch_assoc($result2);
$fname = $row['ParentFN'];
$lname = $row['ParentLN'];
$email = $row['Contact_Email'];
$phone = $row['PH'];
$status = $row['Status'];
$studentfn = $row2['StudentFN'];
$studentln = $row2['StudentLN'];
$studentage = $row2['Student_Age'];
$studentgender = $row2['Student_Gender'];

//This then echos all of the variables to display the information required in the application
//pop up
echo "<div class='formhead'>";
echo "<h2>Application ID: $app_ID</h2>";
echo "</div>";
echo "<hr>";
echo "<div class='appinfo'>";
echo "<h1>Parent Info</h1>";
echo "<hr>";
echo "<p>First Name: $fname</p>";
echo "<p>Last Name: $lname</p>";
echo "<p>Email: $email</p>";
echo "<p>Phone Number: $phone</p>";
echo "</div>";
echo "<hr>";
echo "<div class='appinfo'>";
echo "<h1>Student Info</h1>";
echo "<hr>";
echo "<p>First Name: $studentfn</p>";
echo "<p>Last Name: $studentln</p>";
echo "<p>Age: $studentage</p>";
echo "<p>Gender: $studentgender</p>";
echo "<hr>";
echo "<p>Status: $status</p>";
echo "</div>";
 ?>
