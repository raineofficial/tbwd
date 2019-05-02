<?php
session_start();
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 600)) {
		header("Location: login.php?inactive=true");
	}
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
	
	if(!isset($_SESSION['id'])){
		header('Location: login.php?notPermitted=true');
		}
?>