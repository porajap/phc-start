<?php
session_start();
require 'connect.php';
	$xArea = $_SESSION["xArea"];
	$xCusCode = $_REQUEST["CusCode"];
	if(  strlen($xCusCode)>1){
		  $_SESSION["CusCode"] = $xCusCode ;
		  header('location:CyclicAll.php?sel=1');
	}else if(  strlen($xCusCode) == 1){
		  $xPv = $_SESSION["xPv"];
		  $xGP = $_SESSION["xGP"];
		  $sYear = $_SESSION["sYear"];
		  $eYear = $_SESSION["eYear"];
	}else{
		$xPv = $_POST["xPv"];
		$xGP = $_POST["xGP"];
		$sYear = $_POST["xYear"];
		$eYear = $_POST["xYear2"];			
		
		$_SESSION["xPv"] = $xPv ;
		$_SESSION["xGP"] = $xGP ;
		$_SESSION["sYear"] = $sYear ;
		$_SESSION["eYear"] = $eYear ;
	}
		 	$Cus_Search = "";
 			$Sql = "SELECT Cus_Code FROM customer WHERE AreaCode = '$xArea'";
			//echo "<textarea  rows='10' cols='50' >$Cus_Search </textarea>";
			
 			$meQuery = mysqli_query($conn,$Sql);
			$n=1;
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
 				$Cus_Search .= "dallycall.Cus_Code = '" . $Result["Cus_Code"] . "' OR ";
			}
			//echo "<textarea  rows='10' cols='50' >$Cus_Search </textarea>";
			$Cus_Search = substr($Cus_Search,0,strlen($Cus_Search)-3);
			
		
		
		$SqlX = "SELECT dallycall.Cus_Code,customer.FName,customer.LName " .
				"FROM dallycall " .
				"INNER JOIN item ON dallycall.ItemCode = item.Item_Code " .
				"INNER JOIN customer ON dallycall.Cus_Code = customer.Cus_Code " .
				"WHERE ( $Cus_Search ) " .
				"AND dallycall.IsCancel = 0 " .
				//"AND customer.tbCode LIKE '$xPv%' " . 
				"AND customer.IsActive = 1 " .
				"AND ( item.row_count = 1 
						OR item.row_count = 2 
						OR item.row_count = 3 
						OR item.row_count = 4 
						OR item.row_count = 5 
						OR item.row_count = 6 
						OR item.row_count = 7 
						OR item.row_count = 8 
						OR item.row_count = 9 
						OR item.row_count = 10 
					) " .
				"GROUP BY dallycall.Cus_Code " .
				"ORDER BY customer.FName ASC";
		// echo "<textarea  rows='10' cols='50' >$SqlX </textarea>";	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>PHC</title>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="icon/icon.ico">
    <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/dist/css/sweetalert2.min.css">
    <link rel="stylesheet" href="css/topnav.css">
    <link rel="stylesheet" href="css/hr.css">
    <link rel="stylesheet" href="css/all.css">
    <script src="js/jquery/3.5.1/jquery.min.js "></script>
    <script src="assets/dist/js/bootstrap.js "></script>
    <script src="assets/dist/js/bootstrap.bundle.min.js "></script>
    <script src="assets/dist/js/sweetalert2.min.js"></script>
</head>

<body>
	<div class="topnav">
          <a href="DateDispenser.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
          <div class="xlabel"><?= $xArea ?> : Cyclic purchasing ( Dispenser )</div>
          <div class="topnav-right">            
              <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
          </div>
    </div>

	<div class="row">
			<div class="col-12">
				<div class="list-group">
				<a class="list-group-item list-group-item-action active" href="#" >ข้อมูลลูกค้า</a>
		<?php
			$Cnt=0;
			$meQuery1 = mysqli_query($conn,$SqlX);
			while ($Result1 = mysqli_fetch_assoc($meQuery1))
			{	
		?>
				<a class="list-group-item list-group-item-action" href="chkDateDPS.php?CusCode=<?php echo $Result1["Cus_Code"]  ?>"><?php echo$sYear?> - <?php echo$eYear?> : <?php echo  $Result1["FName"]  ?></a>
		<?php
			}
		?>  
				</div>
			</div>
	</div>

</body>
</html>