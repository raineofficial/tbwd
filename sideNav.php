<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

<?php

    $color = "";
    if($_SESSION['user_type'] == 1)
    $color = "#032B16";
    elseif($_SESSION['user_type'] == 2)
    $color = "#11206A";
    elseif($_SESSION['user_type'] == 4)
    $color = "#611910";
    else
    $color = "";

    //staff 030C2B
    //admin 032B16 10612F
    //teller 611910 1D0202

    $con=con();
    $name = $_SESSION['fname'] . " " . $_SESSION['lname'];

    $res = mysqli_query($con,"SELECT * FROM bill as b INNER JOIN account as a ON b.account_id = a.account_id where DATE(amount_paid_date)=CURDATE() and amount_paid != 0 and teller = '$name'");
    $transactionHistory = mysqli_num_rows($res);
    discon($con);

    $con=con();
    $name = $_SESSION['fname'] . " " . $_SESSION['lname'];

    $res2 = mysqli_query($con,"SELECT * FROM account as a LEFT JOIN user as u ON u.user_id = a.user_id WHERE a.status = 3 OR a.status = 4;");
    $preregistration = mysqli_num_rows($res2);
    discon($con);

    
?>

            <div class="collapse navbar-collapse navbar-ex1-collapse" style="background: <?php echo $color; ?>">
                <ul class="nav navbar-nav side-nav" style="background: <?php echo $color; ?>">

                    <!-- access by all user types -->
                    <li class="<?php if($headerTitle == "Home") echo "active";?>" style="<?php if($_SESSION['user_type']!=1 && $_SESSION['user_type']!=2 && $_SESSION['user_type']!=3 && $_SESSION['user_type']!=4) echo "display:none;";?>">
                        <a href="index.php"><i class="fa fa-fw fa-home"></i> Home</a>
                    </li>

                    <!-- access by staff only -->
                    <li class="<?php if($headerTitle == "Accounts") echo "active";?>" style="<?php if($_SESSION['user_type']!=2) echo "display:none;";?>">
                        <a href="accounts.php"><i class="fa fa-fw fa-dashboard"></i> Client's Account</a>
                    </li>
                    <li class="<?php if($headerTitle == "Meter Readings") echo "active";?>" style="<?php if ($_SESSION['user_type']!=2) echo "display:none;";?>">
                        <a href="meterReadings.php"><i class="fa fa-fw fa-bar-chart-o"></i> Meter Readings</a>
                    </li>
                    <li class="<?php if($headerTitle == "Pre-registration") echo "active";?>" style="<?php if($_SESSION['user_type']!=2) echo "display:none;";?>">
                        <a href="connectionRequests.php"><i class="glyphicon glyphicon-pencil"></i>  &nbsp;Pre-registration <span class="badge"><?php echo $preregistration; ?></a>
                    </li>

                    <!-- access by clients only -->
                    <li class="<?php if($headerTitle == "My Accounts") echo "active";?>" style="<?php if($_SESSION['user_type']!=3) echo "display:none;";?>">
                        <a href="myAccounts.php"><i class="fa fa-fw fa-dashboard"></i> My Accounts</a>
                    </li>
                    <li class="<?php if($headerTitle == "Pre-register") echo "active";?>" style="<?php if($_SESSION['user_type']!=3) echo "display:none;";?>">
                        <a href="request.php"><i class="fa fa-fw fa-dashboard"></i> Pre-register</a>
                    </li>
                    
                    <!-- access by teller only -->
                    <li class="<?php if($headerTitle == "Payments") echo "active";?>" style="<?php if($_SESSION['user_type']!=4) echo "display:none;";?>">
                        <a href="payments.php"><i class="fa fa-fw fa-ruble"></i> Payments</a>
                    </li>
                    <li class="<?php if($headerTitle == "Transaction History") echo "active";?>" style="<?php if($_SESSION['user_type']!=4) echo "display:none;";?>">
                        <a href="transactionHistory.php"><i class="glyphicon glyphicon-list-alt"></i> Transaction History <span class="badge"><?PHP echo $transactionHistory;?></span></a>
                    </li>

                    <!-- access by admin only --> <!-- glyphicon glyphicon-info-sign -->
                    <li class="<?php if($headerTitle == "Clients Account" || $headerTitle == "Meter Readings" || $headerTitle == "Payment History") echo "active";?>" style="<?php if($_SESSION['user_type']!=1) echo "display:none;";?>">
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo" <?php if($headerTitle == "Clients Account" || $headerTitle == "Meter Readings" || $headerTitle == "Payment History") echo "class aria-expanded=\"true\"";?>><i class="fa fa-fw fa-arrows-v"></i> Reports <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="clientReports.php">Accounts</a>
                            </li>
                            <li>
                                <a href="readingReports.php">Meter Readings</a>
                            </li>
                            <li>
                                <a href="paymentReports.php">Payment</a>
                            </li>
                            <!-- <li>
                                <a href="disconnection.php">Disconnection</a>
                            </li> -->
                        </ul>
                    </li>
                    <li class="<?php if($headerTitle == "Users") echo "active";?>" style="<?php if($_SESSION['user_type']!=1) echo "display:none;";?>">
                        <a href="users.php"><i class="glyphicon glyphicon-tasks"></i> Manage Employee</a>
                    </li>

                    <!-- access by all user types -->
                    <li class="<?php if($headerTitle == "Profile") echo "active";?>" style="<?php if($_SESSION['user_type']!=1 && $_SESSION['user_type']!=2 && $_SESSION['user_type']!=3 && $_SESSION['user_type']!=4) echo "display:none;";?>">
                        <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>
                    <li>
                        <a href="login.php?logout=true"><i class="fa fa-fw fa-power-off" style="<?php if($_SESSION['user_type']!=1 && $_SESSION['user_type']!=2 && $_SESSION['user_type']!=3 && $_SESSION['user_type']!=4) echo "display:none;";?>"></i> Log Out</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse