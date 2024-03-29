<?php
include('../inc/dbconnect.php');
session_start();
$username = $_SESSION['username'];

$sqlMyOrder = "";
$result = "";

if(isset($_POST['option'])){

	if($_POST['option'] == "all"){
		$sqlMyOrder = "SELECT * FROM purchase ORDER BY receiptID DESC";
		$result = $conn->query($sqlMyOrder);

	}else if($_POST['option'] == "inprocess"){
		$sqlMyOrder = "SELECT * FROM purchase WHERE status = 'in process' ORDER BY receiptID DESC";
		$result = $conn->query($sqlMyOrder);
	}else if($_POST['option'] == "delivered"){

		$sqlMyOrder = "SELECT * FROM purchase WHERE status = 'delivered' ORDER BY receiptID DESC";
		$result = $conn->query($sqlMyOrder);
	}

	if ($result->num_rows > 0)
			{ ?>
	<div id="container" class="container"><div>
		<?php
				while ($row = $result->fetch_assoc())
			{ $_SESSION['receiptID'] = $row['receiptID']; ?>
	<div class="order-list">
		<div class="orders">
			<div class="order">
				<div class="order-info">
					<div class="pull-left">
						<div class="info-order-left-text">Order #<b><?php echo $row['receiptID']; ?></b></div><p class="text info desc">Placed on <?php $newdate = date("d-m-Y", strtotime($row['purchaseDateTime'])); echo $newdate; ?> at <?php echo date('h:i:s A', strtotime($row['purchaseDateTime'])); ?></p></div>
						<div class="pull-cont" >
							</div>
								<a href="view-order.php?receiptID=<?php echo $row['receiptID'] ?>" class="pull-rightmanage" name="submit">View</a>
								<div class="clear">
									
								</div>
							</div>
							<div class="order-item">
								<div class="item-pic"><a href="#"><i class="fa fa-book" style="font-size: 90px; color:rgba(103, 128, 159,1.0); " aria-hidden="true"></i></a></div>
								<div class="itemmainmenu">
									<div>
										<div class="text12" >
											<?php $rid = $row['receiptID']; 
											$sql1 = "SELECT title FROM book, purchase where book.receiptID = '".$rid."' AND purchase.receiptID = '".$rid."'"; 
											$result1 = $conn->query($sql1); 
											if ($result1->num_rows > 0)
												{
													while ($row1 = $result1->fetch_assoc())
													{ 
														echo $row1['title'] . "<br>";  
													}
												}?>
										</div>
										</div>
										</div>
										<div class="item-quantity">
											<span>
												<span class="textmultiply">Qty:
												</span>
												<span class="text">&nbsp;<?php echo $row['quantity']; ?>
												</span>
											</span>
											</div>
											<div class="clear">
												
									</div>
							</div>
		</div><?php }}
		else{
			?>
			<div class="note"><?php

			if($_POST['option'] == "delivered"){
				echo "0 delivered order found";

			}else if($_POST['option'] == "inprocess"){
				echo "0 in-process order found";
			}else{
				echo "0 order history found";
			}
			
			?></div></div></div></div></div></body>

<?php }
}

?>