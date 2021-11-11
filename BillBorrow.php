<?php

session_start();
require 'connect.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
	if($_SESSION["Area"] == "") header('location:index.html');

	if( ($_REQUEST["DocNo"] != "") ){
		$_SESSION["DocNo"] = $_REQUEST["DocNo"];
		header('location:Borrow_DocNo.php?add=1&sel=1');
	}
	$Area = $_SESSION["Area"];
	$sDate = $_SESSION["sDate"];
	$eDate = $_SESSION["eDate"];
	//echo $sDate . " : " . $eDate . "<br>";
	
	$chk1 = substr( ($sDate ),0,4);
	$chk2 = substr( ($eDate ),0,4);
	
	if($chk1>2000 && $chk2>2000){
		$sDate = $chk1.substr($sDate,4,8);
		$eDate = $chk2.substr($eDate,4,8);
		//echo $sDate . " : " . $eDate . "<br>";
	}
	//if($chk1)
	$mm = (int)date("m");
	if(($mm-1) == 0 ) 
		$mm = 1;
	else
		$mm = ($mm-1);
		
	$sDate1 = substr(date("Y-m-d"),0,4)."-" . sprintf("%'.02d", $mm) . "-01";
	//$sDate1 = substr(date("Y-m-d"),0,8)."01";
	$eDate1 = substr(date("Y-m-d"),0,8).substr(date("Y-m-t", strtotime($a_date)),8,11);
	
	$Sql = "SELECT DocDate,DocNo,DueDate,IsSave,IsFinish,IsCancel,IsSend,Cus_Code ";
	$Sql .= "FROM borrow ";
	//$Sql .= "WHERE borrow.DocDate BETWEEN '$sDate1' AND '$eDate1' ";
	$Sql .= "WHERE borrow.Area_Code = '$Area'  AND borrow.IsCancel = 0 ";
	$Sql .= "ORDER BY DocNo DESC";

	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$xDocNo[$i] =  $Result["DocNo"];
		$IsSave[$i] =  $Result["IsSave"];
		$IsClrBill[$i] =  $Result["IsFinish"];
		$IsSendBill[$i] =  $Result["IsSend"];
		$IsCancel[$i] =  $Result["IsCancel"];
		$DueDate = $Result["DueDate"];
		$Item[$i]	=  $Result["DocNo"] . " : " . $Result["DocDate"] . " : " . getCus($conn,$Result["Cus_Code"]);
		if($DueDate != "") {
			$newDate = date("d-m-Y", strtotime($DueDate));
			$SendDate[$i] .=  " [ วันที่ส่ง : " . $newDate . " ]";
		}
		$i++;
	}
	
	function getCus($conn,$Cus_ID){
		$xSql = "SELECT CONCAT(customer.FName,' ',customer.LName) AS CusName ";
		$xSql .= "FROM customer WHERE Cus_Code = '$Cus_ID'";
		$meQuery = mysqli_query($conn,$xSql);
		while ($Result = mysqli_fetch_assoc($meQuery))
		{
			$CusName =  $Result["CusName"];
		}
		return $CusName;
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Login</title>
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.min.css">
	<link rel="stylesheet" href="_assets/css/jqm-demos.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<script src="js/jquery.js"></script>
	<script src="js/jquery.mobile-1.4.5.min.js"></script>
    <style id="custom-icon">
        .ui-icon-custom:after {
			background-image: url("../_assets/img/glyphish-icons/21-skull.png");
			background-position: 3px 3px;
			background-size: 70%;
		}
    </style>
</head>

<body>
		<div data-demo-html="true">
			<div data-role="header">
            	<a href="Borrow.php" class="ui-btn ui-corner-all ui-btn-inline ui-mini footer-button-left ui-btn-icon-left ui-icon-carat-l">กลับ</a>
            	<h1> <?php echo $Area ?> : <?php echo $xName ?></h1>
				<a href="logoff.php" class="ui-btn-right ui-btn ui-btn-b ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-power">ออก</a>
			</div>
		</div>
	<table width="100%" border="0" cellspacing="5" cellpadding="5">
                <tr>
                    <td>
                        <div align="center"><img src="img/logo.png" width="220" height="45" /></div>
                    </td>
                </tr>
              <tr>
              <tr>
                    <td>
                        <div align="center"><?php echo $xCusFullName ?></div>
                    </td>
                </tr>
              <tr>
              
                <td>
 			<div data-demo-html="true">
				<ul data-role="listview" data-filter="true" data-filter-placeholder="Search fruits..." data-inset="true">
<?php 	for($j=0;$j<$i;$j++){ ?>
					<li>
                    <a href="Borrow_DocNo.php?add=1&DocNo=<?php echo $xDocNo[$j] ?>">
                            <?php      
								echo "<img src='img/logo_phc.png' width='24' height='24' />";    
								
								 if($IsSave[$j] == 1)  
									echo "<img src='img/Circle_Green.png' width='24' height='24' />";
								 else
									echo "<img src='img/Circle_Red.png' width='24' height='24' />";
								 
								 if($IsClrBill[$j] == 1)  
									echo "<img src='img/Circle_Green.png' width='24' height='24' />";
								 else
									echo "<img src='img/Circle_Red.png' width='24' height='24' />";

/*
								 if($IsSendBill[$j] == 1)  
									echo "<img src='img/yellow_circle.png' width='24' height='24' />";
								 elseif($IsSendBill[$j] == 2){
									echo "<img src='img/Circle_Blue.png' width='24' height='24' />";
								 }elseif($IsSendBill[$j] == 3){
									echo "<img src='img/Circle_Green.png' width='24' height='24' />";
									echo " :: $Se$SendDate[$j]";
								 }elseif($IsSendBill[$j] == 4){
									echo "<img src='img/Circle_Glay.png' width='24' height='24' />";
								 }else{
									echo "<img src='img/Circle_Red.png' width='24' height='24' />";
								 }	
								*/ 
                             ?> 
                        	<br /><?php echo $Item[$j] ?>
                    </a>
                    </li>        
<?php } ?>


				</ul>
			</div>
                </td>
              </tr>
</table>


</body>

</html>
