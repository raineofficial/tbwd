<?php
	include ("config.php");
	include ("security.php");
	if($_SESSION['user_type']!=1 && $_SESSION['user_type']!=2)
	{
		header('Location: login.php?notPermitted=true');
	}
?>

<?php
	
	$checking=false;
	$dateToday = date("Y-m-d");
	$employee = $_SESSION['fname'] . " " . $_SESSION['lname'];

	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
	}

	$con=con();

	$randnum = rand(1111111111,9999999999);
	$cond=True;
	while($cond)
	{
		$query = "SELECT * FROM account WHERE account_no = '$randnum'";
		$result = $con->query($query);
		
		if(mysqli_num_rows($result)>0)
			$randnum = rand(1111111111,9999999999);
		else
			$cond=False;
	}

	$sql= "SELECT * FROM account as a INNER JOIN user as u ON a.user_id = u.user_id WHERE account_id = ".$id.";";
	$res = mysqli_query($con,$sql);
	if ($row = mysqli_fetch_array($res)) 
	{
		$accno=  $row['account_no'];
		$accname=$row{'name'};
		$meterno = $row{'meter_no'};
		$streetadd =  $row['street_add'];
		$purok =  $row['purok_sub'];
		$barangay = $row['barangay'];
		$town = $row['town'];
		$status = $row['status'];
		$phone = $row['phone'];
		$email = $row['email'];
	}

	$successEdit = false;
	$error1 = false;
	$error2 = false;
	$error3 = false;

	if(isset($_POST["edit"]))
	{
		$con=con();
		$accnum = $randnum;
		$name = $accname;
		$meternum = $_POST["meternumE"];
		$streetadd = $_POST["streetaddE"];
		$purok = $_POST["purokE"];
		$barangay = $_POST["barangayE"];
		$town = $_POST["townE"];
		$status = $_POST["statusE"];

		if($status == 1 and $meternum == "") //active but no meter
			$error1 = true;
		elseif($status == 3 and $meternum != "") //pending but has meter
			$error2 = true;
		elseif($status == 2 and $meternum != "") //disapproved but has meter
			$error3 = true;
		else
		{
			$sql = "UPDATE account SET account_no = '$accnum', meter_no = '$meternum', street_add = '$streetadd', purok_sub = '$purok', barangay = '$barangay', town = '$town', status= $status, name='$name', approved='$employee' WHERE account_id=$id;";
			$res=mysqli_query($con, $sql);

			if($status==1)
			{
				$check = mysqli_query($con, "SELECT * FROM account WHERE account_no = '$accnum'");
				$checking = true;

				if($checking == true)
				{
					$firstReading = mysqli_query($con,"INSERT INTO reading VALUES (null, '$id', '$dateToday', 0, '$employee');");
				}
			}
			header('Location:connectionRequests.php');
		}
		
	}
	discon($con);
?>

<?php
	  $headerTitle = "Pre-registration";
      include "header.php";
?>
   

<html>
	<head>
		<style>
			.clickable-row {
	                background:none;
	                color:black;
	            }

	        .clickable-row:hover {
	            background-color: #f5f5f5;
	            cursor: pointer;
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
                            <li>
                                <i class="fa fa-dashboard"></i> <a href="connectionRequests.php">Pre-registration</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Details
                            </li>
                        </ol>
                    </div>
                </div>

				<div class="row" style="padding-top:0px; padding-bottom:40px; padding-right:40px; padding-left:40px;">
					
					<center>
						<div class="alert alert-success" style="<?php if(!$successEdit) echo "display:none";?>">
							Update <strong>sucessful!</strong>
						</div>
						<div class="alert alert-danger" style="<?php if(!$error1) echo "display:none";?>">
							Meter status is active! <strong>Please enter the meter serial number.</strong>
						</div>
						<div class="alert alert-danger" style="<?php if(!$error2) echo "display:none";?>">
							Meter serial number is provided<strong> but connection request is  still pending!</strong>
						</div>
						<div class="alert alert-danger" style="<?php if(!$error3) echo "display:none";?>">
							Meter serial number is provided<strong> but connection request is disapproved!</strong>
						</div>
					</center>
					
				 	<div class="row">
							<form action="" method="post" class="form-horizontal">
									<table>
										<tr>
											<td>
												<div class="form-group">
													<label class="control-label col-sm-5">Status:</label>
													<div class="col-sm-7">
														<select name="statusE" class="form-control">
														  <option value="3" <?php if ($status == 3) { echo 'selected'; } ?> >Pending</option>
														  <option value="2" <?php if ($status == 2) { echo 'selected'; } ?> >Disapproved</option>
														  <option value="1" <?php if ($status == 1) { echo 'selected'; } ?> >Active</option>
														</select>
													</div>
												 </div>
												<div class="form-group">
													<label class="control-label col-sm-5"">Account Number:</label>
													<div class="col-sm-7">
														<input type="text" class="form-control" name="accnumE" value="<?php echo $randnum; ?>" disabled>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-5">Account Name:</label>
													<div class="col-sm-7">
														<input type="text" class="form-control" name="nameE" value="<?php echo $accname; ?>" disabled>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-5">Meter Serial Number:</label>
													<div class="col-sm-7">
														<input type="text" class="form-control" name="meternumE">
													</div>
												 </div>
												 <div class="form-group">
													<label class="control-label col-sm-5">Street address:</label>
													<div class="col-sm-7">
														<input type="text" class="form-control" name="streetaddE" value="<?php echo $streetadd; ?>" required>
													</div>
												 </div>
												<div class="form-group">
													<label class="control-label col-sm-5">Purok/Subdivision:</label>
													<div class="col-sm-7">
														<input type="text" class="form-control" name="purokE" value="<?php echo $purok; ?>"required>
													</div>
												 </div>
												<div class="form-group">
													<label class="control-label col-sm-5">Barangay:</label>
													<div class="col-sm-7">
														<input type="text" class="form-control" name="barangayE" value="<?php echo $barangay; ?>" required>
													</div>
												 </div>
												<div class="form-group">
													<label class="control-label col-sm-5">Town:</label>
													<div class="col-sm-7">
														<input type="text" class="form-control" name="townE" value="<?php echo $town; ?>" required>
													</div>
												 </div>
												 <div class="form-group">
													<label class="control-label col-sm-5">Phone:</label>
													<div class="col-sm-7">
														<input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" disabled>
													</div>
												 </div>
												 <div class="form-group">
													<label class="control-label col-sm-5">Email:</label>
													<div class="col-sm-7">
														<input type="text" class="form-control" name="phone" value="<?php echo $email; ?>" disabled>
													</div>
												 </div>
											</td>
											<td  class="col-sm-4">
												<div class="form-group">
													<div class="col-sm-7">
														<input type="submit" name="edit" class="form-control btn btn-primary" value="Edit">
													</div>
												 </div>
											</td>
										</tr>
									</table>
								</form>
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

	</body>
</html>

