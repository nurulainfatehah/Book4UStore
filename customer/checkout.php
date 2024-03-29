<?php 
session_start();
include ('../inc/dbconnect.php');

$username = $_SESSION['username'];

$sqlBuyerDetail = "SELECT * FROM customer WHERE username = '".$username."'";
$sqlCart = "SELECT * FROM cart, book WHERE customer = '".$username."' AND cart.bookID = book.bookID";		

$result = $conn->query($sqlBuyerDetail);
$result1 = $conn->query($sqlCart);
$totalPrice = 0;
$totalBook = 0;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Checkout</title>
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/checkout.css">
	<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta name = "viewport" content = "width=device-width, initial-scale=1.0";>

	<script type="text/javascript">
		function checkoutNow()
		{
			nameReceiver = form.recipient.value;
			address = form.delivery_add.value;
			visa = form.visaNo.value;
			cvv = form.cvv.value;
			expirydate = form.expirydate.value;

			var result = false;

			if(nameReceiver.length < 5)
			{
				alert("Name must consists of at least 4 characters");
				return false;
			}
			else if(nameReceiver == "" || nameReceiver.length == 0)
			{
				alert("Name field must be filled in");
				return false;
			}
			else if(address == "")
			{
				alert("Address field must be filled in");
				return false;
			}
			else if(address.length < 10)
			{
				alert("Address is too short! Must have at least 10 characters");
				return false;
			}
			else if(visa.length == 0 || cvv.length == 0 || expirydate.length == 0)
			{
				alert("Please fill in payment details");
				return false;
			}
			else if(visa.length != 16)
			{
				alert("Invalid card number! Must have 16 numbers");
				return false;
			}
			else if(cvv.length != 3)
			{
				alert("Invalid CVV number! Must have 3 numbers only");
				return false;
			}
			else if(expirydate.length != 4)
			{
				alert("Invalid expiry date! Please include MMYY");
				return false;
			}
			else
			{
				if(confirmOrder() == true)
				{
					result = true;
					return result;
				}
				else
				{
					return result;
				}
			}
		}

		function confirmOrder()
		{
			return confirm("Are you sure to place order?");
		}


	</script>

</head>
<body>
	<header>
		<a href="" class="logo">BOOK4U STORE</a>
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

	<?php if ($result->num_rows > 0) {
		$row = $result->fetch_assoc(); ?>
			<br/><br/>

			<div class="checkout-container">
				<div class="checkout-address-selection">
					<div class="address-border"></div>
					<div class="checkoutAddress">
						<div class="checkoutAddressHeader">
							<div class="checkoutAddressHeader-text">

								<svg class="navigator" height="16" viewBox="0 0 12 16" width="12">
									<path d="M6 3.2c1.506 0 2.727 1.195 2.727 2.667 0 1.473-1.22 2.666-2.727 2.666S3.273 7.34 3.273 5.867C3.273 4.395 4.493 3.2 6 3.2zM0 6c0-3.315 2.686-6 6-6s6 2.685 6 6c0 2.498-1.964 5.742-6 9.933C1.613 11.743 0 8.498 0 6z" fill-rule="evenodd"></path>
								</svg> 

								delivery address
							</div>
						</div>
						<form action='checkingout.php' method='post' id="form" name="form" onSubmit = "return checkoutNow();">
							<div class="checkoutAddressSummary">
								<div class="checkout-address-row">
									<div class="checkout-address-row__user-detail">
										<input type="text" name="recipient" style="text-transform: uppercase;" title="Receiver Name" value="<?php echo $row['name'] ?>">
										<i style="font-style: normal;"><?php echo $row['phone'] ?></i> 
									</div>
									<div class="checkout-address-row__address-summary">
										<textarea title="Address" id="delivery_add"  style="text-transform: uppercase;" cols='80' rows='2' name='delivery_add'><?php echo $row['address']?></textarea>
									</div>
									<div id="defaultaddress" style="cursor:pointer;" class="checkout-address-row__default-label">
										default
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="checkout-booklist">
						<div class="checkout-booklist__header-block">
							<div class="checkout-booklist__headers">
								<div class="checkout-booklist__header checkout-booklist__header--book">
									<div class="checkout-booklist__title">Books Ordered</div>
								</div>
								<div class="checkout-booklist__header checkout-booklist__header--variation">
								</div>
								<div class="checkout-booklistlist__header">
									Unit Price
								</div>
								<div class="checkout-booklist__header">
									Amount
								</div>
								<div class="checkout-booklist__header checkout-booklist__header--subtotal" style="text-align: center;">
									Item Subtotal
								</div>
							</div>
						</div>
						<?php if ($result1->num_rows > 0) {
							while($row1 = $result1->fetch_assoc()){
								$totalPrice = $totalPrice + $row1['price'];
								$totalBook = $totalBook + 1;?>

								<div class="checkoutbooklist__content">
									<div class="checkout-shop-order-group">
										<div class="checkout-booklist-item__items">
											<div class="checkout-booklist-item__item_holder">
												<div class="checkoutboxitem">
													<img title="<?php echo $row1['title']; ?>" class="checkout-booklist-item__product-image" src="../imgsource/bookcover/<?php echo $row1['picture'] ?>">
													<span class="checkout-booklist-item__product-info">
														<span class="checkout-booklist-item__product-name" title="<?php echo $row1['title']; ?>"><?php echo $row1['title']?>
													</span>
												</span>
											</div>
											<div class="checkout-booklist-item__header checkout-booklist-item__header--variation">

											</div>
											<div class="checkout-booklist-item__header">
												RM <?php echo $row1['price'] ?>
											</div>
											<div class="checkout-booklist-item__header">
												1
											</div>
											<div class="checkout-booklist-item__header  checkout-booklist-item__header--subtotal" >
												RM <?php echo $row1['price'] ?>
											</div>
										</div>
									<?php }} $totalPrice = $totalPrice + 5.55; ?>
								</div>
							</div>
							<div class="kosong">
								<div class="kosong1">
									<div class="buyer-remark">
										<div class="input-with-status">
											<div class="input-with-status__wrapper">
											</div><div></div></div></div></div>
											<div class="shipping">
												<div class="shippingfaretext">
													Shipping Fare:
												</div>
												<div class="_2nPw6g">
													<div class="standardDelivery">
														<input type="radio" name="" checked="">Standard Delivery
													</div>
													<div class="_2AVdLr">
													</div>
												</div>
												<div class="_1pvLEP"></div>
												<div class="_3WllRI"></div>
												<div class="_2pMlj2"></div>
												<div class="ayQTxx"></div>
												<div class="shippingfareholder"></div>
												<div class="shippingfare" style="text-align: left;">
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RM 5.55
												</div>
											</div>
										</div>
										<div class="totalorderholder">
											<div class="totalorder">
												Order Total (<?php echo $totalBook ?> Item):
											</div>
											<div class="harga">
												RM <?php echo $totalPrice; ?>
												<i class="fa fa-cc-visa" aria-hidden="true" style="font-size: 16px; color: blue;"></i>

											</div>
										</div>
									</div>
								</div><input type="hidden" name="quantity" value="<?php echo $totalBook ?>">
								<input type="hidden" name="total" value="<?php echo $totalPrice; ?>" >
								<div class="totalorderholder">

									<p style="width:10%">
										Credit Card No:
									</p> 
									<input type="number" name="visaNo"  style="width:20%">
									<p style="padding-left: 5%; padding-right: 2%;">
										CVV:
									</p>
									<input type="number" name="cvv">
									<p style="padding-left: 5%; padding-right: 2%;">
										Expiry Date: 
									</p>
									<input type="number" name="expirydate" placeholder="MM/YY">
								</div>
								<div class="totalorderholder" style=" width: auto; margin-right: auto; margin-left: auto; margin-bottom: 4.375rem; border-radius: 3px;">		
									<br>

									<td>
										<a href="cart.php" class='confirm'>
											CANCEL
										</a>
									</td>
									<td>
										<input type="submit" class="confirm" name="submit" value="CONFIRM ORDER"  >
									</td>

									</form>
								</div>
							</div>

						</div>
					</div>
					

		</div></div></div></div>
		<script type="text/javascript">
			$(document).ready(function(){

				$('#defaultaddress').on('click', function(){
					$('#delivery_add').val("<?php echo $row['address']?>");
				});
			});
		</script>
	</body>
	<?php  }
	include("../footer.php");
	?>

