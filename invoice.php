<?php
include ("config.php");
include ("security.php");
if($_SESSION['user_type']!=4)
{
	header('Location: login.php?notPermitted=true');
}
?>

<?php

if(isset($_GET['bill'])){
	$billid=$_GET['bill'];
}
?>
 
 
<?php
	  $headerTitle = "Payments";
      include "header.php";
?>
      
<html>
	<head>
		<style>
			.table-borderless > tbody > tr > td,
			.table-borderless > tbody > tr > th,
			.table-borderless > tfoot > tr > td,
			.table-borderless > tfoot > tr > th,
			.table-borderless > thead > tr > td,
			.table-borderless > thead > tr > th {
			    border: none;
			    padding: 2;
			}
		</style>
	</head>
	<body>
       <div id="page-wrapper">

            <div class="container-fluid">
            	<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Official Receipt
                        </h1>
                    </div>
                </div>
					<?php
							$con=con();

							$sql= "SELECT * FROM bill as b INNER JOIN account as a ON b.account_id = a.account_id AND b.bill_id = $billid ORDER BY b.date_time DESC;";
							$res = mysqli_query($con,$sql);
							$row = mysqli_fetch_array($res);
				
							$datetime=$row['date_time'];
							$arears = $row['arears'];
							$amountdue = $row['amount_due'];
							$amountpaid =  $row['amount_paid'];
							$accno =  $row['account_no'];
							$streetadd =  $row['street_add'];
							$purok =  $row['purok_sub'];
							$barangay = $row['barangay'];
							$town = $row['town'];
							$accname = $row['name'];
							$employee = $row['teller'];

							if($today>$duedate && $row[10] == 0)
								$status = "delinquent";
							else if($row[10] == 0)
								$status = "unpaid";
							else
								$status = "paid";
				
							discon($con);
					?>

              	<br><br>
				<div class="row" id="printTransactionHistory">
					<div class="col-md-3">
						<div class="panel panel-default">
							<div class="panel-heading">
								<img src="images/logoTWBD.png" width="120px" height="85px" style="float:left;">
								<h3 class="panel-title"><strong>OFFICIAL RECEIPT</strong></h3>
		               			<span>Republic of the Philippines</span>
		               			<h4>Tubod-Baroy Water District</h4>
							</div>
							<div class="panel-body">
									<table class="table table-reponsive table-borderless">
										<tr>
											<td colspan="2" style="text-align: right;"><strong>OR # <?php echo rand(99999,11111); ?><strong></td>
										</tr>
										<tr>
											<td colspan="2"><br></td>
										</tr>
										<tr style="text-align: center;">
											<td>Date:</td>
											<td><?php echo date('F d, Y'); ?></td>
										</tr>
										<tr style="text-align: center;">
											<td>Payor:</td>
											<td><?php echo $accname; ?></td>
										</tr>
										<tr style="text-align: center;">
											<td colspan="2"><br></td>
										</tr>
										<tr style="background: #E6E3E2; text-align: center;">
											<td><strong>Collection</strong></td>
											<td><strong>Amount</strong></td>
										</tr>
										<tr style="background: #F6F4F3; text-align: center;"> 
											<td>Water bill</td>
											<td><?php echo "P " . number_format($_SESSION['payment'], 2); ?></td>
										</tr>
										<tr style="background: #F6F4F3; text-align: center;">
											<td><strong>TOTAL</strong></td>
											<td><strong><?php echo "P " . number_format($_SESSION['payment'], 2); ?></strong></td>
										</tr>
										<tr>
											<td colspan="2"><br><br></td>
										</tr>
										<tr>
											<td colspan="2">Received the amount stated above:</td>
										</tr>
										<tr>
											<td colspan="2" style="text-align: right;"><u><?php echo $employee; ?></u><br>Teller/Collecting Officer</td>
										</tr>
									</table>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<button class="form-control btn btn-primary" onclick="printDiv('printTransactionHistory')"">Print Receipt</button>
					</div>
				</div>
            </div>
        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.buttons.min.js"></script>
    <script src="js/dataTables.select.min.js"></script>
    <script src="js/validator.js"></script>
    <script type="text/javascript">     
		function printDiv(printTransactionHistory) 
		{
			var printContents = document.getElementById('printTransactionHistory').innerHTML;
			var originalContents = document.body.innerHTML;

			document.body.innerHTML = printContents;

			window.print();

			document.body.innerHTML = originalContents;
		}
	</script>
	</body>
</html>
