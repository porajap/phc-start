<?php
session_start();
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
$CusCode = $_REQUEST["CusCode"];
$CusName = $_REQUEST["CusName"];

$_SESSION["Cus_Code"] = $CusCode;
$_SESSION["Cus_Name"] = $CusName;

$xName = $_SESSION["xName"];
$Area = $_SESSION["Area"];
$mm = date('m');
$yy = date('Y');
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
          <a href="Customer.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
          <div class="xlabel"><?= $Area ?> : <?= $CusName ?></div>
          <div class="topnav-right">            
              <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
          </div>
    </div>

    <div class="xTop1">
  <form action="Bill.php" method="post">
			<div class="input-group mb-3">
				<span class="input-group-text xBoxWh">ปี</span>
				<select name="xYear" id="xYear" class="form-select" aria-label="Default select example">
					<?php 
						for($i=2015;$i<=date('Y');$i++){ 
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
			<div class="input-group mb-3">
				<span class="input-group-text xBoxWh">เดือน</span>
				<select name="xMonth" id="xMonth" class="form-select" aria-label="Default select example">
					<?php 
						for($i=1;$i<=12;$i++){ 
							if(createDigit2($i) == $mm){
					?>
							<option value="<?php echo createDigit2($i) ?>"  selected="selected" ><?php echo createDigit2($i) ?></option>
					<?php }else{ ?>
							<option value="<?php echo createDigit2($i) ?>"><?php echo createDigit2($i) ?></option>
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
				<span class="input-group-text xBoxWh">เดือน</span>
				<select name="xMonth1" id="xMonth1" class="form-select" aria-label="Default select example">
					<?php 
						for($i=1;$i<=12;$i++){ 
							if(createDigit2($i) == $mm){
					?>
							<option value="<?php echo createDigit2($i) ?>"  selected="selected" ><?php echo createDigit2($i) ?></option>
					<?php }else{ ?>
							<option value="<?php echo createDigit2($i) ?>"><?php echo createDigit2($i) ?></option>
					<?php 
							}
						}
					?>
				</select>
      </div>
      
			<div class="input-group mb-3">
				<span class="input-group-text xBoxWh">ปี</span>
				<select name="xYear1" id="xYear1" class="form-select" aria-label="Default select example">
					<?php 
						for($i=2015;$i<=date('Y');$i++){ 
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
