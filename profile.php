<?php
	include ("config.php");
	include ("security.php");
	if($_SESSION['user_type']!=1 && $_SESSION['user_type']!=2 && $_SESSION['user_type']!=3 && $_SESSION['user_type']!=4)
	{
		header('Location: login.php?notPermitted=true');
	}
		$_SESSION["account"]=null;
?>
 
 
<?php
	$successEdit = false;
	$errorEmail = false;
	$errorPhone = false;
	$errorUsername = false;

	if(isset($_POST["edit"]))
	{
		$con=con();
		$userid= $_POST["userid"];
		$fname = $_POST["fname"];
		$lname = $_POST["lname"];
		$email = $_POST["email"];
		$phone = $_POST["phone"];
		$uname = trim(strtolower($_POST["uname"]));
		$pword = md5(trim($_POST["pword"]));
		$status = $_POST["status"];
		
		
		$res4=mysqli_query($con,"SELECT * FROM user WHERE email = '$email' AND user_id != $userid;");
		$res5=mysqli_query($con,"SELECT * FROM user WHERE phone = '$phone' AND user_id != $userid;");
		$res6=mysqli_query($con,"SELECT * FROM user WHERE uname = '$uname' AND user_id != $userid;");
		$res6=mysqli_query($con,"SELECT * FROM user WHERE uname = '$uname' AND user_id != $userid;");
		
		if(mysqli_num_rows($res4) > 0)
			$errorEmail=true; 
		
		if(mysqli_num_rows($res5) > 0)
			$errorPhone=true; 

		if(mysqli_num_rows($res6) > 0)
			$errorUsername=true; 

		if(mysqli_num_rows($res4) == 0 && mysqli_num_rows($res5) == 0 && mysqli_num_rows($res6) == 0)
		{
			
			$sql = "UPDATE user SET fname = '$fname', lname = '$lname', phone = '$phone', email = '$email', uname = '$uname' WHERE user_id=$userid;";
			if($pword != "d41d8cd98f00b204e9800998ecf8427e")
			{
				$sql = "UPDATE user SET fname = '$fname', lname = '$lname', phone = '$phone', email = '$email', uname = '$uname', pword = '$pword' WHERE user_id=$userid;";
			}
			
			$res=mysqli_query($con, $sql);
			$successEdit = true;
		}
			
		discon($con);
	}
