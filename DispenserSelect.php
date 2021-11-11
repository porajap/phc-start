<?php
session_start();
require 'connect.php';
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
    <link rel="stylesheet" href="css/all.css">
	<script src="js/jquery/3.5.1/jquery.min.js "></script>
	<script src="assets/dist/js/bootstrap.js "></script>
	<script src="assets/dist/js/bootstrap.bundle.min.js "></script>
    <script src="assets/dist/js/sweetalert2.min.js"></script>
</head>

<body>
	<div class="topnav">
        <a href="Dispenser.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $Area ?> : <?= $xTitle ?></div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
    </div>

<?php
	if($_REQUEST["Sel"] != ""){
		$_SESSION["Sel"] = $_REQUEST["Sel"];
		echo "<script>
			window.location.href = 'CustomerDispenser.php';
			</script>
			";
	}
?>
	<table width="100%" border="0" cellspacing="5" cellpadding="5">
                <tr>
                    <td>
                        <div align="center"><img src="img/logo.png" width="220" height="45" /></div>
                    </td>
                </tr>
              <tr>
                <td>
 			<div data-demo-html="true">
				<ul data-role="listview" data-filter="true" data-filter-placeholder="Search fruits..." data-inset="true">
					<li><a href="DispenserSelect.php?Sel=0">ผลิตภัณฑ์ทดลองใช้</a></li>
                   <!-- <li><a href="BringSelect.php?Sel=1">เอกสารอ้างอิงผลิตภัณฑ์</a></li> -->
				</ul>
			</div>
                </td>
              </tr>
    </table>


</body>

</html>
