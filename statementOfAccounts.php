<?php
	include ("config.php");
	include ("security.php");
	if($_SESSION['user_type']!=3)
	{
		header('Location: login.php?notPermitted=true');
	}
?>

<?php
	  $headerTitle = "My Accounts";
      include "header.php";
?>
      
<html>
	<body>      
       <div id="page-wrapper">
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
                            <li>
                                <i class="fa fa-fw fa-dashboard"></i>  <a href="myAccounts.php">My Accounts</a>
                            </li>
                            <li>
                                <i class="glyphicon glyphicon-eye-open"></i> <a href="overview.php">Overview</a>
                            </li>
                            <li class="active">
                                <i class="glyphicon glyphicon-list-alt"></i> Statement of Accounts
                            </li>
                        </ol>
                    </div>
                </div><br><br>                
                
				<div class="row" style="padding-top:0px; padding-bottom:40px; padding-right:40px; padding-left:40px;">
					<table class="table table-striped table-responsive">
						<thead>
							<tr>
								<th style="display:none;">Bill ID</th>
								<th>Date</th>
								<th style="display:none;">Account ID</th>
								<th>Arears</th>
								<th>Amount Due</th>
								<th>Total Bill</th>
								<th>Due Date</th>
								<th>Amount Paid</th>
								<th>Paid Date</th>
								<th>Status</th>
								<!-- <th>Action</th> -->
							</tr>
						</thead>

							<?php
								$con=con();
								
								$sql= "SELECT * FROM bill as b INNER JOIN account as a ON b.account_id = a.account_id AND b.account_id = ".$_SESSION["account"]." ORDER BY b.date_time DESC;";

								$res = mysqli_query($con,$sql);

								while ($row = mysqli_fetch_array($res)) 
								{
									
									$time = strtotime($row['date_time']);
									$duedate = strtotime("+7 day", $time);
									$duedateE = date("Y-m-d", $duedate);
									$due = date('F d, Y' , strtotime($duedateE));
									// $paid_date = date('F d, Y' , strtotime($row['amount_paid_date']));
									$date =  date('F Y' , strtotime($row['date_time']));
									$today = strtotime(date("Y-m-d H:i:s"));
									$totalbill = ($row['amount_due'] + $row['arears']);
									
									if($row['amount_paid_date'] == null)
										$paid_date = "------------------------";
									else
										$paid_date = date('F d, Y' , strtotime($row['amount_paid_date']));
									
									if($today>$duedate && $row[10] == 0)
										$status = "Delinquent";
									elseif($row[10] == 0)
										$status = "Unpaid";
									else
										$status = "Paid";
							?>
									<tr>
										<td style='display:none;'><?php echo $row[0]; ?></td>
										<td><?php echo $date; ?></td>
										<td style='display:none;'><?php echo $row['account_id']; ?></td>
										<td><?php echo "P " . number_format($row['arears'], 2); ?></td>
										<td><?php echo "P " . number_format($row['amount_due'], 2); ?></td>
										<td><?php echo "P " . number_format($totalbill, 2); ?></td>
										<td><?php echo $due; ?></td>
										<td><?php echo "P " . number_format($row['amount_paid'], 2); ?></td>
										<td><?php echo $paid_date; ?></td>
										<td><?php echo $status; ?></td>
										<!-- <td><a href='invoice.php?bill=<?php echo $row[0]; ?>' class='btn btn-success'>View<a></td> -->
									</tr>
							<?php
								}
								discon($con);
							?>
					</table>
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

	</body>
</html>

