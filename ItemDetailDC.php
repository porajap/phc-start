<?php

session_start();
require 'connect.php';
	if($_SESSION["Area"] == "") header('location:index.html');
	$Area = $_SESSION["Area"];
	$AF = $_SESSION["AF"];
	$dt = date("d/m/Y");
	$CName = $_SESSION["CName"];
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
            	<a href="Date03.php" class="ui-btn ui-btn-b ui-corner-all ui-btn-inline ui-mini footer-button-left ui-btn-icon-left ui-icon-carat-l">กลับ</a>
            	<h1> <?php echo $Area ?> : คุณ<?php echo $xName ?></h1>
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
                        <li data-role="list-divider">รายการสินค้า</li>
                        <?
                        $strSQL2 = "SELECT Item_Code,NameTH FROM item WHERE Grp_1 = 1 AND item.IsSale = 1";
                        $objQuery2 = mysqli_query($conn,$strSQL2);
                        while($objResult2 = mysqli_fetch_assoc($objQuery2))
                        {
                        ?>
                          	<li>
                          		<a href="Date03.php?ICode=<?php echo$objResult2["Item_Code"];?>&IName=<?php echo$objResult2["NameTH"];?>&CName=<?php echo $CName ?>"><h3><?php echo$objResult2["Item_Code"] ?> : <?php echo$objResult2["NameTH"];?></h3></a>  
                            </li>
                        <?
                        }
                        ?>
                        
                    </ul>
                </div>    
                </td>
              </tr>
</table>


</body>

</html>
