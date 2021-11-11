<?php
session_start();
require 'connect.php';
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
$xName = $_SESSION["xName"];
$Area = $_SESSION["Area"];
$mm = date('m') + 1;
$cmm = date('m');
if($mm < 10) $mm = "0".$mm;
$yy = date('Y');
$IsStatus = $_REQUEST["IsStatus"];
$xSt = 1;
$n = 0;
			if($IsStatus == 1){
				$xID = $_REQUEST["xID"];
				$Sql = "DELETE FROM product_intonext_month ";
				$Sql .= "WHERE ID = '$xID'";
				$meQuery = mysqli_query($conn,$Sql);
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
        <a href="p2.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?php echo $Area ?></div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
    </div>
    <div>
      <div align="center" class="xTb">บันทึกสินค้าคาดว่าจะเข้า( เดือนถัดไป )</div>                                                      
      <form action="Save_PIM.php" method="post">
                        <input type="hidden" name="xYear" id="xYear" value="<?= $yy ?>">
                        <input type="hidden" name="xMonth" id="xMonth" value="<?= $mm ?>">
                        <input type="hidden" name="cMonth" id="cMonth" value="<?= $cmm ?>">
                        <input type="hidden" name="xSt" id="xSt" value="<?= $xSt ?>">
                        <input type="hidden" name="Area" id="Area" value="<?= $Area ?>">

                        <div class="input-group mb-3">
                          <span class="input-group-text xBoxWh">ร.พ./คลีนิค</span>
                          <input type="text" name="Hospital" id="Hospital" value="" class="form-control" placeholder="ร.พ./คลีนิค" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                          <span class="input-group-text xBoxWh">สินค้า</span>
                          <input type="text" name="Product" id="Product" value="" class="form-control" placeholder="สินค้า" aria-describedby="basic-addon1">
                        </div>

                        <div class="d-grid xTb">
                          <button class="btn btn-primary" name="submit-button-1" id="submit-button-1" >บันทึก</button>
                        </div>

                        <table class="tables">
                            <thead>
                              <tr>
                                <th style="width: 10%;">ลำดับ</th>
                                <th style="width: 40%;">ร.พ./คลีนิค</th>
                                <th style="width: 50%;">สินค้า</th>
                              </tr>
                            </thead>
                            <tbody>
                            
      <?php 	
			 			$Sql = "SELECT ID,YY,MM,Hotpital,Product ";
						$Sql .= "FROM product_intonext_month ";
						$Sql .= "WHERE Area = '$Area' AND YY = '$yy' AND MM = '$mm' AND xMM = '$cmm'";
						$meQuery = mysqli_query($conn,$Sql);
						while ($Result = mysqli_fetch_assoc($meQuery))
						{

			?>               
                              <tr>
                                <th>
                                <a href="ProductNewNext.php?IsStatus=1&xID=<?php echo $Result["ID"] ?>" ><img src="img/del.png" width="16" height="16" /></a>
                                <?php echo $j+1 ?></th>
                                <td><?php echo $Result["Hotpital"] ?></td>
                                <td><?php echo $Result["Product"] ?></td>
                              </tr>
            <?php $j++; } ?>
                            </tbody>
                            <tfoot>
                              <tr class="ui-bar-a">
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th></th>
                                </tr>
                            </tfoot>
                          </table>
                                </td>
                            </td>

                            </table>
    </form>
  </div>
</body>

</html>
