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
	$partialPayment = 0;
	$partial = 0;
	$todayYear = date("Y");
	$todayMonth = date("m");

	if(isset($_POST["pay"]))
	{
			$con=con();
			$billidE = $_POST["billidE"];
			$accid = $_POST["accidE"];
			$paymentE = $_POST["money"];
			$todayE = date("Y-m-d H:i:s");

			$res4=mysqli_query($con,"SELECT * FROM bill WHERE account_id = $accid ORDER BY date_time DESC;");
			$row4 = mysqli_fetch_array($res4);

			if($row4[0]==$billidE)
			{
				$prevPayment = $row4['amount_paid'];
				$totalPayment = ($paymentE + $prevPayment);
				$_SESSION['payment'] = $paymentE;

				$sqlb = "UPDATE bill SET amount_paid_date = '$todayE', amount_paid = '$totalPayment', teller='".$_SESSION['fname']." ".$_SESSION['lname']."' WHERE bill_id = $billidE;";
				$resb=mysqli_query($con, $sqlb);
				
				header("Location: invoice.php?bill=$billidE");
				$successEdit=true;	
					
			}
			// else
			// 	$errorEdit=true;
				
			discon($con);
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
					<center>
						<div class="alert alert-success" style="<?php if(!$successEdit) echo "display:none";?>">
							Update <strong>sucessful!</strong>
						</div>
						<div class="alert alert-danger" style="<?php if(!$errorEdit) echo "display:none";?>">
							<strong>Update failed!</strong> You can only edit the latest bill of a particular account.
						</div>
					</center>

				  	<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="update" >
							<form action="" method="post" class="form-horizontal" data-toggle="validator">
								<fieldset id="editform">
									<table>
										<tr>
											<td>
												<input type="hidden" class="form-control" name="billidE" id="billidE" required>
												<div class="form-group">
													<label class="control-label col-sm-5" for="accnumE">Account Number:</label>
													<div class="col-sm-7">
														<input type="text" class="form-control" name="accnumE" id="accnumE">
													</div>
												</div>
											</td>
											</tr>
											<tr>
											<td>
												<div class="form-group">
													<label class="control-label col-sm-5" for="accnumE">Name:</label>
													<div class="col-sm-7">
														<select name="clientName" class="form-control">
															<!-- <option value="">Client Name</option> -->
															<?php

																$con = con();

																$fetchData = mysqli_query($con, "SELECT * FROM account WHERE status = 1;");

																while ($rowFetchData = mysqli_fetch_array($fetchData)) 
																{
															?>
																	<option value="<?php echo $rowFetchData['account_id']; ?>"><?php echo $rowFetchData['name']; ?></option>
															<?php
																}
															?>
														</select>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="form-group">
													<label type="hidden" class="control-label col-sm-5" for="billnoE"></label>
													<div class="col-sm-7">
														<input type="submit" name="search" id="edit" tabindex="" class="form-control btn btn-primary" value="Search">
													</div>
												 </div>
											</td>
										</tr>
									</table>
								</fieldset>
							</form>
						</div>
					</div>
					<br>

					<?php
						//IF BUTTON SEARCH IS CLICKED
						if(isset($_POST["search"]))
						{
							$con=con();

							$accno = $_POST["accnumE"];
							$client = $_POST["clientName"];

							//add LIMIT 1 to sql if possible
							$sql= "SELECT * FROM bill as b LEFT JOIN account as a ON b.account_id = a.account_id WHERE a.account_no = '$accno' ORDER BY bill_id DESC;";
							
							$res = mysqli_query($con,$sql);

							$sql2= "SELECT * FROM bill as b LEFT JOIN account as a ON b.account_id = a.account_id WHERE b.account_id = $client ORDER BY bill_id DESC LIMIT 1;";
							$res2 = mysqli_query($con, $sql2);

							//IF THE TEXTBOX ACOUNT NUMBER IS SET
							if(isset($accno))
							{
								if ($row = mysqli_fetch_array($res)) 
								{
									$prev_reading_date =  date('F d, Y' , strtotime($row['prev_reading_date']));
									$pres_reading_date =  date('F d, Y' , strtotime($row['pres_reading_date']));
									$date =  date('F Y' , strtotime($row['date_time']));
									$payment = $row['amount_due'];
									$water_consumption = $row['pres_reading'] - $row['prev_reading'];
					?>
									<div class="row">
										<div class="col-xs-7" >
									  		<div class="panel panel-default">
												<div class="panel-body">
														<div class=" col-md-9 col-lg-9 "> 
															<table class="table table-borderless">
																<tbody>
																	<tr>
																		<td>Name:</td>
																		<td><?php echo $row['name']; ?></td>
																	</tr>
																	<tr>
																		<td>Address:</td>
																		<td><?php echo $row['street_add'] ." ". $row['purok_sub'] ." ". $row['barangay'] . " Lanao del Norte"; ?></td>
																	</tr>
																	<tr>
																		<td>Account Number:</td>
																		<td><?php echo $row['account_no']; ?></td>
																	</tr>
																	<tr>
																		<td>Meter Serial Number:</td>
																		<td><?php echo $row['meter_no']; ?></td>
																	</tr>
																	<tr>
																		<td colspan="2"><hr></td>
																	</tr>
																	<tr>
																		<td>Previous Reading:</td>
																		<td><?php echo str_pad(number_format($row['prev_reading'], 0, '.', ''), 6, '0', STR_PAD_LEFT) . " m³"; ?></td>
																	</tr>
																	<tr>
																		<td>Previous Reading Date:</td>
																		<td><?php echo $prev_reading_date; ?></td>
																	</tr>
																	<tr>
																		<td>Present Reading:</td>
																		<td><?php echo str_pad(number_format($row['pres_reading'], 0, '.', ''), 6, '0', STR_PAD_LEFT) . " m³"; ?></td>
																	</tr>
																	<tr>
																		<td>Present Reading Date:</td>
																		<td><?php echo $pres_reading_date; ?></td>
																	</tr>
																	<tr>
																		<td>Water Consumption in cu. m:</td>
																		<td><?php echo $water_consumption . " m³"; ?></td>
																	</tr>
																	<tr>
																		<td>For the month of:</td>
																		<td><?php echo $date; ?></td>
																	</tr>
																	<tr>
																		<td colspan="2"><hr></td>
																	</tr>
																	<tr>
																		<td>Current Bill:</td>
																		<td><?php echo "P " . number_format($row['amount_due'] - $row['arears'], 2); ?></td>
																	</tr>
																	<tr>
																		<td>Arears:</td>
																		<td><?php echo "P " . number_format($row['arears'], 2); ?></td>
																	</tr>
																	<tr>
																		<td colspan="2"><hr></td>
																	</tr>
																	<tr>
																		<td><strong>Total Billing</strong>:</td>
																		<td><?php echo "P " . number_format($row['amount_due'], 2); ?></td>
																	</tr>
																	<tr>
																		<td><strong>Payment</strong>:</td>
																		<td><?php echo "P " . number_format($row['amount_paid'], 2); ?></td>
																	</tr>
																	<tr>
																		<td><strong>Balance</strong>:</td>
																		<td><?php echo "P " . number_format($row['amount_due']-$row['amount_paid'], 2); ?></td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-4">
												<form method="post">
												<table>
													<tbody>
														<tr>
															<td>
															<input type="hidden" class="form-control" name="accidE" id="accidE" value="<?php echo $row['account_id'];?>" required>
															<input type="hidden" class="form-control" name="billidE" id="billidE" value="<?php echo $row['bill_id'];?>" required>
															<!-- <label class="control-label col-sm-5" for="accnum">Total:</label></td>
															<td><input type="text" class="form-control" name="total" id="total" value="<?php echo number_format($row['amount_due'], 2);?>" readOnly></td> -->
														</tr>
														<tr>
															<td colspan="2"><br></td>
														</tr>
														<tr>
															<td><label class="control-label col-sm-5" for="money">Payment:</label></td>
															<td><input type="text" class="form-control" name="money" id="money" required></td>
														</tr>
														<tr>
															<td colspan="2"><br></td>
														</tr>
														
														<tr>
															<td colspan="2"><br></td>
														</tr>
														<tr>
															<td><label></label></td>
															<td><input type="submit" name="pay" id="add" tabindex="" class="form-control btn btn-success" value="Submit"></td>
														</tr>
													</tbody>
												</table>
												</form>
											</div>
										</div>
									</div>
					<?php
								}
								elseif(isset($client))
								{
									if ($row2 = mysqli_fetch_array($res2)) 
									{
										$prev_reading_date =  date('F d, Y' , strtotime($row2['prev_reading_date']));
										$pres_reading_date =  date('F d, Y' , strtotime($row2['pres_reading_date']));
										$date =  date('F Y' , strtotime($row2['date_time']));
										$payment = $row2['amount_due'];
										$water_consumption = $row2['pres_reading'] - $row2['prev_reading'];
									}
					?>
									<div class="row">
										<div class="col-xs-7" >
									  		<div class="panel panel-default">
												<div class="panel-body">
														<div class=" col-md-9 col-lg-9 "> 
															<table class="table table-borderless">
																<tbody>
																	<tr>
																		<td>Name:</td>
																		<td><?php echo $row2['name']; ?></td>
																	</tr>
																	<tr>
																		<td>Address:</td>
																		<td><?php echo $row2['street_add'] ." ". $row2['purok_sub'] ." ". $row2['barangay'] . " Lanao del Norte"; ?></td>
																	</tr>
																	<tr>
																		<td>Account Number:</td>
																		<td><?php echo $row2['account_no']; ?></td>
																	</tr>
																	<tr>
																		<td>Meter Serial Number:</td>
																		<td><?php echo $row2['meter_no']; ?></td>
																	</tr>
																	<tr>
																		<td colspan="2"><hr></td>
																	</tr>
																	<tr>
																		<td>Previous Reading:</td>
																		<td><?php echo str_pad(number_format($row2['prev_reading'], 0, '.', ''), 6, '0', STR_PAD_LEFT) . " m³"; ?></td>
																	</tr>
																	<tr>
																		<td>Previous Reading Date:</td>
																		<td><?php echo $prev_reading_date; ?></td>
																	</tr>
																	<tr>
																		<td>Present Reading:</td>
																		<td><?php echo str_pad(number_format($row2['pres_reading'], 0, '.', ''), 6, '0', STR_PAD_LEFT) . " m³"; ?></td>
																	</tr>
																	<tr>
																		<td>Present Reading Date:</td>
																		<td><?php echo $pres_reading_date; ?></td>
																	</tr>
																	<tr>
																		<td>Water Consumption in cu. m:</td>
																		<td><?php echo $water_consumption . " m³"; ?></td>
																	</tr>
																	<tr>
																		<td>For the month of:</td>
																		<td><?php echo $date; ?></td>
																	</tr>
																	<tr>
																		<td colspan="2"><hr></td>
																	</tr>
																	<tr>
																		<td>Current Bill:</td>
																		<td><?php echo "P " . number_format($row2['amount_due'] - $row2['arears'], 2); ?></td>
																	</tr>
																	<tr>
																		<td>Arears:</td>
																		<td><?php echo "P " . number_format($row2['arears'], 2); ?></td>
																	</tr>
																	<tr>
																		<td colspan="2"><hr></td>
																	</tr>
																	<tr>
																		<td><strong>Total Billing</strong>:</td>
																		<td><?php echo "P " . number_format($row2['amount_due'], 2); ?></td>
																	</tr>
																	<tr>
																		<td><strong>Payment</strong>:</td>
																		<td><?php echo "P " . number_format($row2['amount_paid'], 2); ?></td>
																	</tr>
																	<tr>
																		<td><strong>Balance</strong>:</td>
																		<td><?php echo "P " . number_format($row2['amount_due']-$row2['amount_paid'], 2); ?></td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-4">
												<form method="post">
												<table>
													<tbody>
														<tr>
															<td>
															<input type="hidden" class="form-control" name="accidE" id="accidE" value="<?php echo $row2['account_id'];?>" required>
															<input type="hidden" class="form-control" name="billidE" id="billidE" value="<?php echo $row2['bill_id'];?>" required>
															<!-- <label class="control-label col-sm-5" for="accnum">Total:</label></td>
															<td><input type="text" class="form-control" name="total" id="total" value="<?php echo number_format($row['amount_due'], 2);?>" readOnly></td> -->
														</tr>
														<tr>
															<td colspan="2"><br></td>
														</tr>
														<tr>
															<td><label class="control-label col-sm-5" for="money">Payment:</label></td>
															<td><input type="text" class="form-control" name="money" id="money" required></td>
														</tr>
														<tr>
															<td colspan="2"><br></td>
														</tr>
														
														<tr>
															<td colspan="2"><br></td>
														</tr>
														<tr>
															<td><label></label></td>
															<td><input type="submit" name="pay" id="add" tabindex="" class="form-control btn btn-success" value="Submit"></td>
														</tr>
													</tbody>
												</table>
												</form>
											</div>
										</div>
									</div>
					<?php
								$partialPayment = $row2['amount_paid'];
								}
							}
							else
								$errorRet = true;
							

							discon($con);
						}												
					?>

						<div class="alert alert-danger" style="<?php if(!$errorRet) echo "display:none";?>">
							Account number and/or Name <strong>does not exists!</strong>
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

	</body>
</html>

