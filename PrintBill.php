<?php
session_start();
require 'connect.php';
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

if($_SESSION["Area"] == "") header('location:index.html');

	$Area = $_SESSION["Area"];
	$CusCode = $_SESSION["Cus_Code"];
	$DocNo = $_SESSION["DocNo"];


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

			if($_SESSION["ItemCode"] != "" && $_SESSION["Qty"] && $_SESSION["Price"]){
				$ItemCode = $_SESSION["ItemCode"];
				//$DocNo = $_SESSION["DocNo"];
				$Qty = $_SESSION["Qty"];
				$Price = $_SESSION["Price"];
				$Total = $Qty * $Price;
				$xDetail = $_SESSION["xDetail"];
				
				$Sql5 = "INSERT saleorder_sale_detail (DocNo,Item_Code,Qty,Price,Total,Detail) ";
				$Sql5 .= " VALUES ";
				$Sql5 .= "('$DocNo','$ItemCode',$Qty,$Price,$Total,'$xDetail')";
				
				$meQuery = mysqli_query($conn,$Sql5);
				
				$_SESSION["ItemCode"] = "";
				$_SESSION["Qty"] = "";
				$_SESSION["Price"] = "";
				$_SESSION["Detail"] = "";
		}
	
			$Sql6 = "SELECT item.Item_Code,item.NameTH,saleorder_sale_detail.Qty,saleorder_sale_detail.Price,saleorder_sale_detail.Total ";
			$Sql6 .= "FROM item ";
			$Sql6 .= "INNER JOIN saleorder_sale_detail ON saleorder_sale_detail.Item_Code = item.Item_Code ";
			$Sql6 .= "WHERE DocNo = '$DocNo'";
			$Sql6 .= "AND item.Grp_1 = 1 ";
			
			$meQuery = mysqli_query($conn,$Sql6);
			$i=0;
			$xPT = 0.00;
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
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
			$VL[2]="ATTN";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="tHeader.css" rel="stylesheet" type="text/css">
    </head>
        <style >
		.xHeader {
	color: #000;
	background-color: #FFF;
	font-family: Tahoma;
	font-size: 18px;
	font-weight: bold;
			}
			.tHeader {
	color: #FFF;
	font-family: Tahoma;
	font-size: small;
	font-weight: bold;
			}
			.tBody{
	font-family: Tahoma;
	font-size: small;
			}
			.tBody_B{
	font-family: Tahoma;
	font-size: small;
	font-weight: bold;
	color: #000;
			}
			.tBody_s{
	font-family: Tahoma;
	font-size: x-small;
	font-weight: normal;
	color: #000;
			}
			.tPrice_B{
	font-family: Tahoma;
	font-size: small;
	font-weight: bold;
			}
			.BD_Color{
   				border: 1px solid black;
			}		
			.TD_LineColor01{
	border-color: black;
	background-image: url(imgs/Line01.png);
	font-family: Tahoma;
	font-size: small;
			}	
			.TD_LineColor02{
	border-color: black;
	background-image: url(imgs/Line02.png);
			}
		</style>

<body onload="window.print();window.close();">

