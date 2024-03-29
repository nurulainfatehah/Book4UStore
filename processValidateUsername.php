<?php 
  include('inc/dbconnect.php');

  if (isset($_POST['username_check'])) {
  	$username = $_POST['username'];
  	$sqlAdmin = "SELECT username FROM admin WHERE username='$username'";
  	$resultAdmin = $conn->query($sqlAdmin);

    $sqlNanny = "SELECT username FROM customer WHERE username='$username'";
    $resultNanny = $conn->query($sqlNanny);

    $sqlParent = "SELECT username FROM staff WHERE username='$username'";
    $resultParent = $conn->query($sqlParent);

  	if (mysqli_num_rows($resultAdmin) > 0 || mysqli_num_rows($resultNanny) > 0 || mysqli_num_rows($resultParent) > 0) {
  	  echo "taken";	
  	}else{

  	  echo 'not_taken';
  	}
  	exit();

  }

  
  if (isset($_POST['email_check'])) {
  	$email = $_POST['email'];

    $sqlParent = "SELECT email FROM staff WHERE email='".$email."'";
    $resultParent = $conn->query($sqlParent);

    $sqlAdmin = "SELECT email FROM customer WHERE email='".$email."'";
    $resultAdmin = $conn->query($sqlAdmin);

    

  	if (mysqli_num_rows($resultAdmin) > 0 || mysqli_num_rows($resultParent) > 0) {
  	  echo "taken";	
  	}else{
  	  echo 'not_taken';
  	}
  	exit();
  }

?>