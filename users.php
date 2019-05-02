<?php
include ("config.php");
include ("security.php");
if($_SESSION['user_type']!=1){
		header('Location: login.php?notPermitted=true');
		}
?>

<?php
	$successEdit = false;
	$successAdd = false;
	$errorEmail = false;
	$errorPhone = false;
	$errorUsername = false;

	if(isset($_POST["edit"])){
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
		
		if(mysqli_num_rows($res4) > 0){
			$errorEmail=true; 
		}
		
		if(mysqli_num_rows($res5) > 0){
			$errorPhone=true; 
		}
		if(mysqli_num_rows($res6) > 0){
			$errorUsername=true; 
		}
		if(mysqli_num_rows($res4) == 0 && mysqli_num_rows($res5) == 0 && mysqli_num_rows($res6) == 0){
			
			$sql = "UPDATE user SET fname = '$fname', lname = '$lname', phone = '$phone', email = '$email', uname = '$uname', user_type = $status WHERE user_id=$userid;";
			
			if($pword != "d41d8cd98f00b204e9800998ecf8427e"){
				$sql = "UPDATE user SET fname = '$fname', lname = '$lname', phone = '$phone', email = '$email', uname = '$uname', pword = '$pword', user_type = $status WHERE user_id=$userid;";
			}
			
			$res=mysqli_query($con, $sql);
			$successEdit = true;
		}
			
		discon($con);
	}

if(isset($_POST["add"])){
		$con=con();
		$userid= $_POST["userid"];
		$fname = $_POST["fnameA"];
		$lname = $_POST["lnameA"];
		$email = $_POST["emailA"];
		$phone = $_POST["phoneA"];
		$uname = trim(strtolower($_POST["unameA"]));
		$pword = md5(trim($_POST["pwordA"]));
		$status = $_POST["statusA"];
		
		
		$res4=mysqli_query($con,"SELECT * FROM user WHERE email = '$email';");
		$res5=mysqli_query($con,"SELECT * FROM user WHERE phone = '$phone';");
		$res6=mysqli_query($con,"SELECT * FROM user WHERE uname = '$uname';");
		$res6=mysqli_query($con,"SELECT * FROM user WHERE uname = '$uname';");
		
		if(mysqli_num_rows($res4) > 0){
			$errorEmail=true; 
		}
		
		if(mysqli_num_rows($res5) > 0){
			$errorPhone=true; 
		}
		if(mysqli_num_rows($res6) > 0){
			$errorUsername=true; 
		}
		if(mysqli_num_rows($res4) == 0 && mysqli_num_rows($res5) == 0 && mysqli_num_rows($res6) == 0){
			
			$sql = "INSERT INTO user VALUES (null, '$fname', '$lname', '$phone', '$email', '$uname', '$pword', $status);";
			$res=mysqli_query($con, $sql);
			$successAdd = true;
		}
			
		discon($con);
	}
?>

<?php
	  $headerTitle = "Users";
      include "header.php";
