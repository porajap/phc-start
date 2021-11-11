<?php
session_start();
require 'connect.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
$Area = $_SESSION["Area"];
	$Search =   str_replace(" ","%",$_POST["inputTxt1"]) ;

	$Sql = "SELECT customer.Cus_Code,customer.FName,customer.LName,customer.AreaCode ";
	$Sql .= "FROM customer ";
	$Sql .= "WHERE customer.AreaCode = '$Area' AND ";
	$Sql .= "( customer.Cus_Code LIKE '%$Search%' OR customer.FName LIKE '%$Search%' OR customer.LName LIKE '%$Search%' ) ";
	$Sql .= "LIMIT 5";
	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$Cus_Code[$i]	=  $Result["Cus_Code"];
		$Cus_Name[$i]	=  $Result["FName"] . " " . $Result["LName"];
		$i++;
	}
	// echo $Sql."<br>";
	$Search = "";
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
	

	<form action="SelCustomer.php" method="post">
		<div class="row xTop1">
			<div class="col">
				<label for="inputTxt1" class="visually-hidden">Search</label>
				<input type="Text" class="form-control" id="inputTxt1" name="inputTxt1" placeholder="ค้นหา">
			</div>
			<div class="col-auto">
				<button type="submit" class="btn btn-primary mb-3" onclick="SearchData()">ค้นหา</button>
			</div>
		</div>
	</form>
	<div class="overflow-auto">
		<table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th data-priority="2">ลำดับ</th>
                    <th>ชื่อลูกค้า</th>
                  </tr>
                </thead>
                <tbody>
                
 <?php 	for($j=0;$j<$i;$j++){ ?>               
                  <tr>
                    <th><?php echo $j+1 ?></th>
                    <td>
						<?php echo $Cus_Code[$j] ?> : <?php echo $Cus_Name[$j] ?>
                    </td>
                  </tr>
                  <tr>
                    <th>-</th>
                    <td>  
<?php   
			$Sql = "SELECT dallycall.Id,dallycall.DocNo,dallycall.xDate,";
			$Sql .= "CONCAT(customer.FName,' ',customer.LName) AS xName,";
			$Sql .= "item.Item_Code,item.NameTH,dallycall.Qty,dallycall.Price,";
			$Sql .= "item_unit.Unit_Name,dallycall.Total,";
			$Sql .= "dallycall.DiscountP,dallycall.DiscountB,dallycall.VatB,";
			$Sql .= "dallycall.CmsP,dallycall.CmsB,dallycall.Total2,";
			$Sql .= "dallycall.WelfareP,dallycall.WelfareB,dallycall.Total3,";
			$Sql .= "dallycall.DallyP,dallycall.DallyB,contact.CT_Name,";
			$Sql .= "dallycall.BonusItemCode,dallycall.AreaCode2 ";
			$Sql .= "FROM dallycall ";
			$Sql .= "INNER JOIN item ON dallycall.ItemCode = item.Item_Code ";
			$Sql .= "INNER JOIN customer ON dallycall.Cus_Code = customer.Cus_Code ";
			$Sql .= "INNER JOIN sale ON dallycall.DocNo = sale.DocNo ";
			$Sql .= "INNER JOIN contact ON dallycall.CT_Code = contact.CT_Code ";
			$Sql .= "INNER JOIN item_unit ON item.Unit_Code = item_unit.Unit_Code ";
			$Sql .= "WHERE customer.Cus_Code = '$Cus_Code[$j]' ";
			$Sql .= "AND dallycall.AreaCode = '$Area' ";
			$Sql .= "AND dallycall.AreaCode2 = '-' ";
			$Sql .= "AND dallycall.IsCancel = 0 ";
			$Sql .= "AND sale.IsCancel = 0 ";
			$Sql .= "GROUP BY item.Item_Code ";
			$Sql .= "ORDER BY dallycall.xDate DESC";
	
			$meQuery = mysqli_query($conn,$Sql);

			echo "<table class='table'>";
			echo "<thead class='thead-dark'>";
			echo "<tr>";
            echo " <th>ว/ด/ป</th>";
			echo " <th>รายการ</th>";
			echo " <th>จำนวน</th>";
			echo " <th>หน่วยนับ</th>";
			echo " <th>ราคา</th>";
			echo " <th>เป็นเงิน</th>";
			echo " <th>หักสวัสดิการ</th>";
			echo " <th>เข้ายอด</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				echo "<tr>";
				echo "<td> " . date("d/m/Y", strtotime( $Result["xDate"] ) ) . " </td>";
				echo "<td> " . $Result["NameTH"] . " </td>";
				echo "<td align='center'> " . $Result["Qty"] . " </td>";
				echo "<td align='center'> " . $Result["Unit_Name"] . " </td>";
				echo "<td align='right'> " . number_format($Result["Price"], 2, '.', ',') . " </td>";
				echo "<td align='right'> " . number_format($Result["Qty"] * $Result["Price"], 2, '.', ',')  . " </td>";
				echo "<td align='right'> " . $Result["CmsP"]  . "% </td>";
				echo "<td align='right'> " . $Result["WelfareP"]  . "% </td>";
				echo "</tr>";
				
			} 
			echo "</tbody>";
			echo "</table>";  
		
	                 
?>              
          
          		</td>
             </tr>
                  
<?php } ?>
                </tbody>
        </table>
	</div>

</body>

</html>
