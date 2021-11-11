<?php
  require '../connect.php';
  session_start();
  date_default_timezone_set("Asia/Bangkok");

	if (isset($_POST['DATA'])) {
		$data = $_POST['DATA'];
		$DATA = json_decode(str_replace('\"', '"', $data), true);
		if ($DATA['STATUS'] == 'SearchData') {
		SearchData($conn,$DATA);
		}
	}

	function SearchData($conn,$DATA){
		$Area	= $_SESSION['Area'];
		$Search	= $DATA["Search"];
		$lenSearch = strlen($Search);
		$count = 0;
		$Search =   str_replace(" ","%",$_POST["Search"]) ;

		$Sql = "SELECT customer.Cus_Code,customer.FName,customer.LName,customer.AreaCode ";
		$Sql .= "FROM customer ";
		$Sql .= "WHERE customer.AreaCode = '$Area' AND ";
		$Sql .= "( customer.Cus_Code LIKE '%$Search%' OR customer.FName LIKE '%$Search%' OR customer.LName LIKE '%$Search%' ) ";
		$Sql .= "LIMIT 5";

		//echo $Sql."<br>";
		$Search = "";
		$meQuery = mysqli_query($conn,$Sql);
		$i=0;
		while ($Result = mysqli_fetch_assoc($meQuery))
		{
			$Cus_Code[$i]	=  $Result["Cus_Code"];
			$Cus_Name[$i]	=  $Result["FName"] . " " . $Result["LName"];
			$i++;
		}

        for ($j=0;$j<$i;$j++) {
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
            // $xSql = str_replace("'","",$Sql);
            // mysqli_query($conn, "INSERT INTO log (log) VALUES ('$xSql')");
            $meQuery = mysqli_query($conn, $Sql);
            while ($Result = mysqli_fetch_assoc($meQuery)) {
                $return[$count]['xDate']		= date("d/m/Y", strtotime( $Result["xDate"] ) );
				$return[$count]['NameTH']		= $Result['NameTH'];
				$return[$count]['Qty']			= $Result['Qty'];
				$return[$count]['Unit_Name']	= $Result['Unit_Name'];
				$return[$count]['Price']		= number_format($Result["Price"], 2, '.', ',');
				$return[$count]['SumPrice']		= number_format($Result["Qty"] * $Result["Price"], 2, '.', ',');
				$return[$count]['CmsP']			= $Result['CmsP'];
				$return[$count]['WelfareP']		= $Result['WelfareP'];
                $count++;
            }
		}
		
		$return['status']	= "success";
		$return['form']		= "SearchData";
		$return['rCnt']		= $count;
		$return['Sql']		= $Sql;
		echo json_encode($return);
		mysqli_close($conn);
		die;
	}
?>