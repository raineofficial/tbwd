<?php
    include ("config.php");
    include ("security.php");
    if($_SESSION['user_type']!=1 && $_SESSION['user_type']!=2 && $_SESSION['user_type']!=3 && $_SESSION['user_type']!=4)
    {
	   header('Location: login.php?notPermitted=true');
	}

    if ($_SESSION['user_type'] == 1)
        $admin = "inline";
    else
        $admin = "none"
?>

<?php
	  $headerTitle = "Home";
      include "header.php";

      // TO GET A RANDOM ACCOUNT
		// $randnum = rand(1111111111,9999999999);
  //     	echo $randnum;
		// $cond=True;
		// while($cond)
		// {
		// 	$query = "SELECT * FROM appointment WHERE sms_code = '$randnum'";
		// 	$result = $conn->query($query);
			
		// 	if(mysql_num_rows($result)>0)
		// 		$randnum = rand(1111111111,9999999999);
		// 	else
		// 		$cond=False;
		// }
		// $sql = "INSERT INTO account VALUES('$randnum')";
		
?>
      
<html>
  <head>
    <style>
      .container-fluid {
        background: #E4E8E6;
        border-radius: 5px;
        border: 1px solid #DCDFDE;
        padding: 30px;
      }
      .home {
        background: blue;
        padding: 5px;
        border-radius: 10px;
        font-weight: bolder;
        color:white;
        font-size: large;
      }
    </style>
  </head>
    <body>
       <div id="page-wrapper">
            <?php
              if ($_SESSION['user_type'] == 1)
              {
            ?>
                <div class="container-fluid">
                  <h1>Welcome, <?php echo $_SESSION['fname']; ?>!</h1>
                  <h3>What would you like to do today?</h3>
                </div>
                <br><br><br>
                <div class="container">
                  <!-- <div class="row">
                    <div class="col-sm-3"><h4>Client</h4></div>
                    <div class="col-sm-3"><h4>Meter Readings</h4></div>
                    <div class="col-sm-3"><h4>Payment Reports</h4></div>
                    <div class="col-sm-3"><h4>Employees</h4></div>
                  </div> -->
                  <!-- <div class="row">
                    <div class="col-sm-3"><span class="home">2</span></div>
                    <div class="col-sm-3"><span class="home">4</span></div>
                    <div class="col-sm-3"><span class="home">17</span></div>
                    <div class="col-sm-3"><span class="home">5</span></div>
                  </div> -->
                </div>
            <?php
              }
              elseif($_SESSION['user_type'] == 2)
              {
            ?>
                <div class="container-fluid">
                  <h1>Welcome, <?php echo $_SESSION['fname']; ?>!</h1>
                  <h3>What would you like to do today?</h3>
                </div>
                <br><br><br>
                <div class="container">
                  <!-- <div class="row">
                    <div class="col-sm-4"><h4>Clients Accounts</h4></div>
                    <div class="col-sm-4"><h4>Meter Readings</h4></div>
                    <div class="col-sm-4"><h4>Pre-registration Request</h4></div>
                  </div> -->
                  <!-- <div class="row">
                    <div class="col-sm-4"><span class="home">2</span></div>
                    <div class="col-sm-4"><span class="home">4</span></div>
                    <div class="col-sm-4"><span class="home">3</span></div>
                  </div> -->
                </div>
            <?php
              }
              elseif($_SESSION['user_type'] == 4)
              {
            ?>
                <div class="container-fluid">
                  <h1>Welcome, Teller <?php echo $_SESSION['fname']; ?>!</h1>
                  <h3>What would you like to do today?</h3>
                </div>
                <br><br><br>
                <!-- <div class="container">
                  <div class="row">
                    <div class="col-sm-6"><h4>Payments</h4></div>
                    <div class="col-sm-6"><h4>Transaction History</h4></div>
                  </div> -->
                 <!--  <div class="row">
                    <div class="col-sm-6"><span class="home">2</span></div>
                    <div class="col-sm-6"><span class="home">4</span></div>
                  </div> -->
                </div>
            <?php
              }
              else
              {
            ?>
                <div class="container-fluid">
                  <h1>Welcome, Client <?php echo $_SESSION['fname']; ?>!</h1>
                  <h3>What would you like to do today?</h3>
                </div>
                <br><br><br>
                <!-- <div class="container">
                  <div class="row">
                    <div class="col-sm-6"><h4>My Accounts</h4></div>
                    <div class="col-sm-6"><h4>Pre-register</h4></div>
                  </div> -->
                  <!-- <div class="row">
                    <div class="col-sm-6"><span class="home">2</span></div>
                    <div class="col-sm-6"><span class="home">4</span></div>
                  </div> -->
                </div>
            <?php
              }
            ?>
        </div>

        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.buttons.min.js"></script>
        <script src="js/dataTables.select.min.js"></script>
    </body>
</html>
