<?php
session_start();
require 'connect.php';
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

if($_SESSION["Area"] == "") header('location:index.html');

if( $_REQUEST["add"]== 0){
	$_SESSION["DocNo"] = "";
	$_SESSION["ItemCode"] = "";
	$_SESSION["Qty"] = "";
	$_SESSION["Price"] = "";
	$_SESSION["Detail"] = "";
	$_SESSION["UnitCode"] = "";
}else{
	if($_REQUEST["DocNo"] != "" ) $_SESSION["DocNo"] = $_REQUEST["DocNo"];	
}

if($_REQUEST["Cus_Code"] != "" ){
	$CusCode = $_REQUEST["Cus_Code"];
	$_SESSION["Cus_Code"] = $CusCode;

}
	$Area = $_SESSION["Area"];
	$xTitle = $_SESSION["xTitle"];
	$CusCode = $_SESSION["Cus_Code"];
	$DocNo = $_SESSION["DocNo"];
	$UnitCode = $_SESSION["UnitCode"];

	if($DocNo == "" || $DocNo == null ){
	
			// $Sql1 = "SELECT COALESCE(CONVERT(SUBSTRING(DocNo,-5),UNSIGNED INTEGER),0)+1 AS DocNo FROM saleorder_sale ORDER BY ID DESC LIMIT 1";
			// //$Sql1 = "SELECT COALESCE(MAX(CONVERT(SUBSTRING(DocNo,-4),UNSIGNED INTEGER)),0)+1 AS DocNo FROM saleorder_sale WHERE saleorder_sale.IsCancel = 0 ORDER BY DocNo DESC LIMIT 1";
			
			// $meQuery = mysqli_query($conn,$Sql1);
			// while ($Result = mysqli_fetch_assoc($meQuery))
			// {
			// 	$DocNo = $Result["DocNo"];
			// }
			// if($DocNo != ""){
			// 	$DocNo = "Q" . substr(date('Ym'),2,6) ."-" . createDigit($DocNo);
			// }

			$sql = "SELECT 

						CONCAT
						(
								'Q', 
								DATE_FORMAT(NOW(),'%y%m-'), 
								LPAD((COALESCE(MAX(CONVERT(SUBSTRING(DocNo, 7, 5), UNSIGNED INTEGER)), 0) + 1), 5, 0)
						) AS docNo
					
					FROM saleorder_sale
					
					WHERE DocNo LIKE CONCAT('Q', DATE_FORMAT(NOW(),'%y%m'),'%')
					
					ORDER BY DocNo DESC LIMIT 1";
			$meQuery = mysqli_query($conn, $sql);
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				$DocNo = $Result["docNo"];
			}
			
	}

			$Cn = 0;
			$Sql2 = "SELECT DocNo,IsFinish,IsSave,IsCancel FROM saleorder_sale WHERE DocNo = '$DocNo' AND saleorder_sale.IsCancel = 0";
			
			$meQuery = mysqli_query($conn,$Sql2 );
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				$Cn++;
			}
			if($Cn == 0) {
					$Sql3 = "INSERT saleorder_sale (DocNo,DocDate,Cus_Code,Area_Code) ";
					$Sql3 .= " VALUES ";
					$Sql3 .= "('$DocNo',NOW(),'$CusCode','$Area')";
					
					$meQuery = mysqli_query($conn,$Sql3);
			}

			if( $_REQUEST["sel"]== 0){
				$xBack = "p2.php";
			}else{
				$xBack = "Quotation.php";
			}

			$Sql4 = "SELECT DocNo,IsFinish,IsCancel,Detail,Detail2,IsPO,IsQT,IsBV,IsST,customer.Cus_Code,CONCAT(customer.FName,' ',customer.LName) AS xName ";
			$Sql4 .= "FROM saleorder_sale ";
			$Sql4 .= "INNER JOIN customer ON saleorder_sale.Cus_Code = customer.Cus_Code ";
			$Sql4 .= "WHERE DocNo = '$DocNo' AND saleorder_sale.IsCancel = 0";
			
			$meQuery = mysqli_query($conn,$Sql4);
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				$DocNo = $Result["DocNo"];
				$Detail = $Result["Detail"];
				$Detail2 = $Result["Detail2"];
				$IsFinsh = $Result["IsFinish"];
				$IsCancel = $Result["IsCancel"];
				$_SESSION["Cus_Code"] = $Result["Cus_Code"];
				$CusFullName = $Result["xName"];
				$IsPO = $Result["IsPO"];
				$IsQT = $Result["IsQT"];
				$IsBV = $Result["IsBV"];
				$IsST = $Result["IsST"];
				
				$_SESSION["DocNo"] = $DocNo;
			}

			if( $_SESSION["ItemCode"] != "" && $_SESSION["Price"] != "" ){
				$ItemCode = $_SESSION["ItemCode"];
				//$DocNo = $_SESSION["DocNo"];
				$Qty = $_SESSION["Qty"];
				$Price = $_SESSION["Price"];
				$Total = $Qty * $Price;
				$xDetail = $_SESSION["xDetail"];
				
				$Sql5 = "INSERT saleorder_sale_detail (DocNo,Item_Code,Qty,Price,Total,Detail,Unit_Code) ";
				$Sql5 .= " VALUES ";
				$Sql5 .= "('$DocNo','$ItemCode',$Qty,$Price,$Total,'$xDetail','$UnitCode')";
				
				$meQuery = mysqli_query($conn,$Sql5);
				
				$_SESSION["ItemCode"] = "";
				$_SESSION["Qty"] = "";
				$_SESSION["Price"] = "";
				$_SESSION["Detail"] = "";
				$_SESSION["UnitCode"] = "";
		}
	
			$Sql6 = "SELECT saleorder_sale_detail.Id,item.Item_Code,item.NameTH,saleorder_sale_detail.Qty,saleorder_sale_detail.Price,saleorder_sale_detail.Total ";
			$Sql6 .= "FROM item ";
			$Sql6 .= "INNER JOIN saleorder_sale_detail ON saleorder_sale_detail.Item_Code = item.Item_Code ";
			$Sql6 .= "WHERE DocNo = '$DocNo'";
			$Sql6 .= "AND item.Grp_1 = 1 ";
			
			$meQuery = mysqli_query($conn,$Sql6);
			$i=0;
			$xPT = 0.00;
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				$xId[$i] = $Result["Id"];
				$xItemCode[$i] = $Result["Item_Code"];
				$xItem[$i] = $Result["NameTH"];
				$xQty[$i] = $Result["Qty"];
				$xPrice[$i] = $Result["Price"];
				$xTotal[$i] = $Result["Total"];
				$xPT += $xTotal[$i];
				$i++;
			}	
			
			$VL[0]="ส่ง EMS ถึง";
			$VL[1]="ส่ง FAX";
			$VL[2]="ส่ง Email";
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
        <a href="Quotation.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $Area ?> : <?= $xTitle ?></div>
        <div class="topnav-right">            
            <a href="Customer2.php"><img src="img/add_doc_2.png" width="30px" height="30px" /> </a>
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
	</div>

	<table width="100%" border="0">
                <tr>
                    <td>
                        <div align="center"><img src="img/logo.png" width="220" height="45" /></div>
                    </td>
                </tr>
              
              <tr>
                <td>
						<table width="100%" border="0" cellspacing="2" cellpadding="2">
                          <tr>
                            <td width="40%">เลขที่เอกสาร</td>
                            <td><?php echo $DocNo ?></td>
                          </tr>
                          <tr>
                            <td>วันที่เอกสาร</td>
                            <td><?php echo date("Y-m-d") ?></td>
                          </tr>
                          <tr>
                            <td>ขอใบเสนอราคาให้</td>
                            <td><?php echo $CusFullName ?></td>
                          </tr>
                         
                        </table>

                </td>
              </tr>              
                
              <tr>
                <td>
                <?php if($IsCancel==0 && $IsFinsh==0){ ?>
					<div class="row">
						<div class="col-12">
							<div class="list-group">
								<a class="list-group-item list-group-item-action active" href="#" >[ เมนู ]</a>
								<a class="list-group-item list-group-item-action" href="QtPriceSale.php?sel=2">เลือกรายการ</a>
							</div>
						</div>
					</div>
              	<?php } ?>
                </td>
              </tr>
              <tr>
                            <td width="40%">
                            	
                            </td>
              </tr>                          
                <tr>
                    <td>
          <div data-demo-html="true">

			<table class="table">

                <thead>
                  <tr class="ui-bar-d">
                    <th data-priority="2">ลำดับ</th>
                    <th >รายการ</th>
                    <th data-priority="1">จำนวน</th>
                    <th data-priority="3">ราคา</th>
                    <th data-priority="5">เป็นเงิน</th>
                  </tr>
                </thead>
                <tbody>
                
 <?php 	for($j=0;$j<$i;$j++){ ?>               
                  <tr>
                    <th>
                    <?php if($IsFinsh == 0){?>
                    <a href="QtDelItem.php?DocNo=<?php echo $DocNo ?>&Id=<?php echo $xId[$j] ?>" ><img src="img/del.png" width="16" height="16" /></a>
					<?php } ?>
					<?php echo $j+1 ?></th>
                    <td><?php echo $xItem[$j] ?></td>
                    <td><?php echo $xQty[$j] ?></td>
                    <td><?php echo number_format($xPrice[$j], 2, '.', ',') ?></td>
                    <td><?php echo number_format($xTotal[$j], 2, '.', ',') ?></td>
                  </tr>
<?php } ?>
                </tbody>
                <tfoot>
                  <tr class="ui-bar-a">
                    <th>&nbsp;</th>
                    <th>&nbsp;เป็นเงิน</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th><?php echo number_format($xPT, 2, '.', ','); ?></th>
                    </tr>
                </tfoot>
              </table>

		</div>                       
                    </td>
                </tr>                
                <tr>
                    <td>
                   
                    <form action="QtDocFinish.php" method="post">
						<div class="input-group mb-1">
							<span class="input-group-text xBoxWh">หมายเหตุ</span>
							<input type="hidden" name="tDocNo" id="tDocNo" value="<?php echo $DocNo ?>">
                            <TEXTAREA name="tDetail" id="tDetail" class="form-control" placeholder="กรอกรายละเอียด" aria-describedby="basic-addon1"><?php echo $Detail ?></TEXTAREA>
						</div>
						<div class="input-group mb-1">
							<span class="input-group-text xBoxWh">ใบเสนอราคาตามบิล</span>
							<select name="xQT" id="xQT" class="form-select" aria-label="Default select example">
												<?php 
													for($i=0;$i<4;$i++){
														if($VL[$i] == $IsQT ){
												?>
															<option selected="selected" value="<?php echo $VL[$i] ?>"><?php echo $VL[$i] ?></option>
												<?php }else{?>
											    			<option value="<?php echo $VL[$i] ?>"><?php echo $VL[$i] ?></option>
											    <?php
														}
													}
												?>
                            </select> 
						</div>
						<div class="input-group mb-1">
							<span class="input-group-text xBoxWh">รายละเอียด</span>
							<input type="hidden" name="tDocNo" id="tDocNo" value="<?php echo $DocNo ?>">
                            <TEXTAREA name="tDetail2" id="tDetail2" class="form-control" placeholder="กรอกรายละเอียด" aria-describedby="basic-addon1"><?php echo $Detail2 ?></TEXTAREA>
						</div>
						<div class="d-grid">
							<button class="btn btn-primary" name="submit-button-1" id="submit-button-1" >บันทึก</button>
						</div>
                      </form>
                    </td>
                </tr>                
</table>

	<?php
        if($IsCancel==0 && $IsFinsh==0){
	?>
		<form action="QtCancelBill.php" method="post">
			<input type="hidden" name="tDocNo1" id="tDocNo1" value="<?php echo $DocNo ?>">
			<div class="d-grid xTb">
				<button class="btn btn-danger" name="submit-button-2" id="submit-button-2" >ยกเลิกบิล</button>
			</div>
		</form>
    <?php
		}
	?>
</body>

</html>