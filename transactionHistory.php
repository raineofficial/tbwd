<?php
	include ("config.php");
	include ("security.php");
	if($_SESSION['user_type']!=4)
	{
		header('Location: login.php?notPermitted=true');
	}
?>

<?php
	$successEdit = false;
	$errorDate = false;
	$errorMeter = false;
	$successAdd = false;
	$errorEdit=false;
	$errorRet = false;

	$todayYear = date("Y");
	$todayMonth = date("m");
	$name = $_SESSION['fname'] . " " . $_SESSION['lname'];
?>

<?php
	  $headerTitle = "Transaction History";
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

			.glyphicon-print, .glyphicon-download-alt {
			    font-size: 20px;
			}

			span {
				padding-right: 10px;
			}

			@media print {
  body * {
    visibility: hidden;
  }
  #printTransactionHistory * {
    visibility: visible;
  }
  #printTransactionHistory {
   /* position: absolute;
    top: 0;*/
     background-color: white;
        height: 100%;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        margin: 0;
        padding: 15px;
        font-size: 14px;
        line-height: 18px;
  }
}
		</style>
	</head>

	<body>     
       <div id="page-wrapper" style="width: 100%;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $headerTitle;?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>  <a href="index.php">Home</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-dashboard"></i> <?php echo $headerTitle;?>
                            </li>
                        </ol>
                    </div>
                </div>

				<div class="row" style="padding-top:0px; padding-bottom:40px; padding-right:40px; padding-left:40px;">

						<br><br><br>
						<div class="options" style="float: right; cursor: hand;">
							<span class="glyphicon glyphicon-print" title="Print" onclick="printDiv('printTransactionHistory')""></span>
							<!-- <span class="glyphicon glyphicon-download-alt" title="Download" id="download"></span> -->
						</div>

					<form action="" method="post">

						<select name="trans_date">
					<?php
						$con = con();

						$sqlSelect = mysqli_query($con, "SELECT bill_no, amount_paid_date FROM bill WHERE amount_paid_date is not null GROUP BY bill_no, amount_paid_date;");

						while ($rowSelect = mysqli_fetch_array($sqlSelect))
						{
							$transDate = date ('F Y', strtotime($rowSelect['amount_paid_date']));
					?>
							<option value="<?php echo $rowSelect['bill_no']; ?>"><?php echo $transDate; ?></option>
					<?php
						}
					?>

						</select>
						<input type="submit" name="list" value="See Transaction">
					</form>

						<!-- <p>Transaction Date: <?php echo date('F Y'); ?></p> -->
						<br>


						<table class="table table-striped">
							<thead>
								<th>Account Number</th>
								<th>Name</th>
								<th>Total Bill</th>
								<th>Payment</th>
								<th>Balance</th>
							</thead>
							<?php
								$con=con();

								$accno = $_POST["accnumE"];
								$name = $_POST["cName"];
								$transDate = $_POST['trans_date'];
								$moneyCollected = 0;
								$name = $_SESSION['fname'] . " " . $_SESSION['lname'];

								// $sql= "SELECT * FROM bill as b INNER JOIN account as a ON b.account_id = a.account_id where DATE(amount_paid_date)=CURDATE() and amount_paid != 0 and teller = '$name'";

								$sql = "SELECT * FROM bill as b INNER JOIN account as a ON b.account_id = a.account_id WHERE b.amount_paid != 0 and bill_no ='$transDate' and teller = '$name'";
								// echo $sql;
								$res = mysqli_query($con,$sql);

								while ($row = mysqli_fetch_array($res)) 
								{
							?>
									<tr>
										<td><?php echo $row['account_no']; ?></td>
										<td><?php echo $row['name']; ?></td>
										<td><?php echo "P " . number_format($row['amount_due'], 2); ?></td>
										<td><?php echo "P " . number_format($row['amount_paid'], 2); ?></td>
										<td><?php echo "P " . number_format($row['amount_due']-$row['amount_paid'], 2); ?></td>
									</tr>
							<?php
									$moneyCollected += $row['amount_paid'];
								}
							?>
									<tr style="text-align: right;">
										<td colspan="5"><strong>Total Money Collected: P <?php echo number_format($moneyCollected, 2); ?></strong></td>
									</tr>
						</table>


						<div id="printTransactionHistory" style="display:none;">
							<center>
								<img src="images/logoTWBD.png" width="150px" height="100px">
								<h2>Tubod-Baroy Water District</h2>
								<h4>Transaction History</h4>
							</center>
							<br><br>
							<!-- <p>Transaction Date: <?php echo date('F d, Y'); ?></p> -->

							<table class="table table-striped">
								<thead>
									<th>Account Number</th>
									<th>Name</th>
									<th>Total Bill</th>
									<th>Payment</th>
									<th>Balance</th>
								</thead>
								<?php
									$con=con();

									$accno = $_POST["accnumE"];
									$name = $_POST["cName"];
									$moneyCollected = 0;
									$name = $_SESSION['fname'] . " " . $_SESSION['lname'];
									
									// $sql= "SELECT * FROM bill as b INNER JOIN account as a ON b.account_id = a.account_id where DATE(amount_paid_date)=CURDATE() and amount_paid != 0 and teller = '$name'";
									$sql = "SELECT * FROM bill as b INNER JOIN account as a ON b.account_id = a.account_id WHERE b.amount_paid != 0 and bill_no ='$transDate' and teller = '$name'";
									$res = mysqli_query($con,$sql);

									while ($row = mysqli_fetch_array($res)) 
									{
								?>
										<tr>
											<td><?php echo $row['account_no']; ?></td>
											<td><?php echo $row['name']; ?></td>
											<td><?php echo "P " . number_format($row['amount_due'], 2); ?></td>
											<td><?php echo "P " . number_format($row['amount_paid'], 2); ?></td>
											<td><?php echo "P " . number_format($row['amount_due']-$row['amount_paid'], 2); ?></td>
										</tr>
								<?php
										$moneyCollected += $row['amount_paid'];
									}
								?>
										<tr style="text-align: right;">
											<td colspan="5"><strong>Total Money Collected: P <?php echo number_format($moneyCollected, 2); ?></strong></td>
										</tr>
							</table>
								<p>Transact by:</p><br><br>
									<u><?php echo $name; ?></u><br>
								Teller</p>
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
    <script src="js/moment/moment.js"></script>
    <script src="js/bootstrap-datetimepicker.js"></script>
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

