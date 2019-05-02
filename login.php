<?php
	
	include ("config.php");
	$logout=false;
	$errorLogin=false;
	$notPermitted=false;
	$inactive=false;
	$errorEmail=false;
	$errorPhone=false;
	$successReg = false;

	//logout code
	  if (isset($_GET['logout'])) {
	   session_start();         
	   session_destroy();   
	   $_SESSION = array();
	   $logout=true;
	  }

	//not permitted code
	  if (isset($_GET['notPermitted'])) {
	   session_start();         
	   session_destroy();   
	   $_SESSION = array();
	   $notPermitted=true;
	  }

	//idle code
	  if (isset($_GET['inactive'])) {
	   session_start();         
	   session_destroy();   
	   $_SESSION = array();
	   $inactive=true;
	  }

	//login code
	if (isset($_POST['login'])) {
		$uname=trim($_POST['uname']);
		$pword=md5(trim($_POST['pword']));
		
		$con = con();//connect to DB
		$res=mysqli_query($con,"SELECT * FROM user WHERE uname = '$uname' AND pword = '$pword';");
		if(mysqli_num_rows($res) > 0){
			$user = mysqli_fetch_object($res);
			session_start();
			$_SESSION['id'] = $user->user_id;
			$_SESSION['fname'] = $user->fname;
			$_SESSION['lname'] = $user->lname;
			$_SESSION['user_type'] = $user->user_type;
			$_SESSION['LAST_ACTIVITY'] = time();
			header("Location: index.php");
			exit; 
		}
		else{
			$errorLogin=true;
		}
		discon($con);//disconnect to DB
	}
	
	//registration code
	if (isset($_POST['register'])) {
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$phone=$_POST['phone'];
		$email=$_POST['email'];
		$runame=trim($_POST['username']);
		$rpword=md5(trim($_POST['password']));
		
		$con = con();//connect to DB
		
		$res2=mysqli_query($con,"SELECT * FROM user WHERE email = '$email';");
		$res3=mysqli_query($con,"SELECT * FROM user WHERE phone = '$phone';");
		
		if(mysqli_num_rows($res2) > 0){
			$errorEmail=true; 
		}
		
		if(mysqli_num_rows($res3) > 0){
			$errorPhone=true; 
		}
		if(mysqli_num_rows($res2) == 0 && mysqli_num_rows($res3) == 0){
			$ins = mysqli_query($con,"INSERT INTO user VALUES (null, '$fname', '$lname', '$phone', '$email', '$runame', '$rpword', 3);");
			$successReg = true;
		}
		discon($con);
	}

?>


<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

   <title>Login - TWBD</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="images/logoTWBD.PNG" sizes="16x16">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
		h1{
			font-size: 45px;
			font-weight: bolder;
			color:red;
			-webkit-text-stroke: 2px white;
		}
	body {
		padding-top: 5px;
		margin-top: 5px;
		background-image: url("images/bg.jpg");
		background-size: cover;
	}
	.panel-login {
		border-color: #ccc;
		-webkit-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
		-moz-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
		box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	}
	.panel-login>.panel-heading {
		color: #00415d;
		background-color: #fff;
		border-color: #fff;
		text-align:center;
	}
	.panel-login>.panel-heading a{
		text-decoration: none;
		color: #666;
		font-weight: bold;
		font-size: 15px;
		-webkit-transition: all 0.1s linear;
		-moz-transition: all 0.1s linear;
		transition: all 0.1s linear;
	}
	.panel-login>.panel-heading a.active{
		color: #029f5b;
		font-size: 18px;
	}
	.panel-login>.panel-heading hr{
		margin-top: 10px;
		margin-bottom: 0px;
		clear: both;
		border: 0;
		height: 1px;
		background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
		background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
		background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
		background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	}
	.panel-login input[type="text"],.panel-login input[type="email"],.panel-login input[type="password"] {
		height: 45px;
		border: 1px solid #ddd;
		font-size: 16px;
		-webkit-transition: all 0.1s linear;
		-moz-transition: all 0.1s linear;
		transition: all 0.1s linear;
	}
	.panel-login input:hover,
	.panel-login input:focus {
		outline:none;
		-webkit-box-shadow: none;
		-moz-box-shadow: none;
		box-shadow: none;
		border-color: #ccc;
	}
	.btn-login {
		background-color: #59B2E0;
		outline: none;
		color: #fff;
		font-size: 14px;
		height: auto;
		font-weight: normal;
		padding: 14px 0;
		text-transform: uppercase;
		border-color: #59B2E6;
	}
	.btn-login:hover,
	.btn-login:focus {
		color: #fff;
		background-color: #53A3CD;
		border-color: #53A3CD;
	}
	.forgot-password {
		text-decoration: underline;
		color: #888;
	}
	.forgot-password:hover,
	.forgot-password:focus {
		text-decoration: underline;
		color: #666;
	}

	.btn-register {
		background-color: #1CB94E;
		outline: none;
		color: #fff;
		font-size: 14px;
		height: auto;
		font-weight: normal;
		padding: 14px 0;
		text-transform: uppercase;
		border-color: #1CB94A;
	}
	.btn-register:hover,
	.btn-register:focus {
		color: #fff;
		background-color: #1CA347;
		border-color: #1CA347;
	}
	</style>

</head>

