<?php
session_start();
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
	$xName = $_SESSION["xName"];
	$mm = date('m');
	$yy = date('Y');

	$MM = $_REQUEST["MM"];
	if( $MM!=""){
		$YY = $_REQUEST["YY"];
		header('location:chkDate03_1.php?xMonth='.$MM.'&xYear='.$YY);
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
            	<a href="dailycall01.php" class="ui-btn ui-corner-all ui-btn-inline ui-mini footer-button-left ui-btn-icon-left ui-icon-carat-l">กลับ</a>
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

                    <form action="chkDate03.php" method="post">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td>
                                </td>
                                <td>
                                    <a href="Date03.php?MM=01&YY=<?php echo $yy ?>" data-role="button" data-inline="true" data-theme="b">01</a>
                                    <a href="Date03.php?MM=02&YY=<?php echo $yy ?>" data-role="button" data-inline="true" data-theme="b">02</a>
                                    <a href="Date03.php?MM=03&YY=<?php echo $yy ?>" data-role="button" data-inline="true" data-theme="b">03</a>
                                    <a href="Date03.php?MM=04&YY=<?php echo $yy ?>" data-role="button" data-inline="true" data-theme="b">04</a>
                                    <a href="Date03.php?MM=05&YY=<?php echo $yy ?>" data-role="button" data-inline="true" data-theme="b">05</a>
                                    <a href="Date03.php?MM=06&YY=<?php echo $yy ?>" data-role="button" data-inline="true" data-theme="b">06</a>
                                    <a href="Date03.php?MM=07&YY=<?php echo $yy ?>" data-role="button" data-inline="true" data-theme="b">07</a>
                                    <a href="Date03.php?MM=08&YY=<?php echo $yy ?>" data-role="button" data-inline="true" data-theme="b">08</a>
                                    <a href="Date03.php?MM=09&YY=<?php echo $yy ?>" data-role="button" data-inline="true" data-theme="b">09</a>
                                    <a href="Date03.php?MM=10&YY=<?php echo $yy ?>" data-role="button" data-inline="true" data-theme="b">10</a>
                                    <a href="Date03.php?MM=11&YY=<?php echo $yy ?>" data-role="button" data-inline="true" data-theme="b">11</a>
                                    <a href="Date03.php?MM=12&YY=<?php echo $yy ?>" data-role="button" data-inline="true" data-theme="b">12</a>
                                </td>
                              </tr>                             
                            
                              <tr>
                                <td width="9%">เดือน</td>
                                <td width="91%">
                                <select name="xMonth" id="xMonth" data-native-menu="false">
                                    <option>เลือกเดือน</option>
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
                                </td>
                              </tr>
                              
                              
                              <tr>
                                <td>ปี</td>
                                <td>
                                <select name="xYear" id="xYear" data-native-menu="false">
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
