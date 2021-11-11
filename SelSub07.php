<?php
session_start();
if($_SESSION["Area"] == "") header('location:index.html');
require 'connect.php';
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
	
	if($_POST["xGP07"] != ""){
		$xGP07 = $_POST["xGP07"];
		$xYear = $_POST["xYear07"];
		$xMonth = $_POST["xMonth07"];
		
		$_SESSION["xGP07"] = $xGP07 ;
		$_SESSION["xYear07"] = $xYear ;
		$_SESSION["xMonth07"] = $xMonth ;
	}else{
		 $xGP07 = $_SESSION["xGP07"] ;
	}
	
	$Sql = "SELECT Category_Code, Category_Name, Status FROM item_category WHERE CategoryMain_Code = '$xGP07'";
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
            	<a href="Date07.php" class="ui-btn ui-corner-all ui-btn-inline ui-mini footer-button-left ui-btn-icon-left ui-icon-carat-l">กลับ</a>
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
                    <form action="chkDate07.php" method="post">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">     
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
