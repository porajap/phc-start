<?php
session_start();
	if($_SESSION["Area"] == "") header('location:index.html');
	$Area = $_SESSION["Area"];
require 'connect.php';

	$HCode = $_SESSION["HCode"];
	$HName = $_SESSION["HName"];

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
            	<a href="AfterArea.php" class="ui-btn ui-btn-b ui-corner-all ui-btn-inline ui-mini footer-button-left ui-btn-icon-left ui-icon-carat-l">กลับ</a>
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
                <form action="Save_Area_Note_Sub.php" method="post">
                    <table width="100%" border="0" cellspacing="5" cellpadding="5">
                        <tr>
                            <td>ชื่อโรงพยาบาล : <?php echo$HCode?></td>
                            <td>
                               <input type="hidden" name="t0" id="t0" value="<?php echo $HCode ?>" readonly="readonly">
                               <input type="text" name="t1_1" id="t1_1" value="<?php echo $HName ?>" readonly="readonly">
                               <input type="hidden" name="t6" id="t6" value="0">
                            </td>
                        </tr>
                        <tr>
                            <td>ผู้ติดต่อ/แผนก</td>
                            <td>
                               <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
                                    <select name="t3" id="t3">
                                    <?
										$strSQL2 = "SELECT Section_ID,Hospital_Section " .
										"FROM hospital_section " .
										"WHERE Hospital_Code = '$HCode'";
										$objQuery2 = mysqli_query($conn,$strSQL2) ;
										while($objResult2 = mysqli_fetch_assoc($objQuery2))
										{
									?>
                                        <option value="<?php echo $objResult2["Section_ID"] ?>"><?php echo $objResult2["Hospital_Section"] ?></option>
                                    <?php 
										}
									?>
                                    </select>
                                    
                                    <a class="ui-shadow ui-btn ui-corner-all" href="ListHospitalSection.php?Id=" > +/- </a>

                                </fieldset>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>เนื้อหา</td>
                            <td>
                               <textarea name="t4" id="t4"></textarea>
                            </td>
                        </tr>
                        
                        
                        
                        <tr>
                            <td>&nbsp;</td>
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
