<?php
session_start();
include('../inc/dbconnect.php');
$username = $_SESSION['username'];
$sqlneworder = "SELECT * FROM `purchase` WHERE status = 'in process'";
$resultneworder = $conn->query($sqlneworder);
?>
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
		<script type="text/javascript">
			function checkbook(form)
			{	
				var result = false;

				if(titleauthorcheck() == true)
				{

					if(yearcheck() == true)
					{
						if(descriptioncheck() == true)
						{
							if (conditionpricecheck() == true) 
							{
								return result;

							}
						}
					}
				}
				return false;
			} 

			function titleauthorcheck()
			{
				CAuthor = form.author.value; 

				if(CAuthor == "")
				{
					alert("Author must be filled out");
					return false;
				}
				result = true;
				return result;

			}

			function yearcheck()
			{
				CYear = form.year.value;
				var date = new Date();
				var yearofdate = date.getFullYear();

				if(CYear.length == 0)
				{
					alert("Year of publication must be filled out");
					return false;
				}else if(CYear.length > 4){
					alert("Invalid year of publication.");
					return false;
				}
				else if(CYear > yearofdate)
				{
					alert("Invalid year of publication.")

					return false;
				}
				else if(CYear < 1454)
				{
					alert("There is no copies of book found before year 1454");
					return false;
				}

				result = true;
				return result;
			}


			function descriptioncheck()
			{
				CDescription = form.description.value;
				if(CDescription == "")
				{
					alert("Description must be filled out");
					return false;
				}
				else if(CDescription.length < 10)
				{
					alert("Description entered is too short! Make sure it has at least 30 characters");
					return false;
				}
				else if(CDescription.length > 1000)
				{
					alert("Description entered is too long! Maximum is 1000 characters");
					return false;
				}
				result = true;
				return result;
			}

			function conditionpricecheck()
			{
				CCondition = form.book_condition.value;
				CPrice = form.price.value;
				var decimalplace = /^\d+(\.\d{0,2})?$/;

				if(CCondition.length == 0)
				{
					alert("Condition must be filled out");
					return false;
				}
				else if(CCondition < 1)
				{
					alert("Condition must be between 1 - 5");
					return false;
				}
				else if(CCondition > 5)
				{
					alert("Condition must be between 1 - 5");
					return false;
				}
				else if(CPrice == 0.00 || CPrice.length == 0)
				{
					alert("Price must be filled");
					return false;
				}
				else if (CPrice < 1.00)
				{
					alert("Price must be at least RM1");
					return false;
				}
				else if(!regexp.test(CPrice))
				{
					alert("Invalid price. Please round it off two decimal place only.");
					return false;
				}

				result = true;
				return result;

			}
		</script>
	</head>
	<body>
		<header>
			<a href="../staff" class="logo">BOOK4U STORE</a>
			<nav>
				<ul>
					<li><a href="../staff" class="activebar">HOME</a></li>
					<li><a href="postBook.php">POST BOOK</a></li>
					<li><a href="order.php">ORDER [<?php echo $resultneworder->num_rows ?>]</a></li>
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
				<?php echo $row['title']?> <?php
				if(empty($row['receiptID'])){
					?>
					<i class="fa fa-trash-o" id="delete" aria-hidden="true"></i>
					<?php
				}
				?>
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
					<?php
					if(empty($row['receiptID'])){
						?>
						<input type="submit" id="bttnupdate" name="submit" value="UPDATE" class="buttonaddtocart" >
						<?php
					}else{
						?>
						<input type="submit" name="submit" value="SOLD" class="buttonsold" readonly="">
						<?php
					}
					?>	
				</div>

		</div>
		
		<form method="POST" name="form" enctype="multipart/form-data" action="processPostBook.php?bookID=<?php echo $bookID ?>" id="form" onSubmit = "return checkbook(this);">
		<div id="updateForm" class="maincontainer" style="display: none; margin-top: 30px;">
			
				<div class="booktitle"><p id="cancelUpdate" class="hide">cancel</p>
					UPDATE BOOK: <?php echo $row['title']?>

				</div>
				<div class="bookblock">
					
					<div class="changebookcover" style="background-image: url('../imgsource/bookcover/<?php echo $row['picture'] ?>');">						
					</div>
					<div align="center">
						<input accept="image/jpeg, image/png, image/jpg" type="file" id="picture" name="picture" style="margin-left: 15%; margin-top: 8px;" value="<?php echo $row['picture']?>">
					</div>
				</div>
				<div class="description">
					<i class="descriptionheading" style="font-style: normal; font-weight: bold;">Description</i><br>
					<textarea name="description" title="description" placeholder="DESCRIPTION" style="margin-top: 5px;"><?php echo $row['description'] ?>	</textarea>
				</div>
				<div class="bookinfo">
					<div class="bookPriceAuthor">
						<div class="bookPriceAuthorinner">
							<div class="Authorinfo">
								Year of Publication: <input type="number" value="<?php echo $row['yearOfPublication'] ?>" title="year of publication" name="year"><br>
								Condition: <input type="number" value="<?php echo $row['bookCondition'] ?>" name="book_condition" title="condition" ><br>
							Written By: <input type="text" name="author" style="width: 60%; text-transform: uppercase;" value="<?php echo $row['author'] ?>" title="condition" >
						</div>
						<div class="priceInfo">
							RM <input  type="number" value="<?php echo $row['price'] ?>" title="Price must be more than RM1" name="price" placeholder="0.00"  step=".01" />
						
						</div>
					</div>
				</div>
				<?php
				if(empty($row['receiptID'])){
					?>
					<input type="submit" id="bttnupdate" name="submit" value="CONFIRM UPDATE" class="buttonaddtocart" >
					<?php
				}else{
					?>
					<input type="submit" name="submit" value="SOLD" class="buttonsold" readonly="">
					<?php
				}
				?>	
			</div>
		</form>
	</div>
		<?php  

		include("../footer.php");

		?>
		<script type="text/javascript">
			
			$(document).ready(function(){
				
				$('#bttnupdate').on('click', function(){
					$('#updateForm').show();
					window.scrollTo(0,document.body.scrollHeight);
				});

				$('#cancelUpdate').click(function(){

					$('#updateForm').toggle();
				});

				$('#delete').click(function(){
					if(confirm("Are you sure to delete " + "<?php echo $row['title'] ?>" + "?")){
						window.location.replace("deleteBook.php?bookID=" + "<?php echo $bookID ?>" + "&title=" + "<?php echo $row['title'] ?>");

					}else{

					}
				});

			
				
			});
		</script>
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