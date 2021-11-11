<?php
session_start();
require 'connect.php';
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
$xName = $_SESSION["xName"];
$Area = $_SESSION["Area"];
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
			  "WHERE area_sub.AreaCode = '$Area'";
	$meQuery = mysqli_query($conn,$Sql);
	$d=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$PC[$d] =  $Result["Pv_Code"];
		$PN[$d] =  $Result["Name_Th"];
		$d++;
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
                    <form action="chkDate04.php" method="post">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td>ปี</td>
                                <td>
                                <select name="xYear" id="xYear" data-native-menu="false">
                                    <option>เลือกปี ศ.ส.</option>
                                    <?php 
											for($i=date('Y')-4;$i<=date('Y')+5;$i++){ 
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
                                </td>
                              </tr>
                              <tr style="background-color: #00ff00;font-weight: bold; " height="35px">
                              	<td>
                                </td>
                                <td>
                                		<div  align="center">ถึง</div>
                                </td>
                              </tr>
                              <tr>
                                <td>ปี</td>
                                <td>
                                <select name="xYear2" id="xYear2" data-native-menu="false">
                                    <option>เลือกปี ศ.ส.</option>
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
                                </td>
                              </tr>     
                              
                               <tr>
                                <td>กลุ่ม</td>
                                <td>
                                <select name="xGP" id="xGP" data-native-menu="false">
                                    <option>เลือกปี กลุ่ม</option>
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
                                </td>
                              </tr> 
                                <tr>
                                <td>จังหวัด</td>
                                <td>
                                <select name="xPv" id="xPv" data-native-menu="false">
                                    <option>เลือกปี จังหวัด</option>
                                    <option value="" selected="selected">ทุกจังหวัด</option>
                                    <?php 
											for($j=0;$j<$d;$j++){ 
									?>
                                    	<option value="<?php echo $PC[$j] ?>"><?php echo $PN[$j] ?></option>
									<?php 
											}
									?>
                                </select>
                                </td>
                              </tr>                                                                                    
                              <tr>
                                <td></td>
                                    <td>
                                    <button style="background-color: red;color: #ffffff;font-weight: normal;" class="ui-shadow ui-btn ui-corner-all" name="submit-button-1" id="submit-button-1" >ตกลง</button>
                                    </td>
                              </tr>
                            </table>
                    </form>
                </td>
              </tr>
              
              
              
</table>


</body>

</html>
