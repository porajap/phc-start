<?php
session_start();
require 'connect.php';
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
$xName = $_SESSION["xName"];
$Area = $_SESSION["Area"];
	if( ($Area == "padmin") || ($Area == "psbkk") ){
		$xArea = $_POST["xArea"];
	}else{
		$xArea = $Area;
	}
$_SESSION["xArea"] = $xArea;
$mm = date('m');
$yy = date('Y');
$syy = date('Y')-2;

	$Sql = "SELECT Prefix_Code, Prefix_Name, Status FROM prefix WHERE Status = 1";
	$meQuery = mysqli_query($conn,$Sql);
	$c=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$GPC[$c] =  $Result["Prefix_Code"];
		$GPN[$c] =  $Result["Prefix_Name"];
		$c++;
	}
	$Sql = "SELECT area_sub.Pv_Code,th_province.Name_Th " .
			  "FROM area_sub " .
			  "INNER JOIN th_province ON area_sub.Pv_Code = th_province.Pv_Code " .
			  "WHERE area_sub.AreaCode = '$xArea'";
	$meQuery = mysqli_query($conn,$Sql);
	$d=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$PC[$d] =  $Result["Pv_Code"];
		$PN[$d] =  $Result["Name_Th"];
		$d++;
	}
	if($_SESSION["Area"] == "") header('location:index.html');
	
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
          <a href="p2.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
          <div class="xlabel"><?= $Area ?> : Cyclic purchasing ( Dispenser )</div>
          <div class="topnav-right">            
              <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
          </div>
    </div>

    <div class="xTop1">
  		<form action="chkDateDispenser.php" method="post">
		  	<div class="input-group mb-3">
				<span class="input-group-text xBoxWh">ปี</span>
				<select name="xYear" id="xYear" class="form-select" aria-label="Default select example">
									<?php 
											for($i= date('Y')-(date('Y')-2015);$i<=date('Y')+5;$i++){ 
												if($i == $syy){
									?>
                                    	<option value="<?php echo $i ?>" selected="selected"><?php echo $i ?></option>
                                    <?php }else{ ?>
                                    	<option value="<?php echo $i ?>"><?php echo $i ?></option>
									<?php 
												} 
											}
									?>
				</select>
			</div>

			<hr class="new4">
			TO
      		<hr class="new4">

			<div class="input-group mb-3">
				<span class="input-group-text xBoxWh">ปี</span>
				<select name="xYear2" id="xYear2" class="form-select" aria-label="Default select example">
									<?php 
											for($i=date('Y')-4;$i<=date('Y')+5;$i++){ 
												if($i == $yy){
									?>
                                    	<option value="<?php echo $i ?>" selected="selected"><?php echo $i ?></option>
                                    <?php }else{ ?>
                                    	<option value="<?php echo $i ?>"><?php echo $i ?></option>
									<?php 
												} 
											}
									?>
				</select>
			</div>


			<div class="d-grid xTb">
				<button class="btn btn-success" name="submit-button-1" id="submit-button-1" >ตกลง</button>
			</div>

		</form>
	</div>
</body>

</html>
