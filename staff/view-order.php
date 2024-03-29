<?php 
session_start();
include ('../inc/dbconnect.php');
include('statusChangeEmail.php');

$receiptID = $_GET['receiptID'];
$username = $_SESSION['username'];
$total = 0;

$sqlBookDetail = "SELECT DISTINCT * FROM customer, purchase, book where book.receiptID = '".$receiptID."' AND purchase.receiptID = '".$receiptID."' AND customer.username = purchase.customer";

$sqlPurchaseDetail = "SELECT DISTINCT username, status, recipient, email, phone, purchaseDateTime, recipientAddress, reviewID FROM customer, purchase, book where book.receiptID = '".$receiptID."' AND purchase.receiptID = '".$receiptID."'AND customer.username = purchase.customer";



$result = $conn->query($sqlBookDetail);
$result1 = $conn->query($sqlPurchaseDetail);

$rowDetail = $result1->fetch_assoc();
$status = $rowDetail['status'];

$sqlneworder = "SELECT * FROM `purchase` WHERE status = 'in process'";
$resultneworder = $conn->query($sqlneworder);

?>

<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../css/invoice.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<meta name = "viewport" content = "width=device-width, initial-scale=1.0";>
	<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
	<title>Order Summary #<?php echo $receiptID ?></title>
	<script type="text/javascript">
		

		$(document).ready(function(){

			function deliveredemail(){
				var receiptID = "<?php echo $receiptID ?>";
				var email = "<?php echo $rowDetail['email'] ?>";
				var name = "<?php echo $rowDetail['username'] ?>";

				$.ajax({
					url: "view-order.php",
					type: "POST",
					cache: false,
					data:{
						delivered_check : 1,
						receiptID: receiptID,
						email: email,
						name: name
					},
					success: function(response){
						if (response == 'delivered' ) {
							window.location.href = "order-status.php?action=delivered&receiptID=" + receiptID;
						}else if (response == 'notdelivered') {


						}
					}
				});
			}

			function cancelledemail(){
				var receiptID = "<?php echo $receiptID ?>";
				var email = "<?php echo $rowDetail['email'] ?>";
				var name = "<?php echo $rowDetail['username'] ?>";

				$.ajax({
					url: "view-order.php",
					type: "POST",
					cache: false,
					data:{
						cancelled_check : 1,
						receiptID: receiptID,
						email: email,
						name: name
					},
					success: function(response){
						if (response == 'cancelled' ) {
							window.location.href = "order-status.php?action=cancelled&receiptID=" + receiptID;
						}else if (response == 'notcancelled') {


						}
					}
				});
			}

			$('#accept').on('click', function(){
				var receiptID = <?php echo $receiptID ?>;
				if(confirm("Are you sure books for order #" + receiptID + " had been successfully delivered?")){
					deliveredemail();				
				}else{

				}
			});

			$('#oppose').on('click', function(){
				var receiptID = <?php echo $receiptID ?>;
				if(confirm("Are you sure to cancel order #" + receiptID + "? The money will be refunded to the customer.")){
					cancelledemail();
				}else{

				}
			});
			
		});

	</script>
</head>
<body>
	<header>
		<a href="../staff" class="logo">BOOK4U STORE</a>
		<nav>
			<ul>
				<li><a href="../staff">HOME</a></li>
				<li><a href="postBook.php">POST BOOK</a></li>
				<li><a href="order.php"  class="activebar">ORDER [<?php echo $resultneworder->num_rows ?>]</a></li>
				<li><a href="c-19test.php">C-19 TEST</a></li>
				<li><a href="profile.php"><?php echo strtoupper($username); ?></a></li>
				<li><a href="../signOut.php">SIGN OUT</a></li>
			</ul>
		</nav>
		<div class="clearfix"></div>
	</header>
	<div class="container">

		<div class="upperpart">
			<div class="upperpart1">
				<?php
				if($rowDetail['status'] == "in process"){
					?>
					<span style="font-size: 25px; float: right; margin-left: -60px;">
						<i id="accept" title="Delivered?" class="fa fa-check-circle-o" aria-hidden="true"></i>
						<i id="oppose" title="Cancelled?" class="fa fa-times-circle-o" aria-hidden="true"></i>	
					</span>
					<?php
				}

				?>
				
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
									</div></div>
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
										if($rowDetail['reviewID'] != ""){
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
					