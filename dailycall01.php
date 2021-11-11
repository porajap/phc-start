<?php
session_start();
require 'connect.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
	if($_SESSION["Area"] == "") header('location:index.html');
	$Area = $_SESSION["Area"];
	if( ($Area == "padmin") || ($Area == "psbkk") ){
		//$xArea = $_SESSION["xArea"];
		// $_SESSION["PvCode"] = "%";
		// echo "<script>
		// window.location.href = 'dailycall02.php';
		// </script>
		// ";
	
		header('location:dailycall02.php');
	}else{
		$xArea = $Area;
	}
	$xName = $_SESSION["xName"];

	$Sql = "SELECT customer.AreaCode,th_province.Name_Th,area_sub.Pv_Code FROM customer ";
	$Sql .= "INNER JOIN area_sub ON customer.AreaCode = area_sub.AreaCode ";
	$Sql .= "INNER JOIN th_province ON area_sub.Pv_Code = th_province.Pv_Code ";
	$Sql .= "WHERE customer.AreaCode = '$xArea' GROUP BY th_province.Pv_Code ";

// echo $Sql;
	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$PCode[$i]	=  $Result["Pv_Code"];
		$Item[$i]	=  $Result["Name_Th"];
		//echo $Item[$i]."<br>";
		$i++;
	}
	

	if($_REQUEST["PvCode"] != ""){
		$PvCode = $_REQUEST["PvCode"];
		$_SESSION["PvCode"] = $PvCode;
		echo "<script>
		window.location.href = 'dailycall02.php';
		</script>
		";
		exit;
		// header('location:dailycall02.php');
	}

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
	<script src="js/jquery/3.5.1/jquery.min.js "></script>
	<script src="assets/dist/js/bootstrap.js "></script>
	<script src="assets/dist/js/bootstrap.bundle.min.js "></script>
    <script src="assets/dist/js/sweetalert2.min.js"></script>
</head>

<body>
	<div class="topnav">
        <a href="Date03.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $Area ?> : Daily call</div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="list-group">
                <a class="list-group-item list-group-item-action active" href="dailycall01.php?PvCode=0">ทั้งหมด</a>                             
<?php 	for($j=0;$j<$i;$j++){ ?>
				<a class="list-group-item list-group-item-action" href="dailycall01.php?PvCode=<?php echo $PCode[$j] ?>"><?php echo $Item[$j] ?></a>
<?php } ?>
			</div>
		</div>
	</div>
</body>

</html>
