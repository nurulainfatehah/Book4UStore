<?php

include('../inc/dbconnect.php');
$bookID = $_GET['bookID'];
$title = $_GET['title'];
$sqlDelete = "DELETE FROM genre_book WHERE bookID = '".$bookID."'";


if($conn->query($sqlDelete) === TRUE){

	$sqlDeleteBook = "DELETE FROM book WHERE bookID = '".$bookID."'";
	if($conn->query($sqlDeleteBook) === TRUE){
		?>
		<script type="text/javascript">
			alert("Book " + "<?php echo $title ?>" + " had successfully deleted");
			window.location.replace('../staff');
		</script>
		<?php
	}else{
		?>
		<script type="text/javascript">
			alert("There was a problem to delete the book. Please try again");
			window.location.replace('viewBook.php?bookID=<?php echo $bookID ?>');
		</script>
		<?php
	}

}else{
	?>
	<script type="text/javascript">
		alert("There was a problem to delete the book. Please try again");
		window.location.replace('viewBook.php?bookID=<?php echo $bookID ?>');
	</script>
	<?php
}



?>