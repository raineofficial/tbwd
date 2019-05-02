<?php
	include ("config.php");
	include ("security.php");
	if($_SESSION['user_type']!=3)
	{
		header('Location: login.php?notPermitted=true');
	}

	if(isset($_GET['account']))
	{
		$_SESSION["account"]=$_GET['account'];
	}
?>
 
<?php
	  $headerTitle = "My Accounts";
      include "header.php";
?>
      
      
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
                                <i class="fa fa-home"></i>  <a href="myAccounts.php">My Accounts</a>
                            </li>
                            <li class="active">
                                <i class="glyphicon glyphicon-eye-open"></i> Overview
                            </li>
                        </ol>
                    </div>
                </div>
                
                <?php
					$con=con();

					$sql= "SELECT * FROM account WHERE account_id = ".$_SESSION['account'].";";
					$res = mysqli_query($con,$sql);
					while ($row = mysqli_fetch_array($res)) 
					{
						$accno=  $row['account_no'];
						$accname=$row{'name'};
						$meterno = $row{'meter_no'};
						$streetadd =  $row['street_add'];
						$purok =  $row['purok_sub'];
						$barangay = $row['barangay'];
						$town = $row['town'];
						$status = $row['status'];
					}
					discon($con);
				?>

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1 toppad" >
			  			<div class="panel panel-default">
							<div class="panel-heading">
							  <h3 class="panel-title"><?php echo "$accno - $accname";?></h3>
							</div>
							<div class="panel-body">
						  		<div class="row">
									<div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="images/acc.png" class="img-circle img-responsive"> </div>
									<div class=" col-md-9 col-lg-9 "> 
							  			<table class="table table-user-information">
											<tbody>
											  	<?php
													$con=con();
												
													$sql= "SELECT * FROM user WHERE user_id = ".$_SESSION['id'].";";
													$res = mysqli_query($con,$sql);
													while ($row = mysqli_fetch_array($res)) 
													{
												?>
														<tr>
															<td>Account Number</td>
															<td><?php echo $accno; ?></td>
														</tr>
														<tr>
															<td>Account Name</td>
															<td><?php echo $accname; ?></td>
														</tr>
														<tr>
															<td>Meter Serial Number</td>
															<td><?php echo $meterno; ?></td>
														</tr>
														<tr>
															<td>Address</td>
															<td><?php echo $streetadd ." ".  $purok ." ". $barangay ." Lanao del Norte"; ?></td>
														</tr>
														</tr>
															<td>Status</td>
															<td>
												<?php
																if($status==1)
																	echo "Active";
																else
																	echo "Disconnected";
												?>
															</td>
									  					</tr>
									  			<?php
													}
													discon($con);
												?>
											</tbody>
								  		</table>
					  					<a href="statementOfAccounts.php" class="btn btn-primary" id="editB">Statement of Accounts</a>
									</div>
					  			</div>
							</div>
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
