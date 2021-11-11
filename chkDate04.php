<?php
session_start();
require 'connect.php';

	$xCusCode = $_REQUEST["CusCode"];
	if(  strlen($xCusCode)>1){
		  $_SESSION["CusCode"] = $xCusCode ;
		  header('location:CyclicAll.php?sel=0');
	}else if(  strlen($xCusCode) == 1){
		  $xPv = $_SESSION["xPv"];
		  $xGP = $_SESSION["xGP"];
		  $sYear = $_SESSION["sYear"];
		  $eYear = $_SESSION["eYear"];
		  $xArea = $_SESSION["xArea"];
	}else{
		$xPv = $_POST["xPv"];
		$xGP = $_POST["xGP"];
		$sYear = $_POST["xYear"];
		$eYear = $_POST["xYear2"];			
		$xArea = $_SESSION["xArea"];
		
		$_SESSION["xPv"] = $xPv ;
		$_SESSION["xGP"] = $xGP ;
		$_SESSION["sYear"] = $sYear ;
		$_SESSION["eYear"] = $eYear ;
	}

		$SqlX = "SELECT customer.FName,customer.Cus_Code FROM customer " .
				"WHERE customer.AreaCode = '$xArea' " .
				"AND customer.Prefix_Code LIKE '$xGP%' " .
				"AND customer.tbCode LIKE '$xPv%' AND customer.IsActive = 1 " .
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
          <a href="Date04.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
          <div class="xlabel"><?= $xArea ?> : Cyclic purchasing ( ALL )</div>
          <div class="topnav-right">            
              <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
          </div>
    </div>


  
  <div class="row">
		<div class="col-12">
			<div class="list-group">
				<a class="list-group-item list-group-item-action active" href="#">[ ข้อมูลลูกค้า ]</a>
				<?php
					$Cnt=0;
					$meQuery1 = mysqli_query($conn,$SqlX);
					while ($Result1 = mysqli_fetch_assoc($meQuery1))
						{	
					?>
					<a class="list-group-item list-group-item-action" href="chkDate04.php?CusCode=<?php echo $Result1["Cus_Code"]  ?>"><?php echo$sYear?> - <?php echo$eYear?> : <?php echo  $Result1["FName"]  ?></a>
				<?php
						}
					?>    
			</div>
		</div>
  </div>
</body>
</html>