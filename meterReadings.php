<?php
	include ("config.php");
	include ("security.php");
	if($_SESSION['user_type']!=1 && $_SESSION['user_type']!=2)
	{
		header('Location: login.php?notPermitted=true');
	}
?>

<?php
	$successEdit = false;
	$errorDate = false;
	$errorMeter = false;
	$successAdd = false;
	$errorEdit=false;
	$todayYear = date("Y");
	$todayMonth = date("m");

	if(isset($_POST["edit"]))
	{
		$con=con();
		$readingno = $_POST["readnoE"];
		$accnum = $_POST["accnumE"];
		$accid = $_POST["accidE"];
		$datetime = $_POST["datetimeE"];
		$meterlevel = $_POST["meterlevelE"];
		$empname = $_SESSION['fname'] . " " . $_SESSION['lname'];
		
		
		$res4=mysqli_query($con,"SELECT * FROM reading WHERE account_id = '$accid' ORDER BY date_time DESC;");
		$res5=mysqli_query($con,"SELECT * FROM bill WHERE account_id = '$accid' ORDER BY date_time DESC;");
		$row4 = mysqli_fetch_array($res4);
		$row4b = mysqli_fetch_array($res4);
		$row5 = mysqli_fetch_array($res5);

		if($row4[0]==$readingno)
		{
			if($meterlevel>$row4b[3])
			{
				$sqla = "UPDATE reading SET meter_level = $meterlevel, emp_name = '$empname' WHERE reading_no = $readingno;";
				$resa=mysqli_query($con, $sqla);
				
				if(mysqli_num_rows($res5) > 0)
				{
					$amountdueE=(($meterlevel-$row5[4])*13.5)+$row5[8];
					$sqlb = "UPDATE bill SET pres_reading = '$meterlevel', amount_due = '$amountdueE' WHERE bill_id = $row5[0];";
					$resb=mysqli_query($con, $sqlb);
				}
				
				$successEdit=true;			
			}
			else
				$errorMeter=true;
		}
		else
			$errorEdit=true;
			
		discon($con);
	}


	if(isset($_POST["add"]))
	{
		$con=con();
		$accnum = $_POST["accnum"];
		$accid = $_POST["accid"];
		$datetime = $_POST["datetime"];
		//echo $datetime;
		$meterlevel = $_POST["meterlevel"];
		$empname = $_POST["empname"];
		
		$res2=mysqli_query($con,"SELECT * FROM reading WHERE account_id = '$accid' ORDER BY date_time DESC;");
		$res3=mysqli_query($con,"SELECT * FROM bill WHERE account_id = '$accid' ORDER BY date_time DESC;");
		
		if(mysqli_num_rows($res2) > 0)
		{
			// $numberofBills=mysqli_num_rows($res2);
			$numberofBills = date("mY");
			$row2 = mysqli_fetch_array($res2);
			$arears = 0;

			if(mysqli_num_rows($res3) > 0)
			{
				$row3 = mysqli_fetch_array($res3);
				$arears =$row3[9]-$row3[10];
			}
			
			$amountdue=(($meterlevel-$row2[3])*13.5)+$arears;
			
			if($row2[2]>=$datetime)
				$errorDate = true;
			elseif($row2[3]>=$meterlevel)
				$errorMeter = true;
			else{
				$ins = mysqli_query($con,"INSERT INTO reading VALUES (null, '$accid', '$datetime', '$meterlevel', '$empname');");
				$ins2 = mysqli_query($con,"INSERT INTO bill VALUES (null, '$accid', '$numberofBills', '$datetime', '".$row2[3]."', '$meterlevel', '".$row2[2]."', '$datetime', '$arears', '$amountdue', 0, null, null);");
				//echo "INSERT INTO bill VALUES (null, '$accid', '$numberofBills', '$datetime', '".$row2[3]."', '$meterlevel', '".$row2[2]."', '$datetime', '$arears', '$amountdue', 0, null, null);";
				$successAdd = true;
			}
		}
		else
		{
			$ins = mysqli_query($con,"INSERT INTO reading VALUES (null, '$accid', '$datetime', '$meterlevel', '$empname');");
			$successAdd = true;
		}
		discon($con);
	}
