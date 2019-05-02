<?php
	include ("config.php");
	include ("security.php");
	if($_SESSION['user_type']!=1)
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
	  $headerTitle = "Meter Reading Reports";
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
                            <?php echo $headerTitle; ?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>  <a href="index.php">Home</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-dashboard"></i> <?php echo $headerTitle; ?>
                            </li>
                        </ol>
                    </div>
                </div>

				<div class="row" style="padding-top:0px; padding-bottom:40px; padding-right:40px; padding-left:40px;">
						
						<br><br>
						<h4>Monthly Meter Reading Reports</h4>
						<div class="options" style="float: right; cursor: hand;">
							<span class="glyphicon glyphicon-print" title="Print" onclick="printDiv('printTransactionHistory')""></span>
							<!-- <span class="glyphicon glyphicon-download-alt" title="Download" id="download"></span> -->
						</div>
						<br><br>
						<table class="table table-striped">
							<thead>
								<th>Date</th>
								<th>Account Number</th>
								<th>Name</th>
								<th>Meter Reading</th>
								<th>Data entered by</th>
							</thead>
							<?php
								$con=con();
								$todayYear = date("Y");
								$todayMonth = date("m");

								$sql= "SELECT * FROM account as a 
											INNER JOIN reading as r ON a.account_id = r.account_id
											WHERE month(r.date_time) = '$todayMonth' and year(r.date_time) = '$todayYear' 
											ORDER BY date_time DESC";
								$res = mysqli_query($con,$sql);

								while ($row = mysqli_fetch_array($res)) 
								{
									$date =  date('F d, Y' , strtotime($row['date_time']));
							?>
									<tr>
										<td><?php echo $date; ?></td>
										<td><?php echo $row['account_no']; ?></td>
										<td><?php echo $row['name']; ?></td>
										<td><?php echo $row['meter_level'] . " m³"; ?></td>
										<td><?php echo $row['emp_name']; ?></td>
									</tr>
							<?php
								}
							?>
						</table>



						<div id="printTransactionHistory" style="display:none;">
							<center>
								<img src="images/logoTWBD.png" width="150px" height="100px">
								<h2>Tubod-Baroy Water District</h2>
								<h4>Monthly Meter Reading Report</h4>
							</center><br>
							<table class="table table-borderless">
							<thead>
								<th>Date</th>
								<th>Account Number</th>
								<th>Name</th>
								<th>Meter Reading</th>
								<th>Data entered by</th>
							</thead>
							<?php
								$con=con();
								$todayYear = date("Y");
								$todayMonth = date("m");

								$sql= "SELECT * FROM account as a 
											INNER JOIN reading as r ON a.account_id = r.account_id
											WHERE month(r.date_time) = '$todayMonth' and year(r.date_time) = '$todayYear' 
											ORDER BY date_time DESC";
								$res = mysqli_query($con,$sql);

								while ($row = mysqli_fetch_array($res)) 
								{
									$date =  date('F d, Y' , strtotime($row['date_time']));
							?>
									<tr>
										<td><?php echo $date; ?></td>
										<td><?php echo $row['account_no']; ?></td>
										<td><?php echo $row['name']; ?></td>
										<td><?php echo $row['meter_level'] . " m³"; ?></td>
										<td><?php echo $row['emp_name']; ?></td>
									</tr>
							<?php
								}
							?>
						</table>
							<br><br>
							
								<p>Noted by:</p><br><br>
									<u><?php echo $name; ?></u><br>
								General Manager</p>
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