?>
 
 
<?php
	  $headerTitle = "Profile";
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
                            <li class="active">
                                <i class="fa fa-file"></i> <?php echo $headerTitle;?>
                            </li>
                        </ol>
                    </div>
                </div>
                
                <div class="row" style="padding-top:0px; padding-bottom:40px; padding-right:40px; padding-left:40px;">
					<center>
						<div class="alert alert-success" style="<?php if(!$successEdit) echo "display:none";?>">
							Update <strong>sucessful!</strong>
						</div>
						<div class="alert alert-danger" style="<?php if(!$errorEmail) echo "display:none";?>">
							<strong>Update failed!</strong> New Email is already used by another user!
						</div>
						<div class="alert alert-danger" style="<?php if(!$errorPhone) echo "display:none";?>">
							<strong>Update failed!</strong> New Phone is already used by another user!
						</div>
						<div class="alert alert-danger" style="<?php if(!$errorUsername) echo "display:none";?>">
							<strong>Update failed!</strong> New Username is already used by another user!
						</div>
					</center>

					<?php
						$con=con();

						$sql= "SELECT * FROM user WHERE user_id = ".$_SESSION['id'].";";
						$res = mysqli_query($con,$sql);

						while ($row = mysqli_fetch_array($res)) 
						{
							$useridE= $_SESSION['id'];
							$fnameE = $row{1};
							$lnameE = $row{2};
							$emailE = $row{4};
							$phoneE =  $row{3};
							$unameE = trim(strtolower( $row{5}));
							$statusE = $row[7];
						}
						discon($con);
					?>

				  	<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="update" >
							<form action="" method="post" class="form-horizontal" data-toggle="validator">
								<fieldset id="editform" disabled style="display: none;">
									<table>
										<tr>
											<td>
												<div class="form-group">
													<input type="text" class="form-control" name="userid" id="userid" style="display: none" required value="<?php echo $useridE;?>">
												</div>
												<div class="form-group">
													<label class="control-label col-sm-5" for="fname">First Name:</label>
													<div class="col-sm-7">
														<input type="text" class="form-control" name="fname" id="fname" required value="<?php echo $fnameE;?>">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-5" for="lname">Last Name:</label>
													<div class="col-sm-7">
														<input type="text" class="form-control" name="lname" id="lname" required value="<?php echo $lnameE;?>">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-5" for="phone">Phone:</label>
													<div class="col-sm-7">
														<input type="text" class="form-control" name="phone" id="phone" required value="<?php echo $phoneE;?>">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-5" for="email">Email:</label>
													<div class="col-sm-7">
														<input type="email" class="form-control" name="email" id="email" required value="<?php echo $emailE;?>">
													</div>
												</div>
											</td>
											<td>
												<div class="form-group">
													<label class="control-label col-sm-5" for="uname">Username:</label>
													<div class="col-sm-7">
														<input type="text" class="form-control" name="uname" id="uname" required value="<?php echo $unameE;?>">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-5" for="pword"><input id="chk" type="checkbox"> New Password:</label>
													<div class="col-sm-7">
														<input style="display:none;" type="password" class="form-control" name="pword" id="pword" disabled data-minlength="6" data-error="Minimum of 6 characters">
														<div class="help-block with-errors"></div>
													</div>
												</div>
												<div class="form-group" id="confirm" style="display: none;">
													<label class="control-label col-sm-5" for="pwordConfirm">Confirm New Password:</label>
													<div class="col-sm-7">
														<input type="password" class="form-control" name="pwordConfirm" id="pwordConfirm" disabled placeholder="Confirm Password"  data-match="#pword" data-match-error="Password don't match">
														<div class="help-block with-errors"></div>
													</div>
												</div>
											</td>
											<td  class="col-sm-4">
												<div class="form-group">
													<div class="col-sm-7">
														<input type="submit" name="edit" id="edit" tabindex="" class="form-control btn btn-primary" value="Edit">
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-7">
														<a href="profile.php" class="form-control btn btn-warning">Cancel</a>
													</div>
												</div>
											</td>
										</tr>
									</table>
								</fieldset>
							</form>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1 toppad" >
					  		<div class="panel panel-default">
								<div class="panel-heading">
							  		<h3 class="panel-title"><?php echo "$fnameE $lnameE";?></h3>
								</div>
								<div class="panel-body">
							  		<div class="row">
										<div class="col-md-3 col-lg-3 " align="center">
											<img alt="User Pic" src="images/id.png" class="img-circle img-responsive">
										</div>

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
														<td>First Name</td>
														<td><?php echo $row[1]; ?></td>
													</tr>
													<tr>
														<td>Last Name</td>
														<td><?php echo $row[2]; ?></td>
													</tr>
													<tr>
														<td>Account Type</td>
														<td>
										<?php
													if($row[7]==1)
															echo "Administrator";
														else if($row[7]==2)
															echo "Staff";
														else if($row[7]==4)
															echo "Teller";
														else
															echo "Client";
										?>
														</td>
												  	</tr>
													<tr>
														<td>User Name</td>
														<td><?php echo $row[5]; ?></td>
													</tr>
													<tr>
														<td>Email</td>
														<td><a href='mailto:$row[4]'><?php echo $row[4]; ?></a></td>
													</tr>
													<tr>
														<td>Phone Number</td>
														<td><?php echo $row[3]; ?></td>
												  	</tr>
										<?php
											}
											discon($con);
										?>
												</tbody>
									  		</table>
								  			<button class="btn btn-primary" id="editB">Edit Profile</button>
										</div>
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
		<script>
			$('#chk').click(function() { 
				if ($(this).is(':checked')) {
					$("#pword").prop('required', true);
					$("#pwordConfirm").prop('required', true);
					$("#pword").prop('disabled', false);
					$("#pwordConfirm").prop('disabled', false);
					$("#pword").css("display","");
					$("#confirm").css("display","");
					alert("You are about to change the password!");
				} else {
					$("#pword").prop('disabled', true);
					$("#pwordConfirm").prop('disabled', true);
					$("#pword").prop('required', false);
					$("#pwordConfirm").prop('required', false);
					$("#pword").css("display","none");
					$("#confirm").css("display","none");
				}
			});
			$('#editB').click(function() {
				$("#editform").prop('disabled', false);
				$("#editform").css("display","");
				//alert("clicked");
				$(this).css("display","none");
			});
		</script>
	</body>
</html>


