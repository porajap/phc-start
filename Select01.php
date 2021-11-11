<?php
session_start();
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
require 'connect.php';

	$xName = $_SESSION["xName"];
	$xArea = $_SESSION["Area"];

	$IName = $_REQUEST["IName"];
	if($IName != ""){
		$_SESSION["IName"] = $IName;
	}
	
	$CName = $_REQUEST["CName"];
	if($CName != "1"){
		 $_SESSION["CName"] = $CName;
	}
	
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
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Login</title>
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.min.css">
	<link rel="stylesheet" href="_assets/css/jqm-demos.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<script src="js/jquery.js"></script>
	<script src="js/jquery.mobile-1.4.5.min.js"></script>
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

                    <form action="Date03.php" method="post">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                         
                               <tr>                                
                               <?php  
							    echo "<td width='9%'>เขต</td>";
                                echo "<td width='91%'>";
									   if( ($Area == "padmin") || ($Area == "psbkk") ){
											echo "<select name='xArea' id='xArea' data-native-menu='false'>";
												echo "<option>เลือกเขต</option>";
													for($i=1;$i<=$CntArea;$i++){ 
														echo "<option value='$cArea[$i]'>$cArea[$i]</option>";
													}
											echo "</select>";
									   }  
								echo "</td>";
                                echo "<td></td>";							
                               ?>
                              </tr> 

                              <tr>
                              <?php  							
								echo "<td width='9%'>Dispenser</td>";
                                echo "<td width='91%'>";
											echo "<select name='Dispenser' id='Dispenser' data-native-menu='false'>";
												echo "<option>เลือก...</option>";
												echo "<option value='1'>All Products</option>";
												echo "<option value='2'>Dispenser</option>";
											echo "</select>";
								echo "</td>";
                                echo "<td></td>";
								
                               ?>
                              </tr>
                                                                          
                              <tr>
                                	<td></td>
                                    <td>
                                    <button style="background-color: red;color: #ffffff;font-weight: normal;" class="ui-shadow ui-btn ui-corner-all" name="submit-button-1" id="submit-button-1" >ตกลง</button>
                                    </td>
                                    <td></td>
                              </tr>
                            </table>
                    </form>
                </td>
              </tr>
              
              
              
</table>


</body>

</html>
