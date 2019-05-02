<?php
include ("config.php");
include ("security.php");
if($_SESSION['user_type']!=1 && $_SESSION['user_type']!=2){
		header('Location: login.php?notPermitted=true');
		}
?>

<?php
	$errorName = "";
	$successAdd = false;
	$checking = false;
	$employee = $_SESSION['fname'] . " " . $_SESSION['lname'];
	$dateToday = date("Y-m-d");
	
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

	if(isset($_POST["add"]))
	{
		$con=con();
		$accnum = $randnum;
		$accountID = "";
		$accname = $_POST["accname"];
		$meternum = $_POST["meternum"];
		$streetadd = $_POST["streetadd"];
		$purok = $_POST["purok"];
		$barangay = $_POST["barangay"];
		$town = $_POST["town"];
		
		if($name = "")
			$errorName="error"; 
		else
		{
			$ins = mysqli_query($con,"INSERT INTO account VALUES (null, '$accnum', null, '$meternum', '$streetadd', '$purok', '$barangay', '$town', 1, '$accname', $dateToday, '$employee');");
			$successAdd = true;

			if ($successAdd == true)
			{
				$check = mysqli_query($con, "SELECT * FROM account WHERE account_no = '$accnum'");

				if ($checkRow = mysqli_fetch_array($check)) 
				{
					$accountID = $checkRow['account_id'];
					$checking = true;

					if($checking == true)
					{
						//MAY CONSIDER INSERTING A BILL
						$firstReading = mysqli_query($con,"INSERT INTO reading VALUES (null, '$accountID', '$dateToday', 0, '$employee');");
					}
				}
				
			}
		}
		discon($con);
	}

?>

<?php
	  $headerTitle = "Accounts";
      include "header.php";
?>
      
<html>
	<body>    
       <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Client's Account
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>  <a href="index.php">Home</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Client's Account
                            </li>
                        </ol>
                    </div>
                </div>	

                <div class="row" style="padding-top:0px; padding-bottom:40px; padding-right:40px; padding-left:40px;">

	                <div>
				 		<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active"><a href="#create_tab" aria-controls="pending" role="tab" data-toggle="tab">Create</a></li>
							<li role="presentation"><a href="#list_tab" aria-controls="approved" role="tab" data-toggle="tab">See List</a></li>
						</ul>
					</div>

					<br>
					<center>
						<div class="alert alert-success" style="<?php if(!$successAdd) echo "display:none";?>">
							New account <strong>sucessfully added!</strong>
					</center>

					<div class="tab-content">

						<div role="tabpanel" class="tab-pane active" id="create_tab" >
							<br>
							<form action="" method="post" class="form-horizontal">
								<table>
									<tr>
										<td>
											<div class="form-group">
												<label class="control-label col-sm-5">Status:</label>
												<div class="col-sm-7">
													<select name="status"  class="form-control" disabled>
													  <option id="active" value="2">Active</option>
													  <option id="disconnected" value="1">Disconnected</option>
													</select>
												</div>
											 </div>
											<div class="form-group">
												<label class="control-label col-sm-5">Account Number:</label>
												<div class="col-sm-7">
													<input type="text" class="form-control" name="accnum" value="<?php echo $randnum; ?>" readOnly>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Account Name:</label>
												<div class="col-sm-7">
													<input type="text" class="form-control" name="accname" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Meter Serial Number:</label>
												<div class="col-sm-7">
													<input type="text" class="form-control" name="meternum" required>
												</div>
											 </div>
										</td>
										<td>
											<div class="form-group">
												<label class="control-label col-sm-5">Street address:</label>
												<div class="col-sm-7">
													<input type="text" class="form-control" name="streetadd" required>
												</div>
											 </div>
											<div class="form-group">
												<label class="control-label col-sm-5">Purok/Subdivision:</label>
												<div class="col-sm-7">
													<input type="text" class="form-control" name="purok" required>
												</div>
											 </div>
											<div class="form-group">
												<label class="control-label col-sm-5">Barangay:</label>
												<div class="col-sm-7">
													<input type="text" class="form-control" name="barangay" required>
												</div>
											 </div>
											<div class="form-group">
												<label class="control-label col-sm-5">Town:</label>
												<div class="col-sm-7">
													<input type="text" class="form-control" name="town"  required>
												</div>
											 </div>
											
										</td>
										<td  class="col-sm-4">
											<div class="form-group">
												<div class="col-sm-7">
													<input type="submit" name="add" class="form-control btn btn-primary" value="Add Client">
												</div>
											 </div>
										</td>
									</tr>
								</table>
							</form>
						</div>

						<div role="tabpanel" class="tab-pane" id="list_tab" >
			                <br>
							<table class="table table-responsive">
								<thead>
									<tr>
										<th>Account No.</th>
										<th>Account Name</th>
										<th>Address</th>
										<th>Status</th>
										<th>Phone</th>
										<th>Email</th>
										<!-- <th>Action</th> -->
									</tr>
								</thead>
								<?php
									$con=con();
									
									$sql= "SELECT * FROM account as a LEFT JOIN user as u ON u.user_id = a.user_id WHERE a.status = 1;";
									$res = mysqli_query($con,$sql);

									while ($row = mysqli_fetch_array($res)) 
									{
								?>
										<tr>
											<td><?php echo $row['account_no']; ?></td>
											<td><?php echo $row['name']; ?></td>
											<td><?php echo $row['street_add'] ." ". $row['purok_sub'] ." ". $row['barangay'] ." ". $row['town'] ." Lanao del Norte"; ?></td>
											<td><?php echo "Active"; ?></td>
											<td><?php echo $row[15]; ?></td>
											<td><?php echo $row[16]; ?></td>
											<!-- <td><a href='<?php echo "edit.php?id=". $row['account_id']; ?>' class='btn btn-info' role='button'>View</a></td> -->
										</tr>
								<?php 
									}
									discon($con);
								?>
							</table>
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

	</body>
</html>

