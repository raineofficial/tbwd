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
	  $headerTitle = "Client Reports";
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
                            Client Accounts
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>  <a href="index.php">Home</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Client Accounts
                            </li>
                        </ol>
                    </div>
                </div>

				<div class="row" style="padding-top:0px; padding-bottom:40px; padding-right:40px; padding-left:40px;">

						<div id="printTransactionHistory" style="display: none; margin-top:0;">
							<center>
								<img src="images/logoTWBD.png" width="150px" height="110px">
								<h2>Tubod-Baroy Water District</h2>
								<h4>Monthly Reports for Client Registration</h4>
							</center><br><br>
							<table class="table table-borderless">
								<thead>
								<th>Date</th>
								<th>Acc. #</th>
								<th>Name</th>
								<th>Meter Serial #</th>
								<th>Address</th>
								<th>Approved by</th>
							</thead>
							<?php
								$con=con();
								$todayYear = date("Y");
								$todayMonth = date("m");

								$sql= "SELECT * FROM account WHERE status = 1 and month(date_requested) = '$todayMonth' and year(date_requested) = '$todayYear' ORDER BY date_requested DESC";
								$res = mysqli_query($con,$sql);

								while ($row = mysqli_fetch_array($res)) 
								{
									$date =  date('F d, Y' , strtotime($row['date_requested']));
							?>
									<tr>
										<td><?php echo $date; ?></td>
										<td><?php echo $row['account_no']; ?></td>
										<td><?php echo $row['name']; ?></td>
										<td><?php echo $row['meter_no']; ?></td>
										<td><?php echo $row['street_add'] ." ". $row['purok_sub'] ." ". $row['barangay'] ." ". $row['town'] ." Lanao del Norte"; ?></td>
										<td><?php echo $row['approved']; ?></td>
									</tr>
							<?php
									$moneyCollected += $row['amount_paid'];
								}
							?>
							</table>
							<br><br>
							
								<p>Noted by:</p><br><br>
									<u><?php echo $name; ?></u><br>
								General Manager</p>
						</div>
						
						<br><br>
						<h4>Monthly Reports of Client Registration</h4>
						<div class="options" style="float: right; cursor: hand;">
							<span class="glyphicon glyphicon-print" title="Print" onclick="printDiv('printTransactionHistory')""></span>
							<!-- <span class="glyphicon glyphicon-download-alt" title="Download" id="download"></span> -->
						</div>
						<br><br>
						<table class="table table-striped">
							<thead>
								<th>Date Approved</th>
								<th>Account Number</th>
								<th>Name</th>
								<th>Meter Serial Number</th>
								<th>Address</th>
								<th>Approved by</th>
							</thead>
							<?php
								$con=con();
								$todayYear = date("Y");
								$todayMonth = date("m");

								$sql= "SELECT * FROM account WHERE status = 1 and month(date_requested) = '$todayMonth' and year(date_requested) = '$todayYear' ORDER BY date_requested DESC";
								$res = mysqli_query($con,$sql);

								while ($row = mysqli_fetch_array($res)) 
								{
									$date =  date('F d, Y' , strtotime($row['date_requested']));
							?>
									<tr>
										<td><?php echo $date; ?></td>
										<td><?php echo $row['account_no']; ?></td>
										<td><?php echo $row['name']; ?></td>
										<td><?php echo $row['meter_no']; ?></td>
										<td><?php echo $row['street_add'] ." ". $row['purok_sub'] ." ". $row['barangay'] ." ". $row['town'] ." Lanao del Norte"; ?></td>
										<td><?php echo $row['approved']; ?></td>
									</tr>
							<?php
									$moneyCollected += $row['amount_paid'];
								}
							?>
						</table>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    
	<script type="text/javascript">     
		function printDiv(printTransactionHistory) 
		{
			var printContents = document.getElementById('printTransactionHistory').innerHTML;
			var originalContents = document.body.innerHTML;

			document.body.innerHTML = printContents;

			window.print();

			document.body.innerHTML = originalContents;
		}

		// var doc = new jsPDF();
		// var specialElementHandlers = 
		// {
		// 	'#editor': function (element, renderer) {
		// 	return true; }
		// };

		// $('#download').click(function () {
		// 	doc.fromHTML($('#printTransactionHistory').html(), 2, 2, {
		// 	// 'width': 170,
		// 	'elementHandlers': specialElementHandlers
		// 	});
		// 	doc.save('sample.pdf');

		// });
// 		$(document).ready(function() {
//   $("#download").click(function() {

//     var doc = new jsPDF('p', 'pt', 'a4', true);

//     doc.fromHTML($('#printTransactionHistory').get(0), 15, 15, {
//       'width': 250,
// 'margin': 1,
// 'pagesplit':true
//     },
//     function(){
//         doc.save('thisMotion.pdf');
//     });
//   });
// })
	</script>
	</body>
</html>

