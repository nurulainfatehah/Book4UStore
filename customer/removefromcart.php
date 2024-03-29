<?php session_start();

include ('../inc/dbconnect.php');
$bookID=$_POST['bookID'];

$sql = "DELETE FROM cart where bookID = '".$bookID."' AND customer = '".$_SESSION['username']."'";
  if ($conn->query($sql) === TRUE) {

	header('location:cart.php');
}
else
{
	echo "Sorry, The book has been sold! " . $sql . "<br>" . $conn->error;
	echo "<meta http-equiv=\"refresh\" content=\"5;URL=cart.php\">";
}

$conn->close();

?>