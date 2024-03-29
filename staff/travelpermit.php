<?php
session_start();
$username = $_SESSION['username'];




?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Travel Permit Form</title>
	<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
	<style type="text/css">
		*{
			font-family: sans-serif;
		}
		input{
			width: 80%;
			padding: 5px 5px 5px 5px;
		}
		table{
			margin-top: 40px;
		}
		i{
			font-size: 12px;
			color: red;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){


			$('#traveldate').on('change', function(){
				var ic = $('#ic').val();
				var date = new Date();
				date.setDate(date.getDate() + 7);
				var alloweddays = [
									  date.getFullYear(),
									  ('0' + (date.getMonth() + 1)).slice(-2),
									  ('0' + date.getDate()).slice(-2)
									].join('-');

				var datechosen = $('#traveldate').val();

				var datetoday = new Date();
				datetoday = [
									  datetoday.getFullYear(),
									  ('0' + (datetoday.getMonth() + 1)).slice(-2),
									  ('0' + datetoday.getDate()).slice(-2)
									].join('-');


				//alert(datechosen + "< " + datetoday);

				var datedatechosen = Date.parse(datechosen);
				var datedatetoday = Date.parse(datetoday);
				var datealloweddays = Date.parse(alloweddays);


				if(datedatechosen < datedatetoday){
					alert("Invalid travel date. Date of travel must be between today until " + alloweddays);
					return;
				}else if(datedatechosen > datealloweddays){

					alert("Sorry, travel permit is only elligible to be generated 7 days before the travel day.");
					$('#submit').hide();
					return;
				}else{

					$('#submit').show();
				}
			});		
			
		});

		function check(){
			var ic = $('#ic').val();
			if(ic.length == 0){
				alert("Please fill in your IC or passport number.");
				$('#ic').focus();
				
				return false;
			}else if(ic.length < 8){
				alert("IC or passport number shall not be less than 8 characters.");
				$('#ic').focus();
				
				return false;
			}
			else if(ic.length > 12){
				alert("IC or passport number shall not exceed 12 characters.");
				$('#ic').focus();
				
				return false;
			}else{
				if(confirm("Are you sure to generate this work travel permit? The Administrator will be notified upon this action. Click OK to continue")){
					return true;
				}else{
					return false;
				}
			}
		}
	</script>
</head>
<body>
	<form onsubmit="return check()" method="POST" action="worktravelpermit.php">
		<center>
			<img src="../imgsource/basic/logo.png" height="70px" width="140px">
			<br>BOOK4U STORE
		</center>
		<table width="50%" align="center" border="1" cellpadding="8">
			<th colspan="2">
				TRAVEL PERMIT FORM
			</th>
			<tr>
				<td align="center">
					IC/ Passport
				</td>
				<td>
					<input type="text" id="ic" style="text-transform:uppercase;" name="ic" placeholder="xxxxxxxxxxxx">
				</td>
			</tr>
			<tr>
				<td align="center">
					Date of Travel
				</td>
				<td>
					<input id="traveldate" type="date" name="traveldate"><br>
					<i>Note: Travel date must be between today until the next 7 days only. </i>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right">
					<input type="submit" name="submit" id="submit" style="width:30%; display: none;" value="GENERATE">
				</td>
			</tr>
		</table>
	</form>	
</body>
</html>