<?php
session_start();
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
require 'connect.php';


	$xName = $_SESSION["xName"];
	$Area = $_SESSION["Area"];

	$mm = date('m');
	$yy = date('Y');
	
		if($_SESSION["Area"] == "") header('location:index.html');
	    $Area = $_SESSION["Area"];
		
		$cArea[1] = "BB1";
		$cArea[2] = "BB2";
		$cArea[3] = "BB3";
		$cArea[4] = "BB4";
		$cArea[5] = "BB5";
		$cArea[6] = "P01";
		$cArea[7] = "P011";
		$cArea[8] = "P02";
		$cArea[9] = "P021";
		$cArea[10] = "P022";
		$cArea[11] = "P03";
		$cArea[12] = "P031";
		$cArea[13] = "P032";
		$cArea[14] = "P04";
		$cArea[15] = "P05";
		$cArea[16] = "P051";
		$cArea[17] = "P052";
		$cArea[18] = "P06";
		$cArea[19] = "P061";
		$cArea[20] = "P07";
		$cArea[21] = "P08";
		$cArea[22] = "P09";
		$cArea[23] = "P091";
		$cArea[24] = "P092";
		$cArea[25] = "P10";
		$cArea[26] = "P11";
		$cArea[27] = "P12";
		$cArea[28] = "P13";
		
	if($Area == "padmin"){		
		$CntArea = 27;
    }else if($Area == "psbkk"){
		$CntArea = 5;
	}

	$xItem_Search = $_SESSION["Item_Search"];
	$xCus_Search = $_SESSION["Cus_Search"];
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
        <div class="xlabel"><?= $Area ?> : Daily call</div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
	</div>
	<div class="xTop1">
	<form action="chkDate03.php" method="post">

		<?php if(  ($Area != "psbkk") ){ ?>

			<div class="input-group mb-3">
				<span class="input-group-text xBoxWh">รหัสลูกค้า</span>
				<input type="text" name="Cus_Search" id="Cus_Search" placeholder="รหัสลูกค้า" value='<?= $xCus_Search ?>' class="form-control" aria-describedby="basic-addon1">
				<a class="xTop2" href='cus_search.php?Cus_Code='>
					<svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
						<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
					</svg>
				</a>
			</div>
			<div class="input-group mb-3">
				<span class="input-group-text xBoxWh">รหัสสินค้า</span>
				<input type="text" name="item_Search" id="item_Search" placeholder="รหัสสินค้า" value='<?= $xItem_Search ?>'  class="form-control" aria-describedby="basic-addon1">
				<a class="xTop2" href='item_search.php?Item_Code='>
					<svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
						<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
					</svg>
				</a>
			</div>
					
		<?php } ?>
		
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
			<div class="form-check">
				<input class="form-check-input" type="checkbox" value="1" id="xDispenser" name="xDispenser">
				<label class="form-check-label" for="xDispenser">Dispenser</label>
			</div>
			<div class="d-grid xTb">
				<button class="btn btn-success" name="submit-button-1" id="submit-button-1" >ตกลง</button>
			</div>

	</form>
	</div>
</body>

</html>