<body>

		<div class="container">
			<div class="row">
				<div class="">
					<center>
						<img src="images/logoTWBD.PNG" style="width:200px;"/>
						<h1>Tubod-Baroy Water District</h1><br><br><br><br>
					</center>
				</div>
						
			</div>
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					
					
					<center>
						<div class="alert alert-danger" style="<?php if(!$errorLogin) echo "display:none";?>">
							Username or Password is <strong>incorrect!</strong>
						</div>
						<div class="alert alert-danger" style="<?php if(!$errorEmail) echo "display:none";?>">
							<strong>Registration failed!</strong> email is already used.
						</div>
						<div class="alert alert-danger" style="<?php if(!$errorPhone) echo "display:none";?>">
							<strong>Registration failed!</strong> phone is already used.
						</div>
						<div class="alert alert-success" style="<?php if(!$logout) echo "display:none";?>">
							You successfully <strong>logged out!</strong>
						</div>
						<div class="alert alert-success" style="<?php if(!$successReg) echo "display:none";?>">
							You successfully <strong>Registered!</strong> Please login.
						</div>
						<div class="alert alert-danger" style="<?php if(!$inactive) echo "display:none";?>">
							You have been logged out! You have been idle for over <strong>10 mins!</strong>
						</div>
						<div class="alert alert-danger" style="<?php if(!$notPermitted) echo "display:none";?>">
							You have been logged out! You are not permitted to access <strong>the previous page!</strong>
						</div>
					</center>
					
					<div class="panel panel-login">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-6">
									<a href="login.php" class="active" id="login-form-link">Login</a>
								</div>
								<div class="col-xs-6">
									<a href="login.php" id="register-form-link">Register</a>
								</div>
							</div>
							<hr>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<form data-toggle="validator" id="login-form" action="login.php" method="post" role="form" style="display: block;">
										<div class="form-group">
											<input type="text" name="uname" id="username" tabindex="1" class="form-control" placeholder="Username" title="Must not be empty!" value="" required>
										</div>
										<div class="form-group">
											<input type="password" name="pword" id="password" tabindex="2" class="form-control" placeholder="Password" required>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6 col-sm-offset-3">
													<input type="submit" name="login" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In" style="width: 100%;">
												</div>
											</div>
										</div>
									</form>
									<form data-toggle="validator" id="register-form" action="login.php" method="post" role="form" style="display: none;">
										<div class="form-group">
											<input type="text" name="fname" id="fname" tabindex="1" class="form-control" placeholder="First Name" value="" required>
											<div class="help-block with-errors"></div>
										</div>
										<div class="form-group">
											<input type="text" name="lname" id="lname" tabindex="2" class="form-control" placeholder="Last Name" value="" required>
											<div class="help-block with-errors"></div>
										</div>
										<div class="form-group">
											<input type="text" name="phone" id="phone" pattern="[0-9]{7,11}" tabindex="3" class="form-control" placeholder="Phone Number" data-error="Phone number is invalid! eg. 0917****** or 221*******"  required>
											<div class="help-block with-errors"></div>
										</div>
										<div class="form-group">
											<input type="email" name="email" id="email" tabindex="4" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" placeholder="Email Address"  data-error="Email address is invalid"  required>
											<div class="help-block with-errors"></div>
										</div>
										<div class="form-group">
											<input type="text" name="username" id="rusername" tabindex="5" class="form-control" placeholder="Username" value="" required> 
											<input type="checkbox" name="chk" id="chk" value="chk" required data-error="Choose a valid username." hidden="true">
											<div id="user-result"></div>
 
											<div class="help-block with-errors"></div>
										</div>
										<div class="form-group">
											<input type="password" name="password" id="rpassword" tabindex="6" class="form-control" placeholder="Password" data-minlength="6" data-error="Minimum of 6 characters"  required>
											<div class="help-block with-errors">Minimum of 6 characters</div>
										</div>
										<div class="form-group">
											<input type="password" name="confirmPassword" id="confirm-password" tabindex="7" class="form-control" placeholder="Confirm Password"  data-match="#rpassword" data-match-error="Password don't match" required>
											<div class="help-block with-errors"></div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6 col-sm-offset-3">
													<input type="submit" name="register" id="register-submit" tabindex="8" class="form-control btn btn-register" value="Register Now" style="width: 100%;">
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        
    <!-- /#wrapper -->

    <!-- jQuery -->
    
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	<script>
		$(function() {

			$('#login-form-link').click(function(e) {
				$("#login-form").delay(100).fadeIn(100);
				$("#register-form").fadeOut(100);
				$('#register-form-link').removeClass('active');
				$(this).addClass('active');
				e.preventDefault();
			});
			$('#register-form-link').click(function(e) {
				$("#register-form").delay(100).fadeIn(100);
				$("#login-form").fadeOut(100);
				$('#login-form-link').removeClass('active');
				$(this).addClass('active');
				e.preventDefault();
			});

		});
		
		
			$(document).ready(function() {
				var x_timer;    
				$("#rusername").keyup(function (e){
					clearTimeout(x_timer);
					var user_name = $(this).val();
					x_timer = setTimeout(function(){
						check_username_ajax(user_name);
					}, 1000);
				}); 

			function check_username_ajax(username){
				$("#user-result").html('');
				$.post('username-checker.php', {'username':username}, function(data) {
				  $("#user-result").html(data);
				  if(data=="<span style='color:red'>Username is not available!</span>"){
					  $("#chk")[0].checked = false;
				  }
				  else{
					  $("#chk")[0].checked = true;
				  }
				});
			}
			});
	</script>
	
	<script src="js/validator.js"></script>
</body>

</html>
