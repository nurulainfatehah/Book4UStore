<?php
session_start();

include('inc/dbconnect.php');
if (isset($_SESSION['username']))
{
	$_SESSION = array();
	session_destroy();
}

$count = 0;
$sqlPaparanBuku= "SELECT * FROM book order by title ASC";
$result = $conn->query($sqlPaparanBuku);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link rel="stylesheet" type="text/css" href="css/book.css">	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<title>BOOK4U</title>
	<script type="text/javascript">

		function signInFirst(){
			alert("Please sign in first");
		}

		function viewBook(obj){
			var bookID = obj.id;
			window.location.href = "viewBook.php?bookID=" + bookID;
		}
	</script>
</head>
<body>	
	<header>
		<a href="../BOOK4UStore" class="logo">BOOK4U STORE</a>
		<nav>
			<ul>
				<li><a href="#" onclick="window.alert('Please Sign In First')">CART</a></li>
				<li><a href="signIn.php">SIGN IN</a></li>
				<li><a href="signUp.php">CREATE ACCOUNT</a></li>
			</ul>
		</nav>
		<div class="clearfix"></div>
	</header>
	
	<div class="sortSearchHolder">
		<a href="about.php">
			<div class="about">ABOUT</div>
		</a>
		<div style="width:50%; margin-left:auto; margin-right: auto;">
			<select style="width: 40%;" id="sortBook" title="sort">
				<option selected value="titleAZ">Title A-Z</option>
				<option value="titleZA">Title Z-A</option>
				<option value="authorAZ">Author A-Z</option>
				<option value="authorZA">Author Z-A</option>
			</select>
			<input style="width: 40%; margin-left: 3%;" placeholder="Search" type="text" name="searchBook" id="searchBook">
			<i class="fa fa-times" id="clearsearch" aria-hidden="true" style="display: none;margin-left:-20px; font-size: 12px"></i>
		</div>
	</div>
	<div class="bookHolder">
		
		<div id="display_book">

		</div>
	</div>
	


<script type="text/javascript">
	$(document).ready(function(){


		load_book();

		//=======================================================================================

			function load_book(querySearch, par, genre){
				$.ajax({
					url:"search_book.php",
					method:"POST",
					data:{querySearch:querySearch,
						par:par,
						genre: genre
					},
					success:function(data)
					{
						$('#display_book').html(data);
					}
				});
			}

			$('#searchBook').keyup(function(){
				var search = $(this).val();
				var opt = $('#sortBook :selected').val();
				if(search != '')
				{
					$('#clearsearch').show();
					load_book(search, opt);
				}
				else
				{
					$('#clearsearch').hide();
					load_book();
				}
			});

			$('#sortBook').change(function (){
				var search = $('#searchBook').val();
				var opt = $('#sortBook :selected').val();
				if(opt != '')
				{
					load_book(search, opt);
				}
				else
				{
					load_book();
				}

			});

			$('#clearsearch').click(function(){
				$('#searchBook').val("");
				$('#clearsearch').hide();
				load_book();
			});

		<?php
		if(isset($_GET['genre'])){
			?>
			load_book("", "", "<?php echo $_GET['genre'] ?>");
			$('#searchBook').val("<?php  echo $_GET['genre'] ?>");
			$('#clearsearch').show();
			<?php
			unset($_GET['genre']);
		}

		?>
		});

</script>

</body>
</html>


<?php

include("footer.php");
?>