?>
      
      
       <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                           Manage Employee
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>  <a href="index.php">Home</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Manage Employee
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
                
                
                
                
                
                
                
                
                
				<div class="row" style="padding-top:0px; padding-bottom:40px; padding-right:40px; padding-left:40px;">
					<center>
						<div class="alert alert-success" style="<?php if(!$successEdit) echo "display:none";?>">
							Update <strong>sucessful!</strong>
						</div>
						<div class="alert alert-success" style="<?php if(!$successAdd) echo "display:none";?>">
							Create <strong>sucessful!</strong>
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
					  
					<div>

					  <!-- Nav tabs -->
					  <ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#update" aria-controls="update" role="tab" data-toggle="tab">Update</a></li>
						<li role="presentation" class=""><a href="#create" aria-controls="create" role="tab" data-toggle="tab">Create</a></li>
					</div>
					  <!-- Tab panes -->
					  <div class="tab-content">
						
						<!-- Update panes -->
						<div role="tabpanel" class="tab-pane active" id="update" >
							<form action="" method="post" class="form-horizontal" data-toggle="validator">
							<fieldset id="editform" disabled>
							<table>
								<tr>
									<td>
										<div class="form-group">
											<input type="text" class="form-control" name="userid" id="userid" style="display: none" required>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-5" for="fname">First Name:</label>
											<div class="col-sm-7">
												<input type="text" class="form-control" name="fname" id="fname" required>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-5" for="lname">Last Name:</label>
											<div class="col-sm-7">
												<input type="text" class="form-control" name="lname" id="lname" required>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-5" for="phone">Phone:</label>
											<div class="col-sm-7">
												<input type="text" class="form-control" name="phone" id="phone" required>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-5" for="email">Email:</label>
											<div class="col-sm-7">
												<input type="email" class="form-control" name="email" id="email" required>
											</div>
										 </div>
									</td>
									<td>
										
										<div class="form-group">
											<label class="control-label col-sm-5" for="uname">Username:</label>
											<div class="col-sm-7">
												<input type="text" class="form-control" name="uname" id="uname" required>
											</div>
										 </div>
										<div class="form-group">
											<label class="control-label col-sm-5" for="status">Status:</label>
											<div class="col-sm-7">
												<select name="status" id="status"  class="form-control">
												  <option value="1">Admin</option>
												  <option value="2">Staff</option>
												  <option value="4">Teller</option>
												  <option value="3">Client</option>
												</select>
											</div>
										 </div>
										<!-- <div class="form-group">
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
										 </div> -->
									</td>
									<td  class="col-sm-4">
										<div class="form-group">
											<div class="col-sm-7">
												<input type="submit" name="edit" id="edit" tabindex="" class="form-control btn btn-primary" value="Edit">
											</div>
										 </div>
									</td>
								</tr>
							</table>
								</fieldset>
							</form>
						
						</div>
						
						<!-- Create panes -->
						<div role="tabpanel" class="tab-pane" id="create" >
							<form action="" method="post" class="form-horizontal" data-toggle="validator">
							<fieldset id="">
							<table>
								<tr>
									<td>
										<div class="form-group">
										</div>
										<div class="form-group">
											<label class="control-label col-sm-5" for="fnameA">First Name:</label>
											<div class="col-sm-7">
												<input type="text" class="form-control" name="fnameA" id="fnameA" required>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-5" for="lnameA">Last Name:</label>
											<div class="col-sm-7">
												<input type="text" class="form-control" name="lnameA" id="lnameA" required>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-5" for="phoneA">Phone:</label>
											<div class="col-sm-7">
												<input type="text" class="form-control" name="phoneA" id="phoneA" required>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-5" for="emailA">Email:</label>
											<div class="col-sm-7">
												<input type="email" class="form-control" name="emailA" id="emailA" required>
											</div>
										 </div>
									</td>
									<td>
										
										<div class="form-group">
											<label class="control-label col-sm-5" for="unameA">Username:</label>
											<div class="col-sm-7">
												<input type="text" class="form-control" name="unameA" id="unameA" required>
											</div>
										 </div>
										<div class="form-group">
											<label class="control-label col-sm-5" for="statusA">Status:</label>
											<div class="col-sm-7">
												<select name="statusA" id="statusA"  class="form-control">
												  <!-- <option value="1">Admin</option> -->
												  <option value="2">Staff</option>
												  <option value="4">Teller</option>
												  <!-- <option value="3">User</option> -->
												</select>
											</div>
										 </div>
										<div class="form-group">
											 <label class="control-label col-sm-5" for="pwordA"> Password:</label>
											<div class="col-sm-7">
												<input type="password" class="form-control" name="pwordA" id="pwordA" data-minlength="6" data-error="Minimum of 6 characters">
											<div class="help-block with-errors"></div>
											</div>
										 </div>
										<div class="form-group" id="confirm">
											<label class="control-label col-sm-5" for="pwordConfirmA">Confirm New Password:</label>
											<div class="col-sm-7">
												<input type="password" class="form-control" name="pwordConfirmA" id="pwordConfirmA" placeholder="Confirm Password"  data-match="#pwordA" data-match-error="Password don't match">
											<div class="help-block with-errors"></div>
											</div>
										 </div>
									</td>
									<td  class="col-sm-4">
										<div class="form-group">
											<div class="col-sm-7">
												<input type="submit" name="add" id="add" tabindex="" class="form-control btn btn-success" value="Add">
											</div>
										 </div>
									</td>
								</tr>
							</table>
								</fieldset>
							</form>
						
						</div>
						
						
					</div>
					
							
				
				
				
					<br><br>
					<table id="table" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th style="display:none;">User ID</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Phone </th>
								<th>Email</th>
								<th>Username</th>
								<th>Status</th>
							</tr>
						</thead>
							<?php
								$con=con();
								
								$sql= "SELECT * FROM user WHERE user_type != 1 and user_type != 3;";
								$res = mysqli_query($con,$sql);
								//var_dump($res);
								//$row = mysqli_fetch_array($res);
								while ($row = mysqli_fetch_array($res)) {
									echo "<tr>
									<td style='display:none;'>$row[0]</td>
									<td>$row[1]</td>
									<td>$row[2]</td>
									<td>$row[3]</td>
									<td>$row[4]</td>
									<td>$row[5]</td>
									<td>";
									if($row[7]==1){
										echo "Administrator";
									}
									else if($row[7]==2){
										echo "Staff";
									}
									else if($row[7]==3){
										echo "Client";
									}
									else if($row[7]==4){
										echo "Teller";
									}
										
									echo"</td>
									</tr>";
								}
						
						
								discon($con);
							?>
					</table>
					
            	</div>
            
            
            
            
				
            
            
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
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
							//alert("");
						} else {
							$("#pword").prop('disabled', true);
							$("#pwordConfirm").prop('disabled', true);
							$("#pword").prop('required', false);
							$("#pwordConfirm").prop('required', false);
							$("#pword").css("display","none");
							$("#confirm").css("display","none");
						}
					});
					
					
					$(document).ready(function() {
						var table = $('#table').DataTable( {
							select: true,
						} );
						
						
						
						$('#table tbody').on('click', 'tr', function () {
							var data = table.row( this ).data();
							$("#editform").prop('disabled', false);
							//alert( 'You clicked on '+data[0]+'\'s row' );
							document.getElementById("userid").value=data[0];
							document.getElementById("fname").value=data[1];
							document.getElementById("lname").value=data[2];
							document.getElementById("phone").value=data[3];
							document.getElementById("email").value=data[4];
							document.getElementById("uname").value=data[5];
							if(data[6]=="Administrator"){
								document.getElementById("status").selectedIndex = "0";
							}
							else if(data[6]=="Staff"){
								document.getElementById("status").selectedIndex = "1";
							}
							else if(data[6]=="Teller"){
								document.getElementById("status").selectedIndex = "2";
							}
							else{
								document.getElementById("status").selectedIndex = "3";
							}
						} );
					} );
	</script>

</body>

</html>

