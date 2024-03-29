<?php session_start();

include ('../inc/dbconnect.php');
$username = $_SESSION['username'];


 ?>

<script type="text/javascript">
	function posted()
	{
		alert("New result record created successfully!");
		window.location.replace("c-19test.php");
	}

	function invalid(){
		alert("Sorry, there was a problem to post the result. Please try again");
		window.location.replace('c-19test.php');
	}

	function fileTooBig(){
		alert("File is too big. Please try again");
		window.location.replace('c-19test.php');
	}

	function fileNotFound(){
		alert("File not found. Please try again");
		window.location.replace("c-19test.php");
	}

	

</script>

<?php
if(isset($_POST['submit']))
{
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$date = date("d-m-Y");
	$file = $_FILES["resultProof"];
	$fileName = $file['name'];
	$fileTmpName = $file['tmp_name'];
	$fileSize = $file['name'];
	$fileError = $file['error'];

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));

	if($fileError == 0) //FILE HAS NO PROBLEM 
	{
		if($fileSize < 10000000000) //FILE DOES NOT EXCEED 10MB
		{
			$fileNameNew = $date."_".$fileName ;
			$fileDestination = '../imgsource/c-19/'.$fileNameNew;
			move_uploaded_file($fileTmpName, $fileDestination);
			//INSERT EVERY COLUMN

			
			$result = $_POST['result'];
			
			
				$sqlPostBook = "INSERT INTO c19swabtest (result, resultProof, staff) VALUES('".$result."', '".$fileNameNew."', '".$username."')";
				

			if($conn->query($sqlPostBook) === TRUE)
			{
			?>

				<body onload="return posted();"></body>
				<?php 
			}
				
			
		}
		else
		{
			?>
			<body onload="fileTooBig();"></body>
			<?php 
		}
	}
	else
	{
		?>
		<body onload="fileNotFound();"></body>
		<?php
	}
}else{
	?>
	<body onload="invalid();"></body>
	<?php
}

?>