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

	$Area = $_SESSION["Area"];
	$xBack = $_SESSION["xBack"];
	$xTitle = $_SESSION["xTitle"];
	$CusCode = $_REQUEST["Cus_Code"];
	$DocNo = $_SESSION["DocNo"];
	$UnitCode = $_SESSION["UnitCode"];
	//echo "1 : ".$_SESSION["DocNo"]."<br>";

	if($DocNo == "" || $DocNo == null ){
			$Sql = "SELECT COALESCE(MAX(CONVERT(SUBSTRING(DocNo,-4),UNSIGNED INTEGER)),0)+1 AS DocNo FROM saleorder WHERE  IsSave = 1 AND Area_Code = '$Area' ORDER BY DocNo DESC LIMIT 1";
			//echo $Sql."<br>";
			$meQuery = mysqli_query($conn,$Sql);
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				$DocNo = $Result["DocNo"];
			}
			if($DocNo != ""){
				$DocNo = $Area . date('Ym') ."-" . createDigit($DocNo);
			}
	}
//echo "2 : ".$_SESSION["DocNo"]."<br>";
			$Cn = 0;
			$Sql2 = "SELECT DocNo,IsFinish,IsSave,IsCancel FROM saleorder WHERE DocNo = '$DocNo'";
			$meQuery = mysqli_query($conn,$Sql2 );
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				$Cn++;
			}
			if($Cn == 0) {
					$Sql = "INSERT saleorder (DocNo,DocDate,Cus_Code,Area_Code) ";
					$Sql .= " VALUES ";
					$Sql .= "('$DocNo',NOW(),'$CusCode','$Area')";
					$meQuery = mysqli_query($conn,$Sql);
			}
			//echo "3 : $Sql <BR>";

			
			if( $_REQUEST["sel"]== 0){
				$xBack = "order.php";
			}else{
				$xBack = "BillOrder.php";
			}

			$Sql = "SELECT DocNo,IsFinish,IsCancel,Detail,IsPO,IsQT,IsBV,IsST,customer.Cus_Code,CONCAT(customer.FName,' ',customer.LName) AS xName ";
			$Sql .= "FROM saleorder ";
			$Sql .= "INNER JOIN customer ON saleorder.Cus_Code = customer.Cus_Code ";
			$Sql .= "WHERE DocNo = '$DocNo' AND saleorder.IsCancel = 0";
			//echo $Sql."<br>";

			$meQuery = mysqli_query($conn,$Sql);
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				$DocNo = $Result["DocNo"];
				$Detail = $Result["Detail"];
				$IsFinsh = $Result["IsFinish"];
				$IsCancel = $Result["IsCancel"];
				$_SESSION["Cus_Code"] = $Result["Cus_Code"];
				$CusFullName = $Result["xName"];
				$_SESSION["CusFullName"] = $CusFullName;
				$IsPO = $Result["IsPO"];
				$IsQT = $Result["IsQT"];
				$IsBV = $Result["IsBV"];
				$IsST = $Result["IsST"];
				
				$_SESSION["DocNo"] = $DocNo;
			}

			if($_SESSION["ItemCode"] != "" && $_SESSION["Price"] != ""){
			
				$ItemCode = $_SESSION["ItemCode"];
				//$DocNo = $_SESSION["DocNo"];
				$Qty = $_SESSION["Qty"];
				$Price = $_SESSION["Price"];
				$Total = $Qty * $Price;
				$xDetail = $_SESSION["xDetail"];
				
				$Sql = "INSERT INTO saleorder_detail (DocNo,Item_Code,Qty,Price,Total,Detail,Unit_Code,Send,Remain,AjQty) ";
				$Sql .= " VALUES ";
				$Sql .= "('$DocNo','$ItemCode',$Qty,$Price,$Total,'$xDetail',$UnitCode,0,$Qty,$Qty)";
				// echo $Sql;
				$meQuery = mysqli_query($conn,$Sql);
				
				$_SESSION["ItemCode"] = "";
				$_SESSION["Qty"] = "";
				$_SESSION["Price"] = "";
				$_SESSION["Detail"] = "";
				$_SESSION["UnitCode"] = "";
		}
	
			$Sql = "SELECT saleorder_detail.Id,item.Item_Code,item.NameTH,saleorder_detail.Qty,saleorder_detail.Price,saleorder_detail.Total ";
			$Sql .= "FROM item ";
			$Sql .= "INNER JOIN saleorder_detail ON saleorder_detail.Item_Code = item.Item_Code ";
			$Sql .= "WHERE DocNo = '$DocNo'";
			$Sql .= "AND item.Grp_1 = 1 ";

			//echo $Detail."<br>";
			
			$meQuery = mysqli_query($conn,$Sql);
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
				//echo $xTotal[$i]." : ".$xPT."<br>";
				$i++;
			}	
			//if($DocNo == "") header('location:p2.php');
			$VL[0]="มี/ลงวันที่";
			$VL[1]="มี/ไม่ลงวันที่";
			$VL[2]="ไม่มี";
			
			$ST[0]="ทันตกรรม";
			$ST[1]="หน่วยจ่ายกลาง";
			$ST[2]="OR ( ห้องผ่าตัด )";
			$ST[3]="เภสัชกรรม";
			$ST[4]="คลังยา";
			$ST[5]="พัสดุ";
			$ST[6]="พลาธิการ";
			$ST[7]="ห้องล้างไตทางช่องท้อง";
			$ST[8]="ฝ่ายการพยาบาล";
			$ST[9]="ฝ่ายชันสูตร";
			$ST[10]="อื่นๆ";

			
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>PHC</title>
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
        <a href="<?= $xBack ?>"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $Area ?> : <?= $xTitle ?></div>
        <div class="topnav-right">            
            <a href="Customer2.php"><img src="img/add_doc_2.png" width="30px" height="30px" /> </a>
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
	</div>

	<table>
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
                            <td>ลูกค้า</td>
                            <td><?php echo $CusFullName ?></td>
                          </tr>
                        </table>

                </td>
              </tr>              
                
              <tr>
                <td>
				<?php 
				if($IsCancel == 0 && $IsFinsh == 0){ 
				?>
					<div class="row">
						<div class="col-12">
							<div class="list-group">
								<a class="list-group-item list-group-item-action active" href="#" >[ เมนู ]</a>
								<a class="list-group-item list-group-item-action" href="PriceSale.php?sel=1">รายการที่เคยสั่งซื้อ</a>
								<a class="list-group-item list-group-item-action" href="PriceSale.php?sel=2">เลือกรายการ</a>
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
                    <th data-priority="2">ลำดับ</th>
                    <th >รายการ</th>
                    <th data-priority="1">จำนวน</th>
                    <th data-priority="3">ราคา</th>
                    <th data-priority="5">เป็นเงิน</th>
                </thead>
                <tbody>
                
 <?php 	for($j=0;$j<$i;$j++){ ?>               
                  <tr>
                    <th>
                    <?php if($IsFinsh == 0){?>
                    <a href="OrderDelItem.php?DocNo=<?php echo $DocNo ?>&amp;Id=<?php echo $xId[$j] ?>" ><img src="img/del.png" width="16" height="16" /></a>
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
                   
                    <form action="OrderDocFinish.php" method="post">
						<div class="input-group mb-3">
							<span class="input-group-text xBoxWh">เลขที่ PO / ใบสั่งซื้อ</span>
							<input type="text" name="xPO" id="xPO" value="<?php echo $IsPO ?>" class="form-control" placeholder="กรอกเลขที่ใบสั่งซื้อ" aria-describedby="basic-addon1">
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text xBoxWh">ใบเสนอราคาตามบิล</span>
							<select name="xQT" id="xQT" class="form-select" aria-label="Default select example">
                                            <option>เลือก</option>
                                        	<?php 
												for($i=0;$i<3;$i++){
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
						<div class="input-group mb-3">
							<span class="input-group-text xBoxWh">บิลใบกำกับภาษี</span>
							<select name="xBV" id="xBV" class="form-select" aria-label="Default select example">
                                            <option>เลือก</option>
                                        	<?php 
												for($i=0;$i<3;$i++){
													if($VL[$i] == $IsBV ){
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
						<div class="input-group mb-3">
							<span class="input-group-text xBoxWh">วันที่บิลใบกำกับภาษี</span>
							<input type="text" name="tDate" id="tDate"  class="form-control" placeholder="xx/xx/xxxx" aria-describedby="basic-addon1">
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text xBoxWh">แผนกที่ส่งสินค้า</span>
							<select name="xST" id="xST" class="form-select" aria-label="Default select example">
                                            <option>เลือก</option>
											<?php 
												for($i=0;$i<=10;$i++){
													if($ST[$i] == $IsST ){
											?>
                                            			<option selected="selected" value="<?php echo $ST[$i] ?>"><?php echo $ST[$i] ?></option>
                                            <?php }else{?>
                                            			<option value="<?php echo $ST[$i] ?>"><?php echo $ST[$i] ?></option>
                                            <?php
													}
												}
											?>
                            </select> 
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text xBoxWh">รายละเอียด</span>
							<input type="hidden" name="tDocNo" id="tDocNo" value="<?php echo $DocNo ?>">
                            <TEXTAREA name="tDetail" id="tDetail" class="form-control" placeholder="กรอกรายละเอียด" aria-describedby="basic-addon1"><?php echo $Detail ?></TEXTAREA>
						</div>

						<div class="d-grid">
							<button class="btn btn-primary" name="submit-button-1" id="submit-button-1" >บันทึก</button>
						</div>

                    
                      </form>
                      
                      <?php
                      		if($IsCancel==0 && $IsFinsh==0){
					  ?>
						<form action="OrderCancelBill.php" method="post">
							<input type="hidden" name="tDocNo1" id="tDocNo1" value="<?php echo $DocNo ?>">
							<div class="d-grid xTb">
								<button class="btn btn-danger" name="submit-button-2" id="submit-button-2" >ยกเลิกบิล</button>
							</div>
					  	</form>
                      <?php
							}
					   ?>
                    </td>
                </tr>                
</table>

</body>

</html>