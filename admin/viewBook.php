<?php
session_start();
include('../inc/dbconnect.php');
$username = $_SESSION['username'];?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="../css/header.css">
		<link rel="stylesheet" type="text/css" href="../css/viewBook.css">	
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
		
<?php

if(isset($_GET['bookID'])){
	$bookID= $_GET['bookID'];
	$sqlViewBook= "SELECT * FROM book where bookID = '".$bookID."'";
	//echo $bookID;
	$result = $conn->query($sqlViewBook);
	if($result->num_rows == 0){
		?>
		<title>Missing book!</title>
		<script type="text/javascript">
			alert("Sorry, we had lost your choice. Please try again. ");
			window.location.href = "../staff";
		</script>
		<?php
	}else{

	}
	$row = $result->fetch_assoc();
	$sql1= "SELECT genre.name FROM book, genre_book, genre where genre_book.bookID = '".$bookID."' AND book.bookID = '".$bookID."' 		AND genre.genreID = genre_book.genreID";
	$result1 = $conn->query($sql1);
	?>
		<title><?php echo $row['title'] ?></title>
		
	</head>
	<body>
		<header>
			<a href="../admin" class="logo">BOOK4U STORE</a>
			<nav>
				<ul>
					<li><a href="../admin" class="activebar">HOME</a></li>
					<li><a href="staff.php">STAFF</a></li>
					<li><a href="c-19test.php">C-19 TEST</a></li>
					<li><a href="profile.php"><?php echo strtoupper($username); ?></a></li>
					<li><a href="../signOut.php">SIGN OUT</a></li>
				</ul>
			</nav>
			<div class="clearfix"></div>
		</header>


		<div class="sortSearchHolder">
			<center>
				GENRE:
				<?php 

				while($row1= $result1->fetch_assoc()){ 
				?>
					<li class="genre">
						<a class="genre" href="../staff/index.php?genre=<?php echo $row1['name'] ?>">
		            		<?php echo $row1['name']; ?>  
		            	</a>
		        <?php 
		        } 
		        ?>
		     		</li>
		     	
			</center>
		</div>

		<div class="maincontainer" >
			<div class="booktitle">
				<?php echo $row['title']?>
			</div>
			<div class="bookblock">
				
				<div class="imagecontainer">
					<?php
					if(empty($row['receiptID'])){
						?>
						<img src="../imgsource/bookcover/<?php echo $row['picture'] ?>" >
						<?php
					}else{
						?>
						<img style="filter: blur(1px);"  src="../imgsource/bookcover/<?php echo $row['picture'] ?>" >
						<img class="soldImg" src="../imgsource/basic/soldout.png" />
						<?php
					}
					?>
				</div>
			</div>
			<div class="description">
				<i class="descriptionheading" style="font-style: normal; font-weight: bold;">Description</i><br>
					<?php echo $row['description'] ?>	
			</div>
				<div class="bookinfo">
					<div class="bookPriceAuthor">
						<div class="bookPriceAuthorinner">
							<div class="Authorinfo">
								Year of Publication: <?php echo $row['yearOfPublication'] ?><br>
								Condition: <?php for($i=0; $i<$row['bookCondition']; $i++){
									?>
									<span title="<?php echo $row['bookCondition'] . '/ 5 stars' ?>" class="fa fa-star checked"></span>
									<?php
								} 
								if($row['bookCondition'] < 5){
									$counter = 5 - $row['bookCondition'];
									for($i = 0; $i < $counter; $i++){
										?>
										<span title="<?php echo $row['bookCondition'] . '/ 5' ?>" class="fa fa-star"></span>
									<?php
									}
								}
								?><br>
								Written By: <?php echo $row['author'] ?>

							</div>
							<div class="priceInfo">
								RM <?php echo $row['price'] ?>
							</div>
						</div>
					</div>
					
				</div>

		</div>
		
		
	</div>
		<?php  

		include("../footer.php");

		?>
		
	</body>
	</html>

	<?php

}else{
	?>
	<script type="text/javascript">
		window.location.href = "../staff";
	</script>
	<?php
}





?>