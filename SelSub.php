<?php
session_start();
if($_SESSION["Area"] == "") header('location:index.html');
require 'connect.php';
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
	
	if($_POST["xGP1"] != ""){
		$xGP1 = $_POST["xGP1"];
		$sYear = $_POST["xYear"];
		$eYear = $_POST["xYear2"];
		
		$_SESSION["xGP1"] = $xGP1 ;
		$_SESSION["sYear"] = $sYear ;
		$_SESSION["eYear"] = $eYear ;
	}else{
		 $xGP1 = $_SESSION["xGP1"] ;
	}
	
	$Sql = "SELECT Category_Code, Category_Name, Status FROM item_category WHERE CategoryMain_Code = '$xGP1'";
	$meQuery = mysqli_query($conn,$Sql);
	$c=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$GPC[$c] =  $Result["Category_Code"];
		$GPN[$c] =  $Result["Category_Name"];
		$c++;
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
	<script src="js/jquery/3.5.1/jquery.min.js "></script>
	<script src="assets/dist/js/bootstrap.js "></script>
	<script src="assets/dist/js/bootstrap.bundle.min.js "></script>
	<script src="assets/dist/js/sweetalert2.min.js"></script>
    <style>
		.xBoxWh{
			width: 150px;
		}

        .xTop1{
            margin-top: 7px;
            margin-left: 3px;
            margin-right: 3px;
        }

        .xTop2{
            margin : 2px;
			padding: 5px;
        }

        .xTb{
            margin-top: 7px;
            margin-left: 1px;
            margin-right: 1px;
            margin-bottom: 7px;
        }

        .label1{
            margin-left: 10px;
            margin-top: 7px;
        }

        .label2{
            margin-left: 10px;
            margin-top: 7px;
            margin-bottom: 7px;
        }
    </style>
</head>

<body>
	<div class="topnav">
        <a href="Date06.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?php echo $Area ?></div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
    </div>
	<div class="xTop1">
        <form action="chkDate06.php" method="post">
			<div class="input-group mb-3">
				<span class="input-group-text xBoxWh">กลุ่ม</span>
				<select name="xGP" id="xGP" class="form-select" aria-label="Default select example">
									<?php 
											for($j=0;$j<$c;$j++){ 
												if($j == 0){
									?>
                                    	<option value="<?php echo $GPC[$j] ?>" selected="selected"><?php echo $GPN[$j] ?></option>
                                    <?php }else{ ?>
                                    	<option value="<?php echo $GPC[$j] ?>"><?php echo $GPN[$j] ?></option>
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
