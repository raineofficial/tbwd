<?php

  function con() 
  {
    $link = mysqli_connect('localhost','root','','tbwd') or die ('Unable to connect to Database..');
    return $link;
  }
  
  function discon($c) 
  {
    mysqli_close($c);
  }


	/*function(){
		
		{"data":[
		
		{"DT_RowId":"row_1","first_name":"Tiger","last_name":"Nixon","position":"System Architect","email":"t.nixon@datatables.net","office":"Edinburgh","extn":"5421","age":"61","salary":"320800","start_date":"2011-04-25"}
		,{"DT_RowId":"row_2","first_name":"Garrett","last_name":"Winters","position":"Accountant","email":"g.winters@datatables.net","office":"Tokyo","extn":"8422","age":"63","salary":"170750","start_date":"2011-07-25"}
		],"options":[],"files":[]}
	}*/
?>