<?php 
	$Row = 0;
	for($i=1;$i<=$xPage;$i++){ 
?>
<table width="500" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td align="center" valign="top">
    	<table width="100%" border="0" cellpadding="0" cellspacing="0">
           <tr>
             <td align="center"></td>
             <td align="right" valign="top"><span class="tBody">
               <?php echo $i ?>/<?php echo $xPage ?>
             </span></td>
           </tr>
           <tr>
    	    <td colspan="2" align="center"><span class="xHeader">&nbsp;</span></td>
  	      </tr>
    	  <tr>
    	    <td colspan="2" align="center" class="tBody_s">&nbsp;</td>
  	    </tr>
    	  <tr>
    	    <td colspan="2" align="center" class="tBody_s">&nbsp;</td>
  	    </tr>
    	  <tr>
    	    <td colspan="2" align="center" class="tBody_s">&nbsp;</td>
  	    </tr>
      </table>
    </td>
  </tr>
    <tr>
    <td  height="100px" valign="top">
   	  <table width="100%" border="0" height="100px">
    	  <tr class="BD_Color">
    	    <td width="57%" valign="top"><table width="100%" border="0" cellpadding="2" cellspacing="1" class="BD_Color">
    	      <tr>
    	        <td width="26%" align="right" valign="top" class="tBody">&nbsp;</td>
    	        <td valign="top" class="tBody"><?php echo $zzz ?></td>
   	          </tr>
    	      <tr>
    	        <td align="right" valign="top" class="tBody">&nbsp;</td>
    	        <td valign="top" class="tBody"><?php echo $zzz ?></td>
   	          </tr>
    	      <tr>
    	        <td align="right" valign="top" class="tBody">&nbsp;</td>
    	        <td valign="top" class="tBody"><?php echo $zzz ?></td>
   	          </tr>
  	      </table></td>
    	    <td width="43%" valign="top">&nbsp;</td>
  	    </tr>
  	  </table></td>
  </tr>
  <tr>
    <td  height="370px" valign="top">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr bgcolor="#333333" class="tHeader">
    <td width="8%" height="24" align="center">ลำดับ</td>
    <td width="21%">บาร์โค้ด</td>
    <td width="36%">รายการ</td>
    <td width="11%" align="center">จำนวน</td>
    <td width="10%" align="right">ราคา</td>
    <td width="14%" align="right">เป็นเงิน</td>
  </tr>

  <?php
	for($j=$Row;$j<(20*$i);$j++){ 
		if($j < $xRowNow){
  ?>
  <tr class="TD_LineColor01">
    <td height="19" align="center"><?php echo ($j+1) ?></td>
    <td height="19">&nbsp;<?php echo $xBarcode[$j] ?></td>
    <td height="19">&nbsp;<?php echo $xItemName[$j] ?></td>
    <td height="19" align="center">&nbsp;<strong><?php echo $xQty[$j] ?></strong></td>
    <td height="19" align="right">&nbsp;<?php echo $xPrice[$j] ?></td>
    <td height="19" align="right">&nbsp;<?php echo $xTotal[$j] ?></td>
  </tr>
  <?php 
		}
	}
  	$Row=$j;
	if($i == $xPage){
  ?>
  <tr class="tPrice_B">
    <td width="8%" height="24" align="center">&nbsp;</td>
    <td width="21%" height="24">&nbsp;</td>
    <td height="24" colspan="2" align="right"><span class="tBody_B">รวมเป็นเงินทั้งสิ้น :</span></td>
    <td height="24" colspan="2" align="right" class="TD_LineColor02" ><span class="tBody_B">
      <?php echo $xSumTotal ?>
    </span></td>
    </tr>
<?php }else{ ?>
  <tr class="tPrice_B">
    <td width="8%" height="24" align="center">&nbsp;</td>
    <td width="21%" height="24">&nbsp;</td>
    <td height="24" colspan="2" align="right">&nbsp;</td>
    <td height="24" colspan="2" align="right">&nbsp;</td>
    </tr>
<?php } ?>
    </table>

    </td>
  </tr>
  <tr>
  
    <td  valign="top">
    
       <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="tBody">( ............................ )</span></td>
            <td align="center"><span class="tBody">( ............................ )</span></td>
            <td align="right"><span class="tBody">( ............................. )</span></td>
          </tr>
          <tr valign="bottom" class="tBody_B">
            <td height="30">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $xEName ?>            </td>
            <td align="center"><span class="tBody">..............................</span></td>
            <td align="right"><span class="tBody">..............................&nbsp;&nbsp;</span></td>
          </tr>
          <tr>
            <td><span class="tBody_B">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;ผู้บันทึก</span></td>
            <td align="center"><span class="tBody_B">ผู้ตรวจสอบ</span></td>
            <td align="right"><span class="tBody_B">ผู้รับสินค้า&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; </span></td>
          </tr>
          <tr>
            <td align="center"><?php echo date("d/m/Y H:i:s") ?></td>
            <td align="center">&nbsp;</td>
            <td align="right">&nbsp;</td>
         </tr>
      </table>

    </td>
  </tr>
</table>

<?php } ?>

</body>
</html>