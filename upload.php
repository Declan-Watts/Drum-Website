<?php
session_start();
include('INC/connect.inc');
$db;

if (isset($_POST['filesubmit'])) {
  $file = $_FILES['fileupload'];
  $UID = $_SESSION['login_ID'];
  //This gets all of the information of the file that is required and then
  //adds it too variables.
  $fileName = $_FILES['fileupload']['name'];
  $fileTmpName = $_FILES['fileupload']['tmp_name'];
  $fileSize = $_FILES['fileupload']['size'];
  $fileError = $_FILES['fileupload']['error'];
  $fileType = $_FILES['fileupload']['type'];
  //this breaks the name of the file apart from the extension and then adds it too an
  //array, then i get the ext name and add it too a variable
  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array('jpg', 'jpeg', 'png');
  //I check if the extension is allowed
  if (in_array($fileActualExt, $allowed)) {
    //I check if there is an error
    if($fileError === 0){
      //I check the size
      if($fileSize < 1000000){
        //I give the file a unique ID
        $fileNameNew = uniqid('', true).'.'.$fileActualExt;
        //I give the file a destination
        $fileDestination = 'image/'.$fileNameNew;
        //I move the file too the position
        if(move_uploaded_file($fileTmpName, $fileDestination)){
          //I add the path too the new file into the users database table for their avatar
          $sql = "UPDATE loginform SET Avatar = '$fileDestination' WHERE loginform.ID = $UID";
          $_SESSION['Avatar']=$fileDestination;
          //I redirect the user too profile.php
          if(mysqli_query($db, $sql)){
            echo "<script>location='profile.php?success'</script>";
          }
        } else {
          echo "it didnt work";
        }
      }else {
        echo "The image was too large";
      }
    } else {
      echo "There was an error in the upload of that file";
    }
  } else {
    echo "You cannot uplad files of this type";
  }
}

 ?>
