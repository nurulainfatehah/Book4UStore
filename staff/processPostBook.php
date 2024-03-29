<?php session_start();

include ('../inc/dbconnect.php');
$username = $_SESSION['username'];


$author = strtoupper($_POST['author']);
$description = $_POST['description'];
$year = $_POST['year'];
$book_condition = $_POST['book_condition'];
$price = $_POST['price'];
 ?>
<title>Posting Book..</title>
<script type="text/javascript">
	function posted()
	{
		alert("New book record created successfully!");
		window.location.replace("postBook.php");
	}

	function errorBook() //ERROR TESTING
	{
		alert("Book record failed to be created! Try again");
		window.location.replace("postBook.php");
	}

	function invalid(){
		alert("Sorry, there was a problem to post the book. Please try again");
		window.location.replace('postBook.php');
	}

	function pictTooBig(){
		alert("Picture is too big. Please try again");
		window.location.replace('postBook.php');
	}

	function pictNotFound(){
		alert("Picture not found. Please try again");
		window.location.replace("postBook.php");
	}

	

</script>

<?php
if(isset($_POST['submit']))
{
	$file = $_FILES["picture"];
	$fileName = $file['name'];
	$fileTmpName = $file['tmp_name'];
	$fileSize = $file['name'];
	$fileError = $file['error'];

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));

	if($fileError == 0) //PICTURE HAS NO PROBLEM 
	{
		if($fileSize < 10000000000) //PICTURE DOES NOT EXCEED 10MB
		{
			$fileNameNew = $fileName ;
			$fileDestination = '../imgsource/bookcover/'.$fileNameNew;
			move_uploaded_file($fileTmpName, $fileDestination);
			//INSERT EVERY COLUMN

			if(isset($_GET['bookID'])){
				$bookID = $_GET['bookID'];

				$sqlUpdateBook = "UPDATE book SET description = '".$description."', yearOfPublication = '".$year."', author = '".$author."', bookCondition = '".$book_condition."', picture = '".$fileNameNew."', price = '".$price."' WHERE bookID = '".$bookID."'";
				if($conn->query($sqlUpdateBook) === TRUE)
				{
					?>
					<script>
						alert("Successfully updated");
						window.location.replace("viewBook.php?bookID=" + <?php echo $bookID ?>);
					</script>
					<?php 
				}
				else
				{
					?>
					<script type="text/javascript">
						alert("Sorry, there was a problem to update the book. Please try again");
						window.location.replace('viewBook.php?bookID' + <?php echo $bookID ?>);
					</script>
					<?php
				}

			}else{
				$title = $_POST['title'];
				$sqlPostBook = "INSERT INTO book (title, author, yearOfPublication, description, picture, price, bookCondition, uploadedBy) VALUES('".$title."', '".$author."', '".$year."', '".$description."', '".$fileNameNew."', '".$price."' , '".$book_condition."' , '".$username."')";
				$genre_list = $_POST['genre_list'];
				if($conn->query($sqlPostBook) === TRUE)
				{
					$id = mysqli_insert_id($conn);
					foreach($_POST['genre_list'] as $genre)
					{
						$sqlInsertGenres = "INSERT INTO genre_book (bookID, genreID ) VALUES ('".$id."', '" . $genre. "')";
						mysqli_query($conn,$sqlInsertGenres) or die (mysqli_error($conn) );
					}
					?>
					<body style="background: rgba(103, 128, 159, 0.2);" onload="return posted();" ></body>
					<?php 
				}
				else
				{
					?>
					<body style="background: rgba(103, 128, 159, 0.2);" onload="invalid();"></body>
					<?php
				}
			}
			
		}
		else
		{
			?>
			<body onload="pictTooBig();"></body>
			<?php 
		}
	}else if($fileError != 0 && isset($_GET['bookID'])){
		$bookID = $_GET['bookID'];

		$sqlUpdateBook = "UPDATE book SET description = '".$description."', yearOfPublication = '".$year."', author = '".$author."', bookCondition = '".$book_condition."', price = '".$price."' WHERE bookID = '".$bookID."'";

		if($conn->query($sqlUpdateBook) === TRUE)
		{
			?>
			<script>
				alert("Successfully updated");
				window.location.replace("viewBook.php?bookID=" + <?php echo $bookID ?>);
			</script>
			<?php 
		}
		else
		{
			?>
			<script type="text/javascript">
				alert("Sorry, there was a problem to update the book. Please try again");
				window.location.replace('viewBook.php?bookID' + <?php echo $bookID ?>);
			</script>
			<?php
		}
	}
	else
	{
		?>
		<body onload="pictNotFound();"></body>
		<?php
	}
}else{
	?>
	<body onload="invalid();"></body>
	<?php
}

?>