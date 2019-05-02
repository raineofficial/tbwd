<?php
	include ("config.php");
	include ("security.php");
	if($_SESSION['user_type']!=1 && $_SESSION['user_type']!=2)
	{
		header('Location: login.php?notPermitted=true');
	}

	$todayYear = date("Y");
	$todayMonth = date("m");
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
						<div class="alert alert-success" style="<?php if(!$successAdd) echo "display:none";?>">
							New account <strong>sucessfully added!</strong>
						</div>
						<div class="alert alert-danger" style="<?php if(!$errorName) echo "display:none";?>">
							Account name is already <strong>taken!</strong>
						</div>
						<div class="alert alert-danger" style="<?php if(!$errorAccnum) echo "display:none";?>">
							Account number <strong>is already taken!</strong>
						</div>
					</center>
					  
					<div>
				 		<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active"><a href="#pending_tab" aria-controls="pending" role="tab" data-toggle="tab">Pending</a></li>
							<li role="presentation"><a href="#approved_tab" aria-controls="approved" role="tab" data-toggle="tab">Approved</a></li>
							<li role="presentation"><a href="#disapproved_tab" aria-controls="disapproved" role="tab" data-toggle="tab">Disapproved</a></li>
						</ul>
					</div>


				 	<div class="tab-content">

						<div role="tabpanel" class="tab-pane active" id="pending_tab" >
							<br>
							<h4>Pending Clients Request</h4><br>
							<table class="table table-responsive">
								<thead>
									<tr>
										<th>Account Name</th>
										<th>Address</th>
										<!-- <th>Status</th> -->
										<th>Phone</th>
										<th>Email</th>
										<th>Action</th>
									</tr>
								</thead>
								<?php
									$con=con();
									
									$sql= "SELECT * FROM account as a LEFT JOIN user as u ON u.user_id = a.user_id WHERE a.status = 3;";
									$res = mysqli_query($con,$sql);

									while ($row = mysqli_fetch_array($res)) 
									{
										// echo "<tr class='clickable-row' data-href='edit.php?id=". $row['account_id'] ."'>";
								?>
										<tr>
											<td><?php echo $row['name']; ?></td>
											<td><?php echo $row['street_add'] ." ". $row['purok_sub'] ." ". $row['barangay'] ." ". $row['town'] ." Lanao del Norte"; ?></td>
											<!-- <td><?php echo "Pending"; ?></td> -->
											<td><?php echo $row[15]; ?></td>
											<td><?php echo $row[16]; ?></td>
											<td><a href='<?php echo "edit.php?id=". $row['account_id']; ?>' class='btn btn-info' role='button'>View</a></td>
										</tr>
								<?php 
									}
									discon($con);
								?>
							</table>
						</div>


						<div role="tabpanel" class="tab-pane" id="approved_tab" >
							<br>
							<h4>Recently Approved Clients</h4><br>
							<table class="table table-striped table-responsive">
								<thead>
									<tr>
										<th>Account Number</th>
										<th>Account Name</th>
										<th>Address</th>
										<th>Phone</th>
										<th>Email</th>
									</tr>
								</thead>
								<?php
									$con=con();
									
									$sql= "SELECT * FROM account as a LEFT JOIN user as u ON u.user_id = a.user_id WHERE a.status = 1 and month(date_requested) = $todayMonth and year(date_requested) = $todayYear;";
									$res = mysqli_query($con,$sql);

									while ($row = mysqli_fetch_array($res)) 
									{
										// echo "<tr class='clickable-row' data-href='edit.php?id=". $row['account_id'] ."'>";
								?>
										<tr>
											<td><?php echo $row['account_no']; ?></td>
											<td><?php echo $row['name']; ?></td>
											<td><?php echo $row['street_add'] ." ". $row['purok_sub'] ." ". $row['barangay'] ." ". $row['town'] ." Lanao del Norte"; ?></td>
											<td><?php echo $row[15]; ?></td>
											<td><?php echo $row[16]; ?></td>
										</tr>
								<?php 
									}
									discon($con);
								?>
							</table>
						</div>

						<div role="tabpanel" class="tab-pane" id="disapproved_tab" >
							<br>
							<h4>Recently Disapproved Clients</h4><br>
							<table class="table table-striped table-responsive">
								<thead>
									<tr>
										<th>Account Name</th>
										<th>Address</th>
										<th>Phone</th>
										<th>Email</th>
									</tr>
								</thead>
								<?php
									$con=con();
									
									$sql= "SELECT * FROM account as a LEFT JOIN user as u ON u.user_id = a.user_id WHERE a.status = 2 and month(date_requested) = $todayMonth and year(date_requested) = $todayYear;";
									$res = mysqli_query($con,$sql);

									while ($row = mysqli_fetch_array($res)) 
									{
										// echo "<tr class='clickable-row' data-href='edit.php?id=". $row['account_id'] ."'>";
								?>
										<tr>
											<td><?php echo $row['name']; ?></td>
											<td><?php echo $row['street_add'] ." ". $row['purok_sub'] ." ". $row['barangay'] ." ". $row['town'] ." Lanao del Norte"; ?></td>
											<td><?php echo $row[15]; ?></td>
											<td><?php echo $row[16]; ?></td>
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
    <script>
    	jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });
	</script>

	</body>
</html>

