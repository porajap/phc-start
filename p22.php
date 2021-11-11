<?php
session_start();
	if($_SESSION["Area"] == "") header('location:index.html');
	$Area = $_SESSION["Area"];
	$xName = $_SESSION["xName"];
	$_SESSION["xID"] = "";
	$Bk= substr($Area,0,2);
	
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
    <link rel="stylesheet" href="css/jquery.mobile.datepicker.css">
	<script src="js/jquery.js"></script>
	<script src="js/jquery.mobile-1.4.5.min.js"></script>
    <script src="js/jquery.ui.datepicker.js"></script>
    <script id="mobile-datepicker" src="js/jquery.mobile.datepicker.js"></script>
</head>

<body>
			<div data-demo-html="true">
			<div data-role="header">
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
                            <ul data-role="listview" data-inset="true" data-divider-theme="a">
                                <li data-role="list-divider">[ เมนู ]</li>
                                <?php 
									if($Area == "padmin"){
										echo "<li><a  style='color:#00F' href='Date03.php'>Daily call</a></li>";
										echo "<li><a  style='color:#00F' href='Area01.php'>Cyclic purchasing ( ALL )</a></li>";
										echo "<li><a  style='color:#00F' href='AreaDispenser.php'>Cyclic purchasing ( Dispenser )</a></li>";
										echo "<li><a  style='color:#00F' href='SaleBB.php'>Sale For Month</a></li>";
                             		}else if($Area == "psbkk"){
										echo "<li><a  style='color:#00F' href='Date03.php'>Daily call</a></li>";
										echo "<li><a  style='color:#00F' href='Area01.php'>Cyclic purchasing ( ALL )</a></li>";
										echo "<li><a  style='color:#00F' href='AreaDispenser.php'>Cyclic purchasing ( Dispenser )</a></li>";
										echo "<li><a  style='color:#00F' href='SaleBB.php'>Sales/Month</a></li>";
									}else{
										
										echo "<li><a style='color:#00F' href='order.php'>บันทึกขอซื้อ</a></li>";
                                		echo "<li><a style='color:#00F' href='Quotation.php'>เสนอราคา</a></li>";
                                		echo "<li><a style='color:#00F' href='Bring.php'><img src='img/logo_0.png' width='100' height='100'> ใบเบิกสินค้า ( Dispenser )</a></li>";
                                		echo "<li><a style='color:#00F' href='Borrow.php'>ใบยืมสินค้า</a></li>";
										echo "<li><a style='color:#00F' href='SaleBB.php'>Sales/Month</a></li>";
										echo "<li><a style='color:#00F' href='Date03.php'>Daily call</a></li>";
										echo "<li><a style='color:#00F' href='Area01.php'>Cyclic purchasing ( ALL )</a></li>";
										echo "<li><a style='color:#00F' href='AreaDispenser.php'>Cyclic purchasing ( Dispenser )</a></li>";
										echo "<li><a style='color:#00F' href='Customer.php'>ราคาสินค้า ตามบิล/ลูกค้า</a></li>";
										echo "<li><a style='color:#00F' href='Date01.php'>ราคาสินค้า</a></li>";
										echo "<li><a style='color:#00F' href='SelCustomer.php'>รายการสินค้า ตาม รายลูกค้า</a></li>";
										
										
										echo "<li><a style='color:#00F' href='ProductNew.php'>บันทึกสินค้าเข้าใหม่ ( เดือนปัจจุบัน )</a></li>";
										echo "<li><a style='color:#00F' href='ProductNewNext.php'>บันทึกสินค้าคาดว่าจะเข้า( เดือนถัดไป )</a></li>";
										echo "<li><a style='color:#00F' href='p2_1.php'>กิจกรรมประจำเดือน</a></li>";
										
										echo "<li><a style='color:#00F' href='cPassword.php'>เปลี่ยนรหัสผ่าน</a></li>";
										echo "<li><a style='color:#00F' href='Date06.php'>รายงานสรุปยอดขาย</a></li>";
										echo "<li><a style='color:#00F' href='Date07.php'>รายงานสรุปยอดขายประจำเดือน</a></li>";
										echo "<li><a style='color:#00F' href='activity_show.php'>รายงานกิจกรรมที่ทำภายในเดือน</a></li>";
										echo "<li><a style='color:#00F' href='idea_show.php'>รายงานปัญหาที่พบ/ข้อเสนอแนะ/ข้อมูลคู่แข่ง</a></li>";
										echo "<li><a style='color:#00F' href='ProductNew_Show.php?IsStatus=0'>รายงานสินค้าเข้าใหม่ ( เดือนปัจจุบัน )</a></li>";
										echo "<li><a style='color:#00F' href='ProductNew_Show.php?IsStatus=1'>รายงานสินค้าคาดว่าจะเข้า( เดือนถัดไป )</a></li>";
									}
								?>    
                                
                                <?php 
										if($Bk == "BB"){
								?>   
                                 			<li><a style='color:#00F' href="ListHospital.php?AF=0" style="color:red">บันทึกการเข้าพื้นที่</a></li>
                                			<li><a style='color:#00F' href="ListHospital.php?AF=1" style="color:red">บันทึกการเข้าพื้นที่ ( ย้อนหลัง )</a></li>
                                            <li><a style='color:#00F' href="ListHospital2.php" style="color:red">รายการ เข้าพื้นที่</a></li>
								<?php 
										}
								?>
                                
                                <li><a style='color:#FF0000' href="logoff.php">ออกจากระบบ</a></li>
                            </ul>
                        </div>
                </td>
              </tr>
</table>


</body>

</html>
