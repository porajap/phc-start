<?php
session_start();
	if($_SESSION["Area"] == "") header('location:index.html');
	$Area = $_SESSION["Area"];
require 'connect.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
$dt = date("m/d/Y");
$xID = $_SESSION["xID"];
if( $xID == "" ){
	$HCode = $_REQUEST["HCode"];
	$HName = $_REQUEST["HName"];

	$_SESSION["HCode"] = $HCode;
	$_SESSION["HName"] = $HName;

	$Sql = "INSERT INTO area_note ";
	$Sql .= "(xdate,Hospital_Code,Dt,modify_date,t6,AreaCode)";
	$Sql .= " VALUES ";
	$Sql .= "('".date("Y-m-d")."','$HCode','".date("Y-m-d")."','".date("Y-m-d H:i:s")."',0,'$Area')";
	$meQuery = mysqli_query($conn,$Sql);
	
	$Sql = "SELECT ID FROM area_note ORDER BY ID DESC LIMIT 1";
	$meQuery = mysqli_query($conn,$Sql);
	while($objResult2 = mysqli_fetch_assoc($meQuery)){
		$xID = $objResult2["ID"];
	}
	$_SESSION["xID"] = $xID;	
	
	$Sql = "INSERT INTO area_note_sub ";
	$Sql .= "(AreaNoteCode,ItemCode)";
	$Sql .= " VALUES ";
	$Sql .= "('".$xID."','999999')";
	$meQuery = mysqli_query($conn,$Sql);
	
}else{
	$HCode = $_SESSION["HCode"];
	$HName = $_SESSION["HName"];
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
            	<a href="p2.php" class="ui-btn ui-corner-all ui-btn-b ui-btn-inline ui-mini footer-button-left ui-btn-icon-left ui-icon-carat-l">กลับ</a>
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
                <form action="Save_Area.php" method="post">
                    <table width="100%" border="0" cellspacing="5" cellpadding="5">
                        <tr>
                            <td>ชื่อโรงพยาบาล</td>
                            <td>
                               <input type="hidden" name="t0" id="t0" value="<?php echo $HCode ?>" readonly="readonly">
                               <input type="text" name="t1_1" id="t1_1" value="<?php echo $HName ?>" readonly="readonly">
                               <input type="hidden" name="t6" id="t6" value="0">
                            </td>
                        </tr>
                        
                        <tr>
                            <td>สินค้าที่กำลังเสนอเข้า</td>
                            <td>

                                    <div data-demo-html="true">
                                        <ul data-role="listview" data-inset="true">
                                            <li data-role="list-divider">สินค้าที่กำลังเสนอเข้า</li>
                                            <li >
                                            	<a class="ui-alt-icon ui-btn ui-shadow ui-corner-all ui-icon-plus ui-btn-icon-right" href="ListItem.php">
                                                	<strong>เพิ่มรายการ</strong>
                                                </a>
                                            </li>
                                            <?php
                                            $strSQL2 = "SELECT item.Item_Code,item.NameTH FROM area_note_sub ";
											$strSQL2 .= "INNER JOIN item ON area_note_sub.ItemCode = item.Item_Code ";
											$strSQL2 .= "WHERE area_note_sub.AreaNoteCode = " . $xID;
                                            $objQuery2 = mysqli_query($conn,$strSQL2) ;
                                            while($objResult2 = mysqli_fetch_assoc($objQuery2))
                                            {
                                            ?>
                                                <li>
                                                <a class="ui-alt-icon ui-btn ui-shadow ui-corner-all ui-icon-minus ui-btn-icon-right" 
                                                href="DelListItem.php?ICode=<?php echo $objResult2["Item_Code"] ?>"> <?php echo $objResult2["Item_Code"] ?> : <?php echo $objResult2["NameTH"];?> </a>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </div> 
                               
                            </td>
                        </tr>
                        
                        <tr>
                            <td>ว/ด/ป</td>
                            <td>
                               <input type="text" name="t2" id="t2" value="<?php echo $dt ?>" readonly="readonly">
                            </td>
                        </tr>
                        
                        <tr>
                            <td>ผู้ติดต่อ/แผนก</td>
                            <td>
									<a href="InAreaSub.php" style="background-color:#066; color:#FF0" class="ui-alt-icon ui-btn ui-shadow ui-corner-all ui-icon-plus ui-btn-icon-right" >ป้อนรายชื่อผู้ติดต่อ/แผนก</a>
                                    <div class="ui-grid-a">
                                            <div class="ui-block-a"><div class="ui-bar ui-bar-a" style="height:30px">ผู้ติดต่อ/แผนก</div></div>
    										<div class="ui-block-b"><div class="ui-bar ui-bar-a" style="height:30px">เนื้อหา</div></div>
                                    
                                    		<?php
                                            $strSQL2 = "SELECT hospital_section.Hospital_Section,area_note_sub_note.note ";
											$strSQL2 .= "FROM area_note_sub_note ";
											$strSQL2 .= "INNER JOIN hospital_section ON area_note_sub_note.Section_ID = hospital_section.Section_ID ";
											$strSQL2 .= "WHERE area_note_sub_note.AreaNoteCode = " . $xID;
                                            $objQuery2 = mysqli_query($conn,$strSQL2) ;
                                            while($objResult2 = mysqli_fetch_assoc($objQuery2))
                                            {
                                            ?>
                                                <div class="ui-block-a"><?php echo $objResult2["Hospital_Section"] ?></div>
                                        		<div class="ui-block-b"><?php echo $objResult2["note"];?></div>
                                            <?php
                                            }
                                            ?>
                                    </div>                                    
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
              <tr>
              	<td>
                    
                </td>
              </tr>
</table>


</body>

</html>
