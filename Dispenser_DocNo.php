<?php
session_start();
require 'connect.php';
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
$xTitle = $_SESSION["xTitle"];
if($_SESSION["Area"] == "") header('location:index.html');

if( $_REQUEST["add"]== 0){
	$_SESSION["DocNo"] = "";
	$_SESSION["ItemCode"] = "";
	$_SESSION["Qty"] = "";
	$_SESSION["Price"] = "";
	$_SESSION["Detail"] = "";
}else{
	if($_REQUEST["DocNo"] != "" ) $_SESSION["DocNo"] = $_REQUEST["DocNo"];
}

if($_REQUEST["Cus_Code"] != "" ){
	$CusCode = $_REQUEST["Cus_Code"];
	$_SESSION["Cus_Code"] = $CusCode;
}

	$Area = $_SESSION["Area"];
	$CusCode = $_REQUEST["Cus_Code"];
	$DocNo = $_SESSION["DocNo"];
	$Sel = $_SESSION["Sel"];

	if($DocNo == "" || $DocNo == null ){
					$Sql1 = "SELECT COALESCE(MAX(CONVERT(SUBSTRING(DocNo,-4),UNSIGNED INTEGER)),0)+1 AS DocNo FROM br_dispenser WHERE DocNo LIKE 'D%' ORDER BY DocNo DESC LIMIT 1";
					$meQuery = mysqli_query($conn,$Sql1);
					while ($Result = mysqli_fetch_assoc($meQuery))
					{
						$DocNo = $Result["DocNo"];
					}
					$DocNo = "D" . substr(date('Ym'),2,6) . "-" . createDigit($DocNo);
	}

			$Cn = 0;
			$Sql2 = "SELECT DocNo,IsFinish,IsSave,IsCancel FROM br_dispenser WHERE DocNo = '$DocNo' AND br_dispenser.IsCancel = 0";
			
			$meQuery = mysqli_query($conn,$Sql2 );
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				$Cn++;
			}
			if($Cn == 0) {
					$Sql3 = "INSERT INTO br_dispenser (DocNo,DocDate,Cus_Code,Area_Code) ";
					$Sql3 .= " VALUES ";
					$Sql3 .= "('$DocNo',NOW(),'$CusCode','$Area')";
					mysqli_query($conn,$Sql3);
			}

			if( $_REQUEST["sel"]== 0){
				$xBack = "p2.php";
			}else{
				$xBack = "Bill04.php";
			}

			$Sql4 = "SELECT DocNo,IsFinish,IsCancel,Detail,Detail2,IsPO,IsQT,IsBV,IsST,customer.Cus_Code,CONCAT(customer.FName,' ',customer.LName) AS xName,";
			$Sql4 .= "ssName,ssLocation,ssAddress1,ssAddress2 ";
			$Sql4 .= "FROM br_dispenser ";
			$Sql4 .= "INNER JOIN customer ON br_dispenser.Cus_Code = customer.Cus_Code ";
			$Sql4 .= "WHERE DocNo = '$DocNo' AND br_dispenser.IsCancel = 0";
			
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
				
				$ssName = $Result["ssName"];
				$ssLocation = $Result["ssLocation"];
				$ssAddress1 = $Result["ssAddress1"];
				$ssAddress2 = $Result["ssAddress2"];

				$_SESSION["DocNo"] = $DocNo;
			}

			if($_SESSION["ItemCode"] != "" && $_SESSION["Price"] != ""){
				$ItemCode = $_SESSION["ItemCode"];
				//$DocNo = $_SESSION["DocNo"];
				$Qty = $_SESSION["Qty"];
				$Price = $_SESSION["Price"];
				$Total = $Qty * $Price;
				$xDetail = $_SESSION["xDetail"];
				
				$Sql5 = "INSERT br_dispenser_detail (DocNo,Item_Code,Qty,Price,Total,Detail) ";
				$Sql5 .= " VALUES ";
				$Sql5 .= "('$DocNo','$ItemCode',$Qty,$Price,$Total,'$xDetail')";
				
				$meQuery = mysqli_query($conn,$Sql5);
				
				$_SESSION["ItemCode"] = "";
				$_SESSION["Qty"] = "";
				$_SESSION["Price"] = "";
				$_SESSION["Detail"] = "";
		}
	
			$Sql6 = "SELECT br_dispenser_detail.Id,item.Item_Code,item.NameTH,br_dispenser_detail.Qty,br_dispenser_detail.Price,br_dispenser_detail.Total ";
			$Sql6 .= "FROM item ";
			$Sql6 .= "INNER JOIN br_dispenser_detail ON br_dispenser_detail.Item_Code = item.Item_Code ";
			$Sql6 .= "WHERE DocNo = '$DocNo' ";
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
			
			$VL[0]="0,ทดลองใช้";
			$VL[1]="2,คืน/เปลี่ยน";
			$VL[2]="3,ติดตั้งใหม่";
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
        <a href="Dispenser.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $Area ?> : <?= $xTitle ?></div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
    </div>

	<form action="DispenserDocFinish.php" method="post">		
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
                            <td>ขอเบิกให้</td>
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
								<a class="list-group-item list-group-item-action" href="DispenserPriceSale.php">เลือกรายการ</a>
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
          <div>
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
                    <a href="DispenserDelItem.php?DocNo=<?php echo $DocNo ?>&Id=<?php echo $xId[$j] ?>" ><img src="img/del.png" width="16" height="16" /></a>
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
						<div class="input-group mb-1">
							<span class="input-group-text xBoxWh">หมายเหตุ</span>
							<input type="hidden" name="tDocNo" id="tDocNo" value="<?php echo $DocNo ?>">
                            <TEXTAREA name="tDetail" id="tDetail" class="form-control" placeholder="กรอกรายละเอียด" aria-describedby="basic-addon1"><?php echo $Detail ?></TEXTAREA>
						</div>
						<div class="input-group mb-1">
							<span class="input-group-text xBoxWh">แผนกที่ส่งสินค้า</span>
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
							<span class="input-group-text xBoxWh">ที่อยู่ในการจัดส่ง</span>
							<select name="ssAddress" id="ssAddress"  onchange="getAddress(this.value);" class="form-select" aria-label="Default select example">
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
						<div class="input-group mb-3">
							<span class="input-group-text xBoxWh">ชื่อผู้รับ</span>
							<input type="text" name="ssName" id="ssName" value="<?php echo $ssName ?>" class="form-control" placeholder="ชื่อผู้รับ" aria-describedby="basic-addon1">
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text xBoxWh">สถานที่</span>
							<input type="text" name="ssLocation" id="ssLocation" value="<?php echo $ssLocation ?>" class="form-control" placeholder="สถานที่" aria-describedby="basic-addon1">
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text xBoxWh">ที่อยู่ 1</span>
							<input type="text" name="ssAddress1" id="ssAddress1" value="<?php echo $ssAddress1 ?>" class="form-control" placeholder="ที่อยู่ 1" aria-describedby="basic-addon1">
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text xBoxWh">ที่อยู่ 2</span>
							<input type="text" name="ssAddress2" id="ssAddress2" value="<?php echo $ssAddress2 ?>" class="form-control" placeholder="ที่อยู่ 2" aria-describedby="basic-addon1">
						</div>

					    <div class="d-grid">
							<button class="btn btn-primary" name="submit-button-1" id="submit-button-1" >บันทึก</button>
						</div>

                    </td>
                </tr>                
		</table>
	</form>

	<?php
        if($IsCancel==0 && $IsFinsh==0){
	?>
		<form action="DispenserCancelBill.php" method="post">
			<input type="hidden" name="tDocNo1" id="tDocNo1" value="<?php echo $DocNo ?>">
			<div class="d-grid xTb">
				<button class="btn btn-danger" name="submit-button-2" id="submit-button-2" >ยกเลิกบิล</button>
			</div>
		</form>
    <?php
		}
	?>

