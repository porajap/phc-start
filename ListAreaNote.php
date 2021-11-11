<?php

session_start();
require 'connect.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
$Area = $_SESSION["Area"];
$dt = date("d/m/Y");

$HCode = $_REQUEST["HCode"];
$HName = $_REQUEST["HName"];
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
                        <table width="100%" border="0" cellspacing="5" cellpadding="5">
                                    <tr>
                                        <td>โรงพยาบาล : </td>
                                        <td><?php echo $HName ?></td>
                                    </tr>
                    				<tr>
                                        <td>สินค้าที่เข้าอยู่ : </td>
                                        <td>
                        <table width="100%" border="0" cellspacing="5" cellpadding="5">                
                        <?php
                        $strSQL2 = "SELECT item.NameTH FROM area_note ";
						$strSQL2 .= "INNER JOIN area_note_sub ON area_note.ID = area_note_sub.AreaNoteCode ";
						$strSQL2 .= "INNER JOIN item ON area_note_sub.ItemCode = item.Item_Code ";
						$strSQL2 .= "WHERE area_note.Hospital_Code = '$HCode' AND item.IsSale = 1 ";
						$strSQL2 .= "GROUP BY item.Item_Code ORDER BY area_note.Dt ASC";
						
                        $objQuery2 =  mysqli_query($conn,$strSQL2);
						
                        while($objResult2 = mysqli_fetch_assoc($objQuery2))
                        {
                        	$ItemName .= $objResult2["NameTH"] . " / ";
						}
						?>
                        <tr><td><?php echo $ItemName ?></td></tr> 
                        </table>  
                                        </td>
                                    </tr>
                                  <tr>
                                    <td colspan="2">
                                      
						<table width="100%" border="0" cellspacing="5" cellpadding="5">
                        	<tr>
                                <td>วัน/เดือน/ปี</td>   
                                <td>แผนกที่เข้าพบ/ชื่อลูกค้า</td>
                                <td>เนื้อหาการทำงานโดยละเอียด</td>
                            </tr>          
                        <?php
                        $strSQL2 = "SELECT area_note.Dt,area_note_sub_note.note,hospital_section.Hospital_Section,area_note.t6 ";
						$strSQL2 .= "FROM area_note ";
						$strSQL2 .= "INNER JOIN area_note_sub_note ON area_note.ID = area_note_sub_note.AreaNoteCode ";
						$strSQL2 .= "INNER JOIN hospital_section ON area_note_sub_note.Section_ID = hospital_section.Section_ID ";
						$strSQL2 .= "WHERE area_note.Hospital_Code = '$HCode'  ";
						$strSQL2 .= "ORDER BY area_note.Dt ASC";

                        $objQuery2 =  mysqli_query($conn,$strSQL2);
                        while($objResult2 = mysqli_fetch_assoc($objQuery2))
                        {
							if($objResult2["t6"] == 1){
                        ?>
                            <tr style="color:#F00">
                                <td><?php echo $objResult2["Dt"] ?></td>   
                                <td><?php echo $objResult2["Hospital_Section"] ?></td>
                                <td><?php echo $objResult2["note"] ?></td>
                            </tr>        
                        <?php
							}else{
						?>
                            <tr>
                                <td><?php echo $objResult2["Dt"] ?></td>   
                                <td><?php echo $objResult2["Hospital_Section"] ?></td>
                                <td><?php echo $objResult2["note"] ?></td>
                            </tr>        
                        <?php		
							}
						}
						?>
                        </table>
                                                              
                                    </td>
                                  </tr>
                        </table>
                </td>
              </tr>
	</table>
</body>

</html>


