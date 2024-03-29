<?php
session_start();
include('../inc/dbconnect.php');
$username = "";

if(isset($_SESSION['username'])){
	$username = $_SESSION['username'];
}
else{
	?>
	<script type="text/javascript">	
		alert("Invalid session. Please try sign in again.");
		window.location.replace('signIn.php');
		
	</script>
	<?php
}

$sqlGenre = "SELECT * FROM GENRE";
$resultGenre = $conn->query($sqlGenre);

$sqlneworder = "SELECT * FROM `purchase` WHERE status = 'in process'";
$resultneworder = $conn->query($sqlneworder);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Post Book</title>
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/book.css">	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<style type="text/css">

		input[type="text"], input[type="number"], .tdcb, textarea{
			width: 73%;
		}
		.error{
			margin-left: 20px;
		}
		table{
			width: 50%;
			margin-left: auto;
			margin-right: auto;
		}
		textarea{
			line-height: 18px;
		}
	</style>
	<script type="text/javascript">
		function checkbook(form)
		{	
			var result = false;

               	if(titleauthorcheck() == true)
               	{
               		if(genrecheck() == true)
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
               	}
               	return false;
      	} 

      	function titleauthorcheck()
      	{
      		CTitle = form.title.value; 
            CAuthor = form.author.value; 

            if(CTitle == "")
            {
            	alert("Title must be filled out");
  				return false;
            }
            else if(CAuthor == "")
            {
            	alert("Author must be filled out");
  				return false;
            }else if(document.getElementById("picture").files.length == 0 ){
			   
			   alert("Missing book cover");
				return false;
			}
            result = true;
  			return result;

      	}

      	function genrecheck()
      	{
      		var checkboxs=document.getElementsByName("genre_list[]");
		    var flag=false;
		    for(var i=0,l=checkboxs.length;i<l;i++)
		    {
		        if(checkboxs[i].checked)
		        {
		            flag=true;
		            break;
		        }
		    }

			if(flag == false)
			{
				alert("Please choose at least 1 genre.");
		    	return false;
			}
			else
			{
				result = true;
  				return result;
			}
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
				<li><a href="../staff">HOME</a></li>
				<li><a href="postBook.php" class="activebar">POST BOOK</a></li>
				<li><a href="order.php">ORDER [<?php echo $resultneworder->num_rows ?>]</a></li>
				<li><a href="c-19test.php">C-19 TEST</a></li>
				<li><a href="profile.php"><?php echo strtoupper($username); ?></a></li>
				<li><a href="../signOut.php">SIGN OUT</a></li>
			</ul>
		</nav>
		<div class="clearfix"></div>
	</header>
	<div class="boxHolder">
		<form method="post" enctype="multipart/form-data" action="processPostBook.php" id="form" onSubmit = "return checkbook(this); ">

			<table align="center" cellpadding="6" width="50%">
				<th  style="font-size: 20px;  border-bottom: 5px solid rgba(103, 128, 159, 1); margin-bottom: 35px; padding: 8px 0;">
					POST FORM
				</th>
				<tr>
					<th align = 'left' >TITLE 
						
					</th>
					<td><input type="text" cols="40" name="title" placeholder="TITLE" title="Title">
						<span class="asterisk_input"></span>
					</td>
				</tr>
				<tr>	
					<th align = 'left'>BOOK COVER
						
					</th>
					<td><input type="file" id="picture" name="picture" accept="image/png, image/gif, image/jpeg, image/jpg" ><span class="asterisk_input" style="margin-left: 56px; "></span>
					</td>
				</tr>
				<tr>
					<th align = 'left' >AUTHOR 
						
					</th>
					<td><input type="text" name="author" placeholder="AUTHOR" title="Author's Name" style="text-transform: uppercase;">
						<span class="asterisk_input"></span>
					</td>
				</tr>
				<tr>
					<th align = 'left' >GENRE 
						
					</th>
					<td class="tdcb">
						<?php
						$totalgenre = $resultGenre->num_rows;
						$total = 0;
						while($gen = $resultGenre->fetch_assoc()){
							$total++;
							if($total == 1){
								?>
								<input class="checkbox" type="checkbox" title="<?php echo $gen['name']; ?>" name="genre_list[]" checked value="<?php echo $gen['genreID']; ?>"  title="Choose at least 1 genre">
								<label><?php echo $gen['name']; ?></label>
								<?php
							}else{
								?>
								<input class="checkbox" type="checkbox" title="<?php echo strtoupper($gen['name']); ?>" name="genre_list[]" value="<?php echo $gen['genreID']; ?>"  title="Choose at least 1 genre">
								<label><?php echo $gen['name']; ?></label>
								<?php
							}
							?>							
							
							<?php
							if($total == $totalgenre){

							}else if (($total+1) % 3 == 0){
							 	echo "<br>";
							 }
						}
						?><span class="asterisk_input" style="margin-left: 45px;"></span>
					</td>
				</tr>
				<tr>
					<th align = 'left' >YEAR  
						
					</th>
					<td><input type="Number" placeholder="1999"  title="publication year" name="year" ></textarea>
						<span class="asterisk_input"></span>
					</td>
				</tr>
				<tr>
					<th align = 'left' >DESCRIPTION 
						
					</th>
					<td><textarea placeholder="DESCRIPTION" rows="4" title="book description" name="description" ></textarea>
						<span class="asterisk_input"></span>
					</td>
				</tr>
				<tr>
					<th align = 'left' >CONDITION (1-5)
						
					</th>
					<td><input placeholder="CONDITION" type="Number" title="condition" name="book_condition" >
						<span class="asterisk_input"></span>
					</td>
				</tr>
				<tr>
					<th align = 'left' >PRICE (RM)
						
					</th>
					<td><input  type="number" title="Price must be more than RM1" name="price" placeholder="0.00"  step=".01" />
						<span class="asterisk_input"></span>
					</td>
				</tr>
				<tr>
					<th colspan="2">
						<input type="reset" name="reset" value="CLEAR FORM" class="submit">
						<input type="submit" value="POST BOOK" name="submit" class="submit">		
					</th>
				</tr>
			</table>
		</form>
	</div>
</script>
</body>
</html>

<?php

include("../footer.php");
?>