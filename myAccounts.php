<?php
	include ("config.php");
	include ("security.php");
	if($_SESSION['user_type']!=3)
	{
		header('Location: login.php?notPermitted=true');
	}
		$_SESSION["account"]=null;

	// account status:
	// 1 - Active
	// 2 - Disapproved
	// 3 - Pending
	// 4 - Disconnected
?>

<?php
	$errorLinked = false;
	$errorMatch = false;
	$successAdd = false;

	if(isset($_POST["add"]))
	{
		$con=con();
		$userID= $_SESSION["id"];
		$accnum = $_POST["accnum"];
		$meternum = $_POST["meternum"];
		
		$res2=mysqli_query($con,"SELECT * FROM account WHERE account_no = '$accnum' AND meter_no = '$meternum';");
		$res3=mysqli_query($con,"SELECT * FROM account WHERE account_no = '$accnum' AND meter_no = '$meternum' AND user_id IS null;");
		
		if(mysqli_num_rows($res2) == 0)
		{
			$errorMatch=true; 
		}
		else if(mysqli_num_rows($res3) == 0)
		{
			$errorLinked=true; 
		}
		else if(mysqli_num_rows($res3) > 0)
		{
			$r= mysqli_fetch_array($res3);
			$sql = "UPDATE account SET user_id = $userID WHERE account_id=$r[0];";
			$res=mysqli_query($con, $sql);
			$successAdd = true;
		}
		discon($con);
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
                            <li class="active">
                                <i class="fa fa-dashboard"></i> <?php echo $headerTitle;?>
                            </li>
                        </ol>
                        <div class="alert alert-info">
							<strong>Note:</strong> Enter the following details below to successfuly view your statement of accounts.
						</div>
                    </div>
                </div>                
                
				<div class="row" style="padding-top:0px; padding-bottom:40px; padding-right:40px; padding-left:40px;">
					<center>
						<div class="alert alert-success" style="<?php if(!$successAdd) echo "display:none";?>">
							New account <strong>sucessfully added!</strong>
						</div>
						<div class="alert alert-danger" style="<?php if(!$errorMatch) echo "display:none";?>">
							Account number and Meter Serial Number <strong>did not Match or Invalid!</strong>
						</div>
						<div class="alert alert-danger" style="<?php if(!$errorLinked) echo "display:none";?>">
							Account number <strong>is already linked to a user!</strong>
						</div>
					</center>
				</div>

				<div>
					<form action="" method="post" class="form-horizontal" data-toggle="validator">
						<table>
							<tr>
								<td>
									<input type="hidden" class="form-control" name="accid" id="accid" required>
									<div class="form-group">
										<label class="control-label col-sm-5" for="accnum">Account Number:</label>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="accnum" id="accnum" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-5" for="meternum">Meter Serial Number:</label>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="meternum" id="meternum" required>
										</div>
									 </div>
									 <br>
									 <div class="form-group">
									 	<label type="hidden" class="control-label col-sm-5" for="accnum"></label>
										<div class="col-sm-7">
											<input type="submit" name="add" id="add" tabindex="" class="form-control btn btn-success" value="Verify">
										</div>
									 </div>
								</td>
							</tr>
						</table>
					</form>
				</div>

				<div class="col-sm-12" style="height: 30px;"></div>

				<table class="table table-striped table-responsive">
					<thead>
						<tr>
							<th style="display:none;">Account ID</th>
							<th>Account Number</th>
							<th>Account Name</th>
							<th>Meter Serial Number</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
						<?php
							$con=con();
							
							$sql= "SELECT * FROM account WHERE user_id = ".$_SESSION["id"]." AND status != 3 AND status != 2;";
							$res = mysqli_query($con,$sql);
							while ($row = mysqli_fetch_array($res)) 
							{
						?>
								<tr>
									<td style='display:none;'><?php echo $row['account_id']; ?></td>
									<td><?php echo $row['account_no']; ?></td>
									<td><?php echo $row['name']; ?></td>
									<td><?php echo $row['meter_no']; ?></td>
									<td>
						<?php
										if($row['status']==1)
											echo "Active";
										else
											echo "Disconnected";
						?>
									</td>
									<td>
										<a href='<?php echo "overview.php?account=$row[0]"; ?>' class='btn btn-info' role='button'>View</a>
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