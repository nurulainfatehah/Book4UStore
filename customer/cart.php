<?php 
session_start();
include ('../inc/dbconnect.php');
$username = $_SESSION['username'];

$sqlCart = "SELECT * FROM cart, book WHERE customer = '".$username."' AND cart.bookID = book.bookID";
$totalPrice = 0.00;
$totalBook = 0;
$result = $conn->query($sqlCart);
?>
<!DOCTYPE html>	
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cart</title>
		<link rel="stylesheet" type="text/css" href="../css/cart.css">
		<link rel="stylesheet" type="text/css" href="../css/header.css">
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0";>
		<style type="text/css">

		
</style>

</head>
<body>
	<header>
		<a href="../customer" class="logo">BOOK4U STORE</a>
		<nav>
			<ul>
				<li><a href="../customer" >HOME</a></li>
				<li><a href="cart.php" class="activebar">CART</a></li>
				<li><a href="myorder.php">MY ORDER</a></li>
				<li><a href="profile.php"><?php echo strtoupper($username); ?></a></li>
				<li><a href="../signOut.php">SIGN OUT</a></li>
			</ul>
		</nav>
		<div class="clearfix"></div>
	</header>


	<div class="cart-page-product-header">
			<div class="cart-page-product-header__product">product</div>
			<div class="cart-page-product-header__unit-price">unit price</div>
			<div class="cart-page-product-header__quantity">Quantity</div>
			<div class="cart-page-product-header__total-price">total price</div>
			<div class="cart-page-product-header__action">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;actions</div>
	</div>
<?php if ($result->num_rows > 0)
{	?>

	<div class="bundle-group">
		<?php while($row = $result->fetch_assoc()){
			$totalPrice = $totalPrice + $row['price'];
			$totalBook = $totalBook + 1;
			?><form action="removefromcart.php" method="POST">
			<input type="hidden" style="color: transparent;" name="bookID" value="<?php echo $row['bookID']?>" readonly>
			<div class="cart-item">
				<div class="cart-item__content">
					<div class="cart-item__cell-overview">
						<a class="cart-item-overview__thumbnail-wrapper" title="<?php echo $row['title']; ?>" href = "viewBook.php?bookID=<?php echo $row['bookID'] ?>">
							<div class="cart-item-overview__thumbnail" alt="cart_thumbnail" style="background-image: url('../imgsource/bookcover/<?php echo $row["picture"] ?>');">
							</div>
						</a>
						<div class="cart-item-overview__product-name-wrapper">
							<a class="cart-item-overview__name" title="<?php echo $row['title']; ?>" href="viewBook.php?bookID=<?php echo $row['bookID'] ?>"><?php echo $row['title']; ?></a>
							<div class="cart-item-overview__message">
								
							</div>
						</div>
					</div>
					<div class="cart-item__cell-unit-price">
						<div>
							<?php echo "RM " . $row['price']; ?>
						</div>
					</div>
					<div class="cart-item__cell-quantity">
						1
					</div>
					<div class="cart-item__cell-total-price">
						<span><?php echo "RM " . $row['price']; ?></span>
					</div>
					<div class="cart-item__cell-actions">
						<button class="cart-item__action">Remove</button>
					</form>
					</div>
				</div>
			</div><?php } ?>


<?php echo "</div> </div></div>";?><br><div class="cart-page-product-header" style="float:right;margin-bottom: 60px; width: 13%; height: 100px; padding: 0 20px; border-radius: 0px; margin-right: 5%;">
	<div class="summary">
		Subtotal [ <?php echo $totalBook ?> book ] <br><br>
		<div style="font-size: 22px; color: red">
			RM <?php echo number_format($totalPrice, 2, '.', ''); ?>
		</div>
	</div>
	
</div><a <?php echo "onClick=\"javascript:return confirm('Are you sure to proceed with checkout?');\""?> href="checkout.php">
<input type='submit' class="checkoutbtn" name='submit' href="checkout.php" value='Checkout' ></a>;<?php }
else{	?>
<div style="font-size: 40px; color: #ff0072;  text-align: center;"><br><br><br><br> <?php
	echo "---- Cart is empty ----";?></div>


<?php } 
?>
</body>
<?php 
	include("../footer.php");
	$conn->close();
?>