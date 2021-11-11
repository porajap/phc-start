<?php session_start();
require 'connect.php';
require 'THdateclass.php';
	if($_SESSION["Em_Code"] == "") header('location:index.html');
	$Area = $_SESSION["Area"];
	$xName = $_SESSION["xName"];
	$ChildofType = $_SESSION["ChildOfType"];
  $Em_Code = $_SESSION["Em_Code"];

  $dateobj = new DatetimeTH;


	 ?>
<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Login</title>

 <link rel="shortcut icon" href="icon/icon.ico">
 <link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.min.css">
 <link rel="stylesheet" href="_assets/css/jqm-demos.css">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
 <link rel="stylesheet" href="css/sty.css">
 <link rel="stylesheet" href="css/box2.css">
 <link rel="stylesheet" href="css/box3.css">
 <script type="text/javascript" src="js/jquery.js"></script>
 <script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>
 <script type="text/javascript" src="js/jquery.mousewheel.min.js"></script>
 <script type="text/javascript" src="js/jqm-spinbox.min.js"></script>
 <script type="text/javascript">
	</script>
  <style media="screen">
    .opacitysale{
      background-color: #ffffff !important;
    }
    .hi{
      height: 40px;
    }
  </style>

	</head>
	<body >
		<div data-role="page" data-cache="never">
		<div data-demo-html="true">
			<div data-role="header">
            	<a href="order.php" class="ui-btn ui-corner-all ui-btn-inline ui-mini footer-button-left ui-btn-icon-left ui-icon-carat-l">กลับ</a>
            	<h1> <?php echo $Area ?> : คุณ<?php echo $xName ?></h1>
				<a href="logoff.php" class="ui-btn-right ui-btn ui-btn-b ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-power">ออก</a>
			</div>
		</div>
	<table style="background: rgba(255,255,255,0.3);" width="100%" border="0" cellspacing="5" cellpadding="5">
              <tr>
              <tr>
                    <td>
                        <div align="center"><h2>ข้อมูลการขาย ลูกข่าย</h2></div>
                    </td>
                </tr>
              <tr>
                <td>
					<form action="Saledetail_child.php" method="get" name="Formsubmit">
                        <div data-demo-html="true">
                            <div class="ui-field-contain">

                            <table width="100%" border="0" cellspacing="2" cellpadding="2">
                              <tr>
                                <td>
                                        <label for="textinput-fc">ปี :</label>
                                        <select  name="year" id="year">
                                          <option value="2561" <?php if($_GET["year"]=="2561") echo "selected='selected'"; ?>>2561</option>
                                          <option value="2560" <?php if($_GET["year"]=="2560") echo "selected='selected'"; ?>>2560</option>
                                          <option value="2559" <?php if($_GET["year"]=="2559") echo "selected='selected'"; ?>>2559</option>
                                        </select>
                                </td>
                                <td>
                                        <label for="textinput-fc">เดือน : </label>
                                        <select  name="month" id="month">
                                          <option value="01" <?php if($_GET["month"]=="01") echo "selected='selected'"; ?>>มกราคม</option>
                                          <option value="02" <?php if($_GET["month"]=="02") echo "selected='selected'"; ?>>กุมภาพันธ์</option>
                                          <option value="03" <?php if($_GET["month"]=="03") echo "selected='selected'"; ?>>มีนาคม</option>
                                          <option value="04" <?php if($_GET["month"]=="04") echo "selected='selected'"; ?>>เมษายน</option>
                                          <option value="05" <?php if($_GET["month"]=="05") echo "selected='selected'"; ?>>พฤษภาคม</option>
                                          <option value="06" <?php if($_GET["month"]=="06") echo "selected='selected'"; ?>>มิถุนายน</option>
                                          <option value="07" <?php if($_GET["month"]=="07") echo "selected='selected'"; ?>>กรกฎาคม</option>
                                          <option value="08" <?php if($_GET["month"]=="08") echo "selected='selected'"; ?>>สิงหาคม</option>
                                          <option value="09" <?php if($_GET["month"]=="09") echo "selected='selected'"; ?>>กันยายน</option>
                                          <option value="10" <?php if($_GET["month"]=="10") echo "selected='selected'"; ?>>ตุลาคม</option>
                                          <option value="11" <?php if($_GET["month"]=="11") echo "selected='selected'"; ?>>พฤศจิกายน</option>
                                          <option value="12" <?php if($_GET["month"]=="12") echo "selected='selected'"; ?>>ธันวาคม</option>
                                        </select>
                                </td>
                              </tr>
							<tr>
                <td colspan="2">
                       	<input type="submit" class="ui-shadow ui-btn ui-corner-all" name="submit-button-1" id="submit-button-1" value="ตกลง">
                    </form>
                </td>
              </tr>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <table class="opacitysale" width="100%" border="1" cellspacing="0" cellpadding="0" >
                <tr class="hi">
                  <th>รหัสลูกข่าย</th>
                  <th>เดือน</th>
                  <th>ปี</th>
                  <th>ยอดขาย</th>
                </tr>

                <?php
                if(isset($_GET["month"])){
                  $mm = $_GET["month"];
                  $yy = (int)$_GET["year"] - 543;
                }else {
                  $yy = date("Y");
                  $mm = date("m");
                }
                  $sql = "SELECT Sale_Code,Price,mm,yyyy FROM sale_income WHERE mm = '$mm' AND yyyy = '$yy' AND ChildOf = '$Em_Code' ";
                  $meQuery = mysqli_query($conn,$sql);
                  while($Result = mysqli_fetch_assoc($meQuery)) {
                  ?>  <tr class="hi">
                      <td align="center"><?php echo$Result["Sale_Code"];?></td>
                      <td align="center"><?php echo$dateobj->getTHmonth($Result["mm"]);?></td>
                      <td align="center"><?php echo(int)$Result["yyyy"]+543;?></td>
                      <td align="center"><?php echo$Result["Price"];?></td>
                    </tr>
                <?php
                  }

                 ?>

              </table>
            </td>
          </tr>
</table>

</div>
	</body>
</html>
