<?php
session_start();
require 'connect.php';

	if($_REQUEST["Id"] != ""){
		$CusCode = $_REQUEST["Id"];
		$_SESSION["Cus_Code3"] = $CusCode;
		if($Area=="P10"){
			$Sql = "SELECT customer.Cus_Code,customer.FName,customer.LName
			FROM customer
			INNER JOIN prefix ON prefix.Prefix_Code = customer.Prefix_Code
			WHERE customer.AreaCode = '$Area' 
			AND customer.IsActive = 1 
			AND prefix.Status = 1";
		}else{
			$Sql = "SELECT Cus_Code,FName,LName FROM customer WHERE AreaCode = '$Area' AND IsActive = 1";
		}
		$meQuery = mysqli_query($conn,$Sql);
		$i=0;
		while ($Result = mysqli_fetch_assoc($meQuery))
		{
			$_SESSION["CusFullName"]	= $Result["FName"] . "  " . $Result["LName"];
		}
	
		header('location:Bill02.php');
	}
	if($_SESSION["Area"] == "") header('location:index.html');

	$Area = $_SESSION["Area"];
	$xName = $_SESSION["xName"];

	if($Area=="P10"){
		$Sql = "SELECT customer.Cus_Code,customer.FName,customer.LName
		FROM customer
		INNER JOIN prefix ON prefix.Prefix_Code = customer.Prefix_Code
		WHERE customer.AreaCode = '$Area' 
		AND customer.IsActive = 1 
		AND prefix.Status = 1";
	}else{
		$Sql = "SELECT Cus_Code,FName,LName FROM customer WHERE AreaCode = '$Area' AND IsActive = 1";
	}

	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$CusCode[$i] = $Result["Cus_Code"];
		$Item[$i]	=  $CusCode[$i] . " : " .$Result["FName"] . "  " . $Result["LName"];
		$i++;
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Customer</title>
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.min.css">
	<link rel="stylesheet" href="_assets/css/jqm-demos.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<script src="js/jquery.js"></script>
	<script src="js/jquery.mobile-1.4.5.min.js"></script>
	<script language="javascript" >
		$('#uName').keydown(function (event) {
			alert(event.keyCode);
			var keypressed = event.keyCode || event.which;
			if (keypressed == 13) {
				alert("xxxx");
				//$("#pWord").focus();
			}
		});
		
		$('#submit-button-1').click(function() {
			$.mobile.changePage($('#page2'), 'pop'); 
		});

	</script>
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
            	<a href="p2.php" class="ui-btn ui-corner-all ui-btn-inline ui-mini footer-button-left ui-btn-icon-left ui-icon-carat-l">กลับ</a>
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
                <td>
 			<div data-demo-html="true">
				<ul data-role="listview" data-filter="true" data-filter-placeholder="Search fruits..." data-inset="true">
<?php 	for($j=0;$j<$i;$j++){ ?>
					<li><a href="Customer2.php?Id=<?php echo $CusCode[$j] ?>"><?php echo $Item[$j] ?></a></li>
<?php } ?>
				</ul>
			</div>
                </td>
              </tr>
</table>


</body>

</html>
