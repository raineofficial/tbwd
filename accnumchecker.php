<?php
if(isset($_POST["accnum"]))
{
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        die();
    }
    $mysqli = new mysqli('localhost' , 'root', '', 'twbd');
    if ($mysqli->connect_error){
        die('Could not connect to database!');
    }
    
    $accnum = filter_var($_POST["accnum"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH);
    
    $statement = $mysqli->prepare("SELECT account_no, account_id FROM account WHERE account_no=?");
    $statement->bind_param('s', $accnum);
    $statement->execute();
    $statement->bind_result($acc, $accid);
    if($statement->fetch()){
        die("<span style='color:green'>Account number is available!</span> <span id='returnaccid' style='display:none'>$accid</span>");
    }else{
        die("<span style='color:red'>Account number is not available!</span>");
    }
}
?>