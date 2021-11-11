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
$IsStatus = $_REQUEST["IsStatus"];
$xSt = 0;
$n = 0;

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
	<script src="js/jquery/3.5.1/jquery.min.js "></script>
	<script src="assets/dist/js/bootstrap.js "></script>
	<script src="assets/dist/js/bootstrap.bundle.min.js "></script>
    <script src="assets/dist/js/sweetalert2.min.js"></script>
    <style>
        .xTop1{
            margin-top: 7px;
            margin-left: 1px;
            margin-right: 1px;
        }

        .xTb{
            margin-top: 7px;
            margin-left: 1px;
            margin-right: 1px;
            margin-bottom: 7px;
        }

        .label1{
            margin-left: 10px;
            margin-top: 7px;
        }

        .label2{
            margin-left: 10px;
            margin-top: 7px;
            margin-bottom: 7px;
        }
    </style>
</head>

<body>
	<div class="topnav">
        <a href="p2.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?php echo $Area ?></div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
    </div>

	<table class="tables">
                <tr>
                    <td>
                                    <?php 	
									    echo  "เขตที่ส่งข้อมูล เดือน $mm/$yy<BR/>";
										$j=0;
										$Sql = "SELECT Area ";
										$Sql .= "FROM product_intonext_month ";
										 if($IsStatus==1)
											$Sql .= "WHERE YY = '$yy' AND xMM = '$mm' AND MM = '".createDigit2($mm+1)."' AND St = '$IsStatus' ";
										else
											$Sql .= "WHERE YY = '$yy' AND MM = '$mm' AND xMM =  '$mm' AND St = '$IsStatus' ";
										$Sql .= "GROUP BY product_intonext_month.Area ";
										$Sql .= "ORDER BY Area ASC";
										$meQuery1 = mysqli_query($conn,$Sql);
										while ($Result1 = mysqli_fetch_assoc($meQuery1))
										{
											echo  $j+1 ." :  " . $Result1["Area"] . "<BR/>";
											$asArea[$j] =  $Result1["Area"];
											$j++;
										}
										echo  ".................................................<BR/>";
									?>
                    </td>
                </tr>
                
              <tr>
                <td>
                    <form action="Save_PIM.php" method="post">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                            	<td></td>
                            	<td>
                                    <table data-role="table" id="table-custom-2" data-mode="columntoggle" class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="Columns to display..." data-column-popup-theme="a">
            
                            <thead>
                              <tr class="ui-bar-d">
                                <th data-priority="2">ลำดับ</th>
                                <th >ร.พ./คลีนิค</th>
                                <th data-priority="1">
                                สินค้า 
                                <?
									if($IsStatus ==0){
										echo "เข้าใหม่ ( เดือนปัจจุบัน )";
									}else{
										echo "คาดว่าจะเข้า( เดือนถัดไป )";
									}
								?>
                                </th>
                              </tr>
                            </thead>
                            <tbody>
                            
             <?php 	
				$meQuery1 = mysqli_query($conn,$Sql);
				for ($o=0;$o<$j;$o++)
				{
					$Sql = "SELECT ID,Area,YY,MM,Hotpital,Product ";
					$Sql .= "FROM product_intonext_month ";
					if($IsStatus==1)
						$Sql .= "WHERE Area = '".$asArea[$o]."' AND YY = '$yy' AND MM = '".createDigit2($mm+1)."' AND xMM = '$mm' AND St = '$IsStatus' ";
					else
						$Sql .= "WHERE Area = '".$asArea[$o]."' AND YY = '$yy' AND MM = '$mm' AND xMM = '$mm' AND St = '$IsStatus' ";
						
					$Sql .= "ORDER BY Area ASC";
					$meQuery2 = mysqli_query($conn,$Sql);
					while ($Result2 = mysqli_fetch_assoc($meQuery2))
					{
			 ?>               
                              <tr style="background:#066;color:#FFF" >
                                <td><?php echo $Result2["Area"] ?></td>
                                <td><?php echo $Result2["Hotpital"] ?></td>
                                <td><?php echo $Result2["Product"] ?></td>
                              </tr>
            <?php 
						
					} 
			?>
							<tr>
                                <td>.</td>
                                <td></td>
                                <td></td>
                              </tr>
            <?php                  
				}
			?>
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
                </td>
              </tr>
</table>


</body>

</html>
