<?php
	include ("config.php");
	include ("security.php");
	if($_SESSION['user_type']!=3)
	{
		header('Location: login.php?notPermitted=true');
	}
		$_SESSION["account"]=null;
?>

<?php
	$today = date('Y-m-d');
	$errorLinked = false;
	$errorMatch = false;
	$successAdd = false;
	$successReq = false;
	$errorName=false; 
	$firstN = $_SESSION['fname'];
	$lastN = $_SESSION['lname'];
	$name = $firstN ." ". $lastN;

	if(isset($_POST["req"]))
	{
		$con=con();
		$streetadd = $_POST["streetadd"];
		$purok = $_POST["purok"];
		$barangay = $_POST["barangay"];
		$town = $_POST["town"];
		$date_requested = $today;
		
		$res3=mysqli_query($con,"SELECT * FROM user WHERE fname = '$firstN' and lname = '$lastN';");
		// $res3= "SELECT * FROM user WHERE fname = '$firstN' and lname = '$lastN';";
		// echo $res;
		
		if(mysqli_num_rows($res3) == 1)
		{
			$ins = mysqli_query($con,"INSERT INTO account VALUES (null, null, ".$_SESSION["id"].", null, '$streetadd', '$purok', '$barangay', '$town', 3, '$name', '$date_requested', null);");
			$successReq = true;
		}
		discon($con);
	}
?>

<?php
	  $headerTitle = "Pre-register";
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
                            <li class="active">
                                <i class="fa fa-dashboard"></i> <?php echo $headerTitle;?>
                            </li>
                        </ol>
                        <div class="">
							<strong>Note:</strong> Enter the following details below for multiple shared accounts.
						</div><br>
						<center>
						<div class="alert alert-success" style="<?php if(!$successReq) echo "display:none";?>">
							<strong>You have successfully requested for a new water service connection!</strong> Expect a call or email from one of our staffs for verification and connection process!
						</div>
						</center>
                    </div>
                </div> 
				<form action="" method="post" class="form-horizontal" data-toggle="validator">
					<table>
						<tr>
							<td>
								<div class="form-group">
									<label class="control-label col-sm-5" for="name">Account Name:</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>" disabled>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-5" for="streetadd">Street:</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="streetadd" id="streetadd" required>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-5" for="purok">Purok/Subdivision:</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="purok" id="purok" required>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-5" for="barangay">Barangay:</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="barangay" id="barangay" required>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-5" for="town">Town:</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="town" id="town" required>
									</div>
								</div> <br>
								<div class="form-group">
									<label type="hidden" class="control-label col-sm-5" for="town"></label>
									<div class="col-sm-7">
										<input type="submit" name="req" id="req" tabindex="" class="form-control btn btn-warning" value="Request">
									</div>
								</div>
							</td>
						</tr>
					</table>
				</form>

<?php

// if(isset($_POST["req"]))
// 	{
// 		$con=con();
// 		$streetadd = $_POST["streetadd"];
// 		$purok = $_POST["purok"];
// 		$barangay = $_POST["barangay"];
// 		$town = $_POST["town"];
// 		$date_requested = $today;
		
// 		$res3=mysqli_query($con,"SELECT * FROM user WHERE fname = '$firstN' and lname = '$lastN';");
// 		// $res3= "SELECT * FROM user WHERE fname = '$firstN' and lname = '$lastN';";
// 		// echo $res3;
		
// 		if(mysqli_num_rows($res3) == 1)
// 		{
// 			$ins = mysqli_query($con,"INSERT INTO account VALUES (null, null, ".$_SESSION["id"].", null, '$streetadd', '$purok', '$barangay', '$town', 3, '$name', '$date_requested', null);");
// 			$successReq = true;
// 		}
// 		discon($con);
// 	}
	?>
				<br><br><hr>
				<h4>Requested Connections</h4><br>
           			<table class="table table-striped table-responsive">
						<thead>
							<tr>
								<th style="display:none;">Account ID</th>
								<th>Date requested</th>
								<th>Address</th>
								<th>Status</th>
							</tr>
						</thead>
							<?php
								$con=con();
								$sql= "SELECT * FROM account as a LEFT JOIN user as u ON u.user_id = a.user_id WHERE (a.status = 4 OR a.status = 3) AND a.user_id = ".$_SESSION["id"].";";
								$res = mysqli_query($con,$sql);
								while ($row = mysqli_fetch_array($res)) 
								{
									$requested =  date('F d, Y' , strtotime($row['date_requested']));
							?>
									<tr>
										<td style='display:none;'><?php echo $row['account_id']; ?></td>
										<td><?php echo $requested; ?></td>
										<td><?php echo $row['street_add'] ." ". $row['purok_sub'] ." ". $row['barangay'] ." ". $row['town'] ." Lanao del Norte";; ?></td>
										<td>
							<?php
											if($row['status']==3)
												echo "Pending";
											else
												echo "Disapproved";
							?>
										</td>
									</tr>
							<?php
								}
								discon($con);
							?>
					</table>
			</div>
		</div>

		<script src="js/jquery.js"></script>
	    <script src="js/bootstrap.min.js"></script>
	    <script src="js/jquery.dataTables.min.js"></script>
	    <script src="js/dataTables.buttons.min.js"></script>
	    <script src="js/dataTables.select.min.js"></script>
	    <script src="js/validator.js"></script>
	    
	    <script>
			$(document).ready(function() {
				var table = $('#table').DataTable( {
					select: true,
				} );

				$('#table tbody').on('click', 'tr', function () {
					var data = table.row( this ).data();
				} );
			} );

			$(document).ready(function() {
				var table = $('#table2').DataTable( {
					select: true,
				} );

				$('#table2 tbody').on('click', 'tr', function () {
					var data = table.row( this ).data();
					$("#editform").prop('disabled', false);
				} );
			} );
		</script>
	</body>
</html>