?>

<?php
	  $headerTitle = "Meter Readings";
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
							New reading <strong>sucessfully added!</strong>
						</div>
						<div class="alert alert-danger" style="<?php if(!$errorDate) echo "display:none";?>">
							<strong>Date & Time</strong> must be after the last Date Time reading!
						</div>
						<div class="alert alert-danger" style="<?php if(!$errorEdit) echo "display:none";?>">
							<strong>Update failed!</strong> You can only edit the latest reading of a particular account.
						</div>
						<div class="alert alert-danger" style="<?php if(!$errorMeter) echo "display:none";?>">
							<strong>Meter Level</strong> must be more than the Last Meter Level reading!
						</div>
					</center>
					  
					<div style="<?php if($_SESSION['user_type']==1) echo "display:none;";?>">
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active"><a href="#create" aria-controls="create" role="tab" data-toggle="tab">Create</a></li>
							<!-- <li role="presentation"><a href="#update" aria-controls="update" role="tab" data-toggle="tab">Update</a></li> -->
						</ul>
					</div>

					  <div class="tab-content" style="<?php if($_SESSION['user_type']==1) echo "display:none;";?>">

						<div role="tabpanel" class="tab-pane active" id="create">
							<form action="" method="post" class="form-horizontal" data-toggle="validator">
								<table>
									<tr>
										<td>
											<input type="hidden" class="form-control" name="accid" id="accid" required>
											<div class="form-group">
												<label class="control-label col-sm-5" for="accnum">Account Number:</label>
												<div class="col-sm-7">
													<input type="text" class="form-control" name="accnum" id="accnum" required>
													<div id="accnum-result"></div>
													<div class="help-block with-errors"></div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-5"></div>
												<div class="col-sm-7">
													<input type="checkbox" name="chk" id="chk" value="chk" required data-error="Choose a valid Account number." hidden="true">
													<div class="help-block with-errors"></div>
												</div>
											</div>
											<div>
												<div class="col-sm-5"></div>
												<div class="col-sm-7"></div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5" for="datetime">Date:</label>
												<div class="col-sm-7">
													<input type="date" class="form-control" name="datetime" id="datetime" value="<?PHP echo date("Y-m-d");?>" readOnly>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5" for="meterlevel">Meter Reading (m³):</label>
												<div class="col-sm-7">
													<input type="text" class="form-control" name="meterlevel" id="meterlevel" required>
												</div>
											</div>
											<div class="form-group" style="display:none">
												<label class="control-label col-sm-5" for="empname">Employee Name:</label>
												<div class="col-sm-7">
													<input type="text" class="form-control" name="empname" id="empname" value="<?php echo $_SESSION['fname'] . " " . $_SESSION['lname']; ?>" readOnly>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5" type="hidden"></label>
												<div class="col-sm-7">
													<input type="submit" name="add" id="add" tabindex="" class="form-control btn btn-success" value="Add">
												</div>
											</div>
										</td>
									</tr>
								</table>
							</form>
						</div>

						<div role="tabpanel" class="tab-pane" id="update" >
							<form action="" method="post" class="form-horizontal" data-toggle="validator">
								<fieldset id="editform" disabled>
									<table>
										<tr>
											<td>
												<input type="hidden" class="form-control" name="readnoE" id="readnoE" required>
												<input type="hidden" class="form-control" name="accidE" id="accidE" required>
												<div class="form-group">
													<label class="control-label col-sm-5" for="accnumE">Account Number:</label>
													<div class="col-sm-7">
														<input type="text" class="form-control" name="accnumE" id="accnumE" readOnly>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-5" for="datetimeE">Date & Time:</label>
													<div class="col-sm-7">
														<div class='input-group date' id='datetimepicker2'>
															<input type='text' class="form-control"  name="datetimeE" id="datetimeE" required readOnly/>
															<span class="input-group-addon">
																<span class="glyphicon glyphicon-calendar"></span>
															</span>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-5" for="meterlevelE">Meter Level:</label>
													<div class="col-sm-7">
														<input type="text" class="form-control" name="meterlevelE" id="meterlevelE" required>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-5" for="empnameE">Employee Name:</label>
													<div class="col-sm-7">
														<input type="text" class="form-control" name="empnameE" id="empnameE" value="<?php echo $_SESSION['fname'] . " " . $_SESSION['lname']; ?>" readOnly>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-7"  style="margin-left:100px;">
														<input type="submit" name="edit" id="edit" tabindex="" class="form-control btn btn-primary" value="Edit">
													</div>
												</div>
											</td>
										</tr>
									</table>
								</fieldset>
							</form>
						</div>

					</div>
					<br>
					
					<!-- <table id="table" class="display" cellspacing="0" width="100%"> -->
					<table class="table table-responsive">
						<thead>
							<tr>
								<th style="display:none;">Reading ID</th>
								<th>Date</th>
								<th style="display:none;">Account ID</th>
								<th>Account Number</th>
								<th>Account Name</th>
								<th>Prev. Meter Reading (m³)</th>
								<th>Pres. Meter Reading (m³)</th>
								<th>Employee Name</th>
							</tr>
						</thead>

							<?php
								$con=con();
								$sql= "SELECT * FROM reading as r INNER JOIN account as a ON r.account_id = a.account_id LEFT JOIN bill as b ON r.meter_level = b.pres_reading WHERE r.account_id = b.account_id OR b.account_id IS NULL ORDER BY r.date_time DESC;";
								$res = mysqli_query($con,$sql);

								while ($row = mysqli_fetch_array($res)) 
								{
									$prev_reading_date =  date('F d, Y' , strtotime($row['prev_reading_date']));
									$pres_reading_date =  date('F d, Y' , strtotime($row['pres_reading_date']));
									$date =  date('F d, Y' , strtotime($row[2]));
							?>
									<tr>
										<td style='display:none;'><?php echo $row[0]; ?></td>
										<td><?php echo $date; ?></td>
										<td style='display:none;'><?php echo $row[5]; ?></td>
										<td><?php echo $row[6]; ?></td>
										<td><?php echo $row['name']; ?></td>
										<td><?php echo str_pad(number_format($row['prev_reading'], 0, '.', ''), 6, '0', STR_PAD_LEFT); ?></td>
										<td><?php echo  str_pad(number_format($row[3], 0, '.', ''), 6, '0', STR_PAD_LEFT); ?></td>
										<td><?php echo $row[4]; ?></td> 
									</tr>
							<?php
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
    <script src="js/moment/moment.js"></script>
    <script src="js/bootstrap-datetimepicker.js"></script>
    
    <script>
		
		
		
		$(function () {
                $('#datetimepicker1').datetimepicker({
					format:'YYYY-MM-DD HH:mm:00' 
				});
            });
		
		$(document).ready(function() {
			var table = $('#table').DataTable( {
				select: true,
				"order": [[ 2, "desc" ]]
			} );

			$('#table tbody').on('click', 'tr', function () {
				var data = table.row( this ).data();
				$("#editform").prop('disabled', false);
				//alert( 'You clicked on '+data[0]+'\'s row' );
				document.getElementById("readnoE").value=data[0];
				document.getElementById("datetimeE").value=data[1];
				document.getElementById("accidE").value=data[2];
				document.getElementById("accnumE").value=data[3];
				document.getElementById("meterlevelE").value=data[6];
				document.getElementById("empnameE").value=data[7];
			} );
		} );
		
		$(document).ready(function() {
				var x_timer;    
				$("#accnum").keyup(function (e){
					clearTimeout(x_timer);
					var accnum = $(this).val();
					x_timer = setTimeout(function(){
						check_accnum_ajax(accnum);
					}, 1000);
				}); 

			function check_accnum_ajax(accnum){
				$("#accnum-result").html('');
				$.post('accnumchecker.php', {'accnum':accnum}, function(data) {
				  $("#accnum-result").html(data);
					//alert(data);
				  if(data=="<span style='color:red'>Account number is not available!</span>"){
					  $("#chk")[0].checked = false;
				  }
				  else{
					  $("#chk")[0].checked = true;
					  //alert($("#returnaccid").html());
					  $("#accid").val($("#returnaccid").html());
				  }
				});
			}
			});
	</script>

</body>

</html>