</body>
<script type="text/javascript">
		$(document).ready(function(e){
			// alert("dddd");
			LoadAddress('<?= $Area ?>','<?= $CusCode ?>');
		})

		function LoadAddress(AreaCode,CusCode) {
			var data = {
				'STATUS'   : 'LoadAddress',
				'AreaCode' : AreaCode,
				'CusCode'  : CusCode
			};
			senddata(JSON.stringify(data));
        }
		
		function getAddress(id,Area,CusCode) {
			var data = {
				'STATUS' : 'getAddress',
				'id'     : id
			};
			senddata(JSON.stringify(data));
		}
		
		function senddata(data){
			var form_data = new FormData();
			form_data.append("DATA",data);
			var URL = 'process/Dispenser_DocNo.php';
			$.ajax({
				url: URL,
				dataType: 'text',
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function(result) {
					try {
						var temp = $.parseJSON(result);
					} catch (e) {
						console.log('Error#542-decode error');
					}
					
					if (temp["status"]=='success') {
						if ((temp["form"]=='LoadAddress')) {
							$("#ssAddress").empty();
							var len = temp['rCnt'];
							// alert(len + " :: " + (Object.keys(temp).length-2));
							Str2 = "";
							for (var i = 0; i < len; i++) {
								if(i == 0){
									Str2 += "<option selected value="+temp[i]['id']+">"+temp[i]['ssName']+"</option>";
								}else{
									Str2 += "<option value="+temp[i]['id']+">"+temp[i]['ssName']+"</option>";
								}
							}
							$("#ssAddress").append(Str2);
							getAddress(temp[0]['id']);
						}else if ((temp["form"]=='getAddress')) {
							$("#ssName").val( temp[0]['ssName'] );
							$("#ssLocation").val( temp[0]['ssLocation'] );
							$("#ssAddress1").val( temp[0]['ssAddress1'] );
							$("#ssAddress2").val( temp[0]['ssAddress2'] );
						}
					}
				}
			});
		}


    </script>
</html>