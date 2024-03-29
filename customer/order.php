<?php 
session_start();
include ('../inc/dbconnect.php');

$receiptID = $_GET['receiptID'];
$username = $_SESSION['username'];
$total = 0;

$sqlBookDetail = "SELECT DISTINCT * FROM customer, purchase, book where book.receiptID = '".$receiptID."' AND purchase.receiptID = '".$receiptID."' AND customer.username = purchase.customer";

$sqlPurchaseDetail = "SELECT DISTINCT status, recipient, email, phone, purchaseDateTime, recipientAddress, reviewID FROM customer, purchase, book where book.receiptID = '".$receiptID."' AND purchase.receiptID = '".$receiptID."'AND customer.username = purchase.customer";



$result = $conn->query($sqlBookDetail);
$result1 = $conn->query($sqlPurchaseDetail);

$rowDetail = $result1->fetch_assoc();
$status = $rowDetail['status'];


if(isset($_POST['submitreview'])){

	$review = $_POST['review'];
	$sqlAddReview = "INSERT INTO review (review) VALUES ('".$review."')";
	if($conn->query($sqlAddReview) === TRUE){
		$sqlGetID = "SELECT reviewID FROM review ORDER BY reviewID DESC LIMIT 1";
		$resultGetID = $conn->query($sqlGetID);
		$rowGetID = $resultGetID->fetch_assoc();
		$reviewN = $rowGetID['reviewID'];

		$sqlAddID = "UPDATE purchase SET reviewID = '".$reviewN."' WHERE receiptID = '".$receiptID."'";
		if($conn->query($sqlAddID)=== TRUE){
			?>
			<script type="text/javascript">
				alert("Your review had been successfully recorded. Thank you");
				window.location.replace("order.php?receiptID=<?php echo $receiptID ?>");
			</script>
		<?php
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../css/invoice.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<meta name = "viewport" content = "width=device-width, initial-scale=1.0";>
	<title>Order Summary #<?php echo $receiptID ?></title>
	<script type="text/javascript">
		function confirmreview(){
			if(confirm('Are u sure to leave the review now?')){
				return true;
			}else{
				return false;
			}
		}
	</script>
</head>
<body>
	<header>
		<a href="../customer" class="logo">BOOK4U STORE</a>
		<nav>
			<ul>
				<li><a href="../customer" >HOME</a></li>
				<li><a href="cart.php">CART</a></li>
				<li><a href="myorder.php" class="activebar">MY ORDER</a></li>
				<li><a href="profile.php"><?php echo strtoupper($username); ?></a></li>
				<li><a href="../signOut.php">SIGN OUT</a></li>
			</ul>
		</nav>
		<div class="clearfix"></div>
	</header>
	<div class="container">

		<div class="upperpart">
			<div class="upperpart1">
				<div class="ordersummary">
					<p class="receipt">Order <b>#<?php echo $receiptID ?></b><br>
						<i class="timeofpurchase">Placed on <?php $newdate = date("d M Y", strtotime($rowDetail['purchaseDateTime'])); echo $newdate; ?> at <?php echo date('h:i:s A', strtotime($rowDetail['purchaseDateTime'])); ?></i>
					</p>

					<?php
					if($status == 'delivered')
					{
					?> <p class="status-order" style="color: green;">
						<?php echo strtoupper($status); ?> </p> <?php
					}
					else if($status == "in process")
					{
					?> <p class="status-order" style="color: orange;"> 
						<?php echo strtoupper($status); ?> </p> <?php 
					}else{
					?> <p class="status-order" style="color: gray;"> 
						CANCELLED </p> <?php 
					}
					?>
				</div>
				<div class="heading">
					<div class="receiptheading" style="color: grey;">Books</div>

					<div class="shippingheading" style="color: grey;">Shipping Details</div>
					
				</div><hr style="margin-block-start: .4em;">

				<div class="row" style="box-sizing: border-box;">
					<div class="column">
						<?php if ($result->num_rows > 0)
						{
							while ($row = $result->fetch_assoc())
								{ ?>	
									<div class="items">
										<img src="../imgsource/bookcover/<?php echo $row['picture'] ?>" >
										<div class="titleauthorholder">
											<div class="title" style="overflow: hidden;
											text-overflow: ellipsis;
											overflow-wrap: break-word;">
											<?php echo $row['title'];?>
											</div>
											<div class="author">
												by &nbsp;<?php echo $row['author'];?>	
											</div><br>
											<div  class="price">RM&nbsp;<?php echo $row['price'];  $total = $total + $row['price']; ?></div>
										</div>
									</div>
									<hr align="left" style="width: 80%; ">
								<?php } $total = $total + 5.55;?>
								<div class="kiracontainer" style="color: grey;">
									Shipping <div  class="price" style="color: black;">RM 5.55</div>
									<br>Total <div  class="price" >RM&nbsp;<?php echo $total;?></div>
								<?php } ?>
								<hr align="right" style="width: 20%;"><hr style="margin-top: 5px;">
							</div>
							</div>

							<div class="column">
								<div class="nameaddress">
									<div style="color:grey;">Receiver Details: </div>
											<?php echo $rowDetail['recipient']
											. "<br>" .$rowDetail['recipientAddress']; 
											?>
								</div>
								<br><br>
								<div class="phoneemail" >
									<i class="fa fa-mobile" aria-hidden="true"></i>
									&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $rowDetail['phone'] ?> <br> <i class="fa fa-envelope" aria-hidden="true"></i>
											&nbsp;&nbsp;: <?php echo $rowDetail['email']; ?>
								</div>
								<hr>
								<div class="visa">
									Paid&nbsp; :
									<i class="fa fa-cc-visa" aria-hidden="true" style="font-size: 26px;"></i> 
								</div>
								<?php
								if($rowDetail['reviewID'] == "" && $rowDetail['status'] == "delivered"){
									?>									
									<div style="margin-top: 20px">
										<form method="post" action="order.php?receiptID=<?php echo $receiptID ?>" onsubmit="return confirmreview()">
											<textarea class="commentholder"   cols="50" rows="4" name="review" placeholder="Feel free to leave review of your experience buying books from us." minlength="10" maxlength="200"></textarea>

											<input class="button" type="submit" name="submitreview" style="margin-left: 10px" >
										</form>
									</div>
									<?php
								}else if($rowDetail['reviewID'] != ""){
									?>
									<div style="margin-top: 20px; border: 1px solid; #cacaca; height: auto; padding: 10px 10px 10px 10px">
										REVIEW
										<hr>
										<p style="text-align: justify;">
											<?php 
											$sqlR = "SELECT review, reviewDateTime from review WHERE reviewID = '".$rowDetail['reviewID']."'";
											$resultR = $conn->query($sqlR);
											$rowR = $resultR->fetch_assoc();
											echo $rowR['review']; ?><br>
											<i style="font-size:11px; font-style: normal; color: gray"><?php $newdate = date("d M Y", strtotime($rowR['reviewDateTime'])); echo $newdate; echo " " . date('h:i:s A', strtotime($rowR['reviewDateTime']));  ?></i>
										</p>
									</div>
									<?php
								}
								?>
							</div> 
						</div>
					</div>
				</div>
				
				
					
			</div>
		</div>
	</body><?php  include('../footer.php'); ?>
</html>
					