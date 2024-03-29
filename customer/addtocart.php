<?php
session_start();
include ('../inc/dbconnect.php');

if (isset($_SESSION['bookID']))
{
	$bookID = $_SESSION['bookID'];
}
else if(isset($_GET['bookID']) && isset($_GET['title'])) //get dari icon troli
{
	$bookID=$_GET['bookID'];
	$title = $_GET['title'];
	$username = $_SESSION['username'];
}
else
{
	$bookID=$_POST['bookID'];
	$title = $_POST['title'];
	$username = $_SESSION['username'];
}


$sql1 = "SELECT * FROM cart where bookID = '".$bookID."' AND customer = '".$username."'";
$result = $conn->query($sql1);

?>
<html>
<header>
	<script type="text/javascript">
	function alreadyInCart()
	{
		var title = "<?php echo $title ?>";
		alert("" + title + " is already in your cart!");	
		window.location.replace("../customer");
	}

	function addedToCart()
	{
		var title = "<?php echo $title ?>";
		alert("" + title + " is added to your cart!");	
		window.location.replace("../customer");
	}

	</script>
</header>


<?php
if( $result->fetch_assoc() > 0)
{
	?>
	<body onload= "return alreadyInCart(); ">
	</body>

	<?php	
}
else
{
	$sqlAddToCart= "INSERT INTO cart VALUES ('".$bookID."', '".$username."')" or die ("error inserting data into table");


	if ($conn->query($sqlAddToCart) === TRUE)
	{

		?>
		<body style="background: rgba(103, 128, 159, 0.2);" onload= "return addedToCart(); ">
		</body>

		<?php		

	}
	else 
	{
		echo "Error: " . $sqlAddToCart . "<br>" . $conn->error; //error testing
		echo "<meta http-equiv=\"refresh\"content=\"3;URL=../customer\">";
	
	}
}



$conn->close();
?>
