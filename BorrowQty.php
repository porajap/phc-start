<?php
session_start();
require 'connect.php';
	if($_SESSION["Area"] == "") header('location:index.html');
	if($_SESSION["Cus_Code"] == "") header('location:index.html');
	if($_REQUEST["ItemCode"] == "") header('location:index.html');

  $xTitle = $_SESSION["xTitle"];
	$ItemCode = $_REQUEST["ItemCode"];
  $Price = $_REQUEST["Price"];
  $Area = $_SESSION["Area"];
  function getUnitName( $conn,$vl ) {

	$UName = "";
	$Sql =  "SELECT item_unit.Unit_Name FROM item_unit WHERE item_unit.Unit_Code =$vl";
	$meQuery = mysqli_query($conn, $Sql);
	while ($Result = mysqli_fetch_assoc($meQuery)){
		$UName = $Result["Unit_Name"];
	}
	echo $UName;
	// return  $UName;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>PHC</title>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="icon/icon.ico">
    <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/dist/css/sweetalert2.min.css">
	  <link rel="stylesheet" href="css/topnav.css">
    <link rel="stylesheet" href="css/all.css">
	  <script src="js/jquery/3.5.1/jquery.min.js "></script>
	  <script src="assets/dist/js/bootstrap.js "></script>
	  <script src="assets/dist/js/bootstrap.bundle.min.js "></script>
    <script src="assets/dist/js/sweetalert2.min.js"></script>
</head>

<body>
<div class="topnav">
        <a href="Borrow_DocNo.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $Area ?> : <?= $xTitle ?></div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
    </div>

    <?php
	if($_POST["Qty"] != "" && $_POST["Price"] != ""){
		$_SESSION["Qty"] = $_POST["Qty"];
		$_SESSION["Price"] = $_POST["Price"];
		$_SESSION["ItemCode"] = $_POST["ItemCode"];
		$_SESSION["xDetail"] = $_POST["xDetail"];

    echo "<script>
    window.location.href = 'Borrow_DocNo.php?add=1&sel=0';
    </script>
    ";
	}
?>
    <form action="BorrowQty.php" method="post">
      <div class="input-group">
        <span class="input-group-text xBoxWh">ราคา</span>
        <input type="text" name="Price" id="Price" value="<?php echo $Price ?>" class="form-control" aria-describedby="basic-addon1">
      </div>
      <div class="input-group">
        <span class="input-group-text xBoxWh">รายการ</span>
        <input type="text" name="ItemCode" id="ItemCode" value="<?php echo $ItemCode ?>" class="form-control" aria-describedby="basic-addon1">
      </div>
      <div class="input-group">
        <span class="input-group-text xBoxWh">จำนวน</span>
        <input type="text" name="Qty" id="Qty" placeholder="ป้อนจำนวนสินค้าที่ต้องการ ( 0-9 เท่านั้น )" value="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" class="form-control" aria-describedby="basic-addon1">
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text xBoxWh">หน่วยนับ</span>
        <select name="UnitCode" id="UnitCode" class="form-select" aria-label="Default select example">
          <?php 
            $Sql1 =  "SELECT item.Unit_Code,item.UnitAlt_Code,item.MultiplierValue FROM item WHERE item.Item_Code = '$ItemCode'";
            $meQuery = mysqli_query($conn,$Sql1);
            while ($Result2 = mysqli_fetch_assoc($meQuery)){
          ?> 
              <option selected="selected" value="<?php echo $Result2["Unit_Code"]  ?>"><?php  getUnitName( $conn,$Result2["Unit_Code"] ); ?></option>
              <option value="<?php echo $Result2["UnitAlt_Code"]  ?>"><?php   getUnitName( $conn,$Result2["UnitAlt_Code"] );?></option>
          <?php 
            }
          ?>
              </select>
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text xBoxWh">หมายเหตุ</span>
      <TEXTAREA name="xDetail" id="xDetail" class="form-control" placeholder="กรอกรายละเอียด" aria-describedby="basic-addon1"><?php echo $Detail ?></TEXTAREA>
      </div>

      <div class="d-grid">
        <button class="btn btn-primary" name="submit-button-1" id="submit-button-1" >บันทึก</button>
      </div>
    </form>
</body>

</html>
