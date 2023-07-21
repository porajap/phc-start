<?php
  require '../connect.php';
  session_start();
  date_default_timezone_set("Asia/Bangkok");

	if (isset($_POST['DATA'])) {
		$data = $_POST['DATA'];
		$DATA = json_decode(str_replace('\"', '"', $data), true);
		if ($DATA['STATUS'] == 'SearchDataSaleDoc') {
			SearchDataSaleDoc($conn,$DATA);
		}else if($DATA['STATUS'] == 'getBank'){
			getBank($conn,$DATA);
		}else if($DATA['STATUS'] == 'showDateDetail'){
			showDateDetail($conn,$DATA);
		}else if($DATA['STATUS'] == 'SearchDataSalecDocEdit'){
			SearchDataSalecDocEdit($conn,$DATA);
		}else if($DATA['STATUS'] == 'delete_detail'){
			delete_detail($conn,$DATA);
		}else if($DATA['STATUS'] == 'SearchDataSaleDoc_Modal'){
			SearchDataSaleDoc_Modal($conn,$DATA);
		}else if($DATA['STATUS'] == 'update_QtyDoc'){
			update_QtyDoc($conn,$DATA);
		}else if($DATA['STATUS'] == 'update_TxtSum'){
			update_TxtSum($conn,$DATA);
		}
	}

	function update_TxtSum($conn,$DATA){
		$DocNoP = $DATA['DocNoP'];
		$Text_totaltax = $DATA['Text_totaltax'];

		$Sql_updateQty = "UPDATE acc_delegate 
							SET acc_delegate.Sumtotal_Tax = '$Text_totaltax'
							WHERE acc_delegate.DocNo = '$DocNoP' ";
		$conn->query( $Sql_updateQty );

		$return['status']	= "success";
		$return['form']		= "update_TxtSum";
	
		echo json_encode($return);
		mysqli_close($conn);
		die;
	}

	function update_QtyDoc($conn,$DATA){
		$DocNoP = $DATA['DocNoP'];
		$Sql = "SELECT
					COUNT(acc_delegate_detail.RowId) AS Qty
				FROM
					acc_delegate_detail
				WHERE
					acc_delegate_detail.DocNo_acc_delegate = '$DocNoP' ";

		$meQuery = mysqli_query($conn, $Sql);
		$Result = mysqli_fetch_assoc($meQuery);
		$return['Qty']		= $Result['Qty'];
		$Qty		= $Result['Qty'];

		$Sql_updateQty = "UPDATE acc_delegate 
							SET acc_delegate.QtyDoc = '$Qty'
							WHERE acc_delegate.DocNo = '$DocNoP' ";
		$conn->query( $Sql_updateQty );

		$return['status']	= "success";
		$return['form']		= "update_QtyDoc";
	
		echo json_encode($return);
		mysqli_close($conn);
		die;
	}

	function getBank($conn,$DATA){

		$count = 0;

		$Sql = "SELECT
					bank.id, 
					bank.Bank, 
					bank.BankEng
				FROM
					bank
				WHERE bank.Bank <> '-'
				ORDER BY bank.Bank ASC";
		$meQuery = mysqli_query($conn, $Sql);
		while ($Result = mysqli_fetch_assoc($meQuery)) {
			$return[$count]['id']		= $Result['id'];
			$return[$count]['Bank']		= $Result['Bank'];
			$return[$count]['BankEng']		= $Result['BankEng'];
			$count++;
		}
		$return['status']	= "success";
		$return['form']		= "getBank";
		$return['rCnt']		= $count;
		echo json_encode($return);
		mysqli_close($conn);
		die;
	}

	function SearchDataSaleDoc_Modal($conn,$DATA){
		$Cus_Code	= $DATA["Cus_Code"];
		$Area	= $DATA["Area"];
		$count = 0;

		$Sql = "SELECT
					sale.DocNo,
					sale.DocNoAcc,
					sale.Cus_Code,
					customer.FName,
					sale.IsCheckIn,
						sale.Total - sale.DeductCN_Price + sale.Add_Money  AS Total,
					customer.AreaCode,
						sale.IsCopy,
						DATE_FORMAT(sale.DocDate,'%d-%m-%Y') AS DocDate 
				FROM
					sale
				INNER JOIN customer ON sale.Cus_Code = customer.Cus_Code
					WHERE sale.IsCopy = 0
				AND customer.AreaCode = '$Area'
					AND customer.Cus_Code='$Cus_Code'
					AND sale.IsCheckIn=0
					AND sale.DocNoAcc IS NOT NULL
					AND sale.Sale_Status=1
					AND sale.IsPayAcc_delegate=0
				UNION
				SELECT
					sale_x.DocNo,
					sale_x.DocNoAcc,
					sale_x.Cus_Code,
					customer.FName,
					sale_x.IsCheckIn,
						sale_x.Total - sale_x.DeductCN_Price + sale_x.Add_Money  AS Total,
					customer.AreaCode,
						sale_x.IsCopy,
						DATE_FORMAT(sale_x.DocDate,'%d-%m-%Y') AS DocDate 
					FROM
					sale_x
					INNER JOIN customer ON sale_x.Cus_Code = customer.Cus_Code
					WHERE sale_x.IsCopy <> 0
					AND customer.AreaCode = '$Area'
						AND customer.Cus_Code='$Cus_Code'
					AND sale_x.IsCheckIn=0
						AND sale_x.DocNoAcc IS NOT NULL
					AND sale_x.Sale_Status=1
					AND sale_x.IsPayAcc_delegate=0
					ORDER BY DocDate ASC";
		$meQuery = mysqli_query($conn, $Sql);
		while ($Result = mysqli_fetch_assoc($meQuery)) {
			$return[$count]['DocNo']		= $Result['DocNo'];
			$return[$count]['DocNoAcc']		= $Result['DocNoAcc'];
			$return[$count]['FName']		= $Result['FName'];
			$return[$count]['IsCheckIn']		= $Result['IsCheckIn'];
			$return[$count]['Total']		= number_format($Result['Total'],2);
			$return[$count]['Total_int']		= $Result['Total'];
			$return[$count]['IsCopy']		= $Result['IsCopy'];
			$return[$count]['DocDate']		= $Result['DocDate'];
			$count++;
		}
		$return['status']	= "success";
		$return['form']		= "SearchDataSaleDoc_Modal";
		$return['rCnt']		= $count;
		echo json_encode($return);
		mysqli_close($conn);
		die;
	}

	function SearchDataSaleDoc($conn,$DATA){
		$Cus_Code	= $DATA["Cus_Code"];
		$Area	= $DATA["Area"];
		$inputTxtSearch	= $DATA["inputTxtSearch"];
		$count = 0;

		$Sql = "SELECT
					sale.DocNo,
					sale.DocNoAcc,
					sale.Cus_Code,
					customer.FName,
					sale.IsCheckIn,
						sale.Total - sale.DeductCN_Price + sale.Add_Money  AS Total,
					customer.AreaCode,
						sale.IsCopy,
						DATE_FORMAT(sale.DocDate,'%d-%m-%Y') AS DocDate 
				FROM
					sale
				INNER JOIN customer ON sale.Cus_Code = customer.Cus_Code
					WHERE sale.IsCopy = 0
				AND customer.AreaCode = '$Area'
					AND customer.Cus_Code='$Cus_Code'
					AND sale.IsCheckIn=0
					AND sale.DocNoAcc IS NOT NULL
					AND sale.DocNoAcc LIKE '%$inputTxtSearch%'
					AND sale.Sale_Status=1
					AND sale.Cn = 0
					AND sale.IsPayAcc_delegate=0
				UNION
				SELECT
					sale_x.DocNo,
					sale_x.DocNoAcc,
					sale_x.Cus_Code,
					customer.FName,
					sale_x.IsCheckIn,
						sale_x.Total - sale_x.DeductCN_Price + sale_x.Add_Money  AS Total,
					customer.AreaCode,
						sale_x.IsCopy,
						DATE_FORMAT(sale_x.DocDate,'%d-%m-%Y') AS DocDate 
					FROM
					sale_x
					INNER JOIN customer ON sale_x.Cus_Code = customer.Cus_Code
					WHERE sale_x.IsCopy <> 0
					AND customer.AreaCode = '$Area'
						AND customer.Cus_Code='$Cus_Code'
					AND sale_x.IsCheckIn=0
						AND sale_x.DocNoAcc IS NOT NULL
						AND sale_x.DocNoAcc LIKE '%$inputTxtSearch%'
					AND sale_x.Sale_Status=1
					AND sale_x.Cn = 0
					AND sale_x.IsPayAcc_delegate=0
					";
		$meQuery = mysqli_query($conn, $Sql);
		while ($Result = mysqli_fetch_assoc($meQuery)) {
			$return[$count]['DocNo']		= $Result['DocNo'];
			$return[$count]['DocNoAcc']		= $Result['DocNoAcc'];
			$return[$count]['FName']		= $Result['FName'];
			$return[$count]['IsCheckIn']		= $Result['IsCheckIn'];
			$return[$count]['Total']		= number_format($Result['Total'],2);
			$return[$count]['Total_int']		= $Result['Total'];
			$return[$count]['IsCopy']		= $Result['IsCopy'];
			$return[$count]['DocDate']		= $Result['DocDate'];
			$count++;
		}
		$return['status']	= "success";
		$return['form']		= "SearchDataSaleDoc";
		$return['rCnt']		= $count;
		echo json_encode($return);
		mysqli_close($conn);
		die;
	}

	function SearchDataSalecDocEdit($conn,$DATA){
		$Cus_Code	= $DATA["Cus_Code"];
		$Area	= $DATA["Area"];
		$DocNoP	= $DATA["DocNoP"];
		$count = 0;

		$Sql = "SELECT
					DATE_FORMAT( acc_delegate_detail.DateDocSale, '%d-%m-%Y' ) AS DocDate,
					acc_delegate_detail.RefDocNoAcc,
					acc_delegate_detail.Sumtotal,
					acc_delegate_detail.RowId,
					acc_delegate_detail.IsCopy,
					acc_delegate.IsStatus,
					acc_delegate.IsStatusTax,
					acc_delegate.TaxPay 
				FROM
					acc_delegate_detail
					INNER JOIN acc_delegate ON acc_delegate_detail.DocNo_acc_delegate = acc_delegate.DocNo 
				WHERE
					acc_delegate_detail.DocNo_acc_delegate = '$DocNoP' 
				ORDER BY
					acc_delegate_detail.DateDocSale ASC";

		$meQuery = mysqli_query($conn, $Sql);
		$sumtotal=0;
		
		while ($Result = mysqli_fetch_assoc($meQuery)) {
			$return[$count]['DocNoAcc']		= $Result['RefDocNoAcc'];
			$return[$count]['Total']		= number_format($Result['Sumtotal'],2);
			$return[$count]['TaxPay']		= number_format($Result['TaxPay'],2);
			$return[$count]['Total_int']		= $Result['Sumtotal'];
			$return[$count]['DocDate']		= $Result['DocDate'];
			$return[$count]['RowId']		= $Result['RowId'];
			$return[$count]['IsCopy']		= $Result['IsCopy'];
			$return[$count]['IsStatus']		= $Result['IsStatus'];
			$return[$count]['IsStatusTax']		= $Result['IsStatusTax'];
			$count++;
			$sumtotal += $Result['Sumtotal']; 
		}
		$tax=0;
		$sumtotal_tax = 0;
        $tax = ($sumtotal/1.07) *1/100;

        $sumtotal_tax = $sumtotal - $tax;

		$Sql_acc_delegate = "UPDATE acc_delegate 
							SET acc_delegate.TaxPay = '$sumtotal_tax',
								acc_delegate.Sumtotal = '$sumtotal'
							WHERE acc_delegate.DocNo = '$DocNoP' ";
		$conn->query( $Sql_acc_delegate );

		$return['Sumtotal']	= number_format($sumtotal,2);
		$return['Sumtotal_tax']	= number_format($sumtotal_tax,2);
		$return['status']	= "success";
		$return['form']		= "SearchDataSalecDocEdit";
		$return['rCnt']		= $count;
		echo json_encode($return);
		mysqli_close($conn);
		die;
	}

	function showDateDetail($conn,$DATA){
		$DocNoP	= $DATA["DocNoP"];
		$count = 0;

		$Sql = "SELECT
				acc_delegate.RowId, 
				acc_delegate.DocNo, 
				acc_delegate.Ispay, 
				acc_delegate.Sumtotal, 
				acc_delegate.img_slip, 
				acc_delegate.Bank, 
				acc_delegate.branch_Bank, 
				DATE_FORMAT(acc_delegate.dateBank,'%d-%m-%Y') AS dateBank,
				acc_delegate.img_tax, 
				acc_delegate.TaxPay, 
				acc_delegate.Sumtotal_Tax, 
				acc_delegate.TaxType,
				acc_delegate.IsStatusTax,
				acc_delegate.IsStatus,
				acc_delegate.check_number
				FROM
				acc_delegate
				WHERE acc_delegate.DocNo='$DocNoP' ";

		$meQuery = mysqli_query($conn, $Sql);
		while ($Result = mysqli_fetch_assoc($meQuery)) {
			$return[$count]['RowId']		= $Result['RowId'];
			$return[$count]['DocNo']		= $Result['DocNo'];
			$return[$count]['Ispay']		= $Result['Ispay'];
			$return[$count]['Sumtotal']		= $Result['Sumtotal'];
			$return[$count]['img_slip']		= $Result['img_slip'];
			$return[$count]['Bank']	= $Result['Bank'];
			$return[$count]['branch_Bank']		= $Result['branch_Bank'];
			$return[$count]['img_tax']		= $Result['img_tax'];
			$return[$count]['TaxPay']		= $Result['TaxPay'];
			$return[$count]['Sumtotal_Tax']		= $Result['Sumtotal_Tax'];
			$return[$count]['TaxType']		= $Result['TaxType'];
			$return[$count]['dateBank']		= $Result['dateBank'];
			$return[$count]['IsStatus']		= $Result['IsStatus'];
			$return[$count]['IsStatusTax']		= $Result['IsStatusTax'];
			$return[$count]['check_number']		= $Result['check_number'];
			$count++;
		}
		$return['status']	= "success";
		$return['form']		= "showDateDetail";
		$return['rCnt']		= $count;
		echo json_encode($return);
		mysqli_close($conn);
		die;
	}

	function delete_detail($conn,$DATA)
	{
		$RowId = $DATA['RowId'];
		$IsCopy = $DATA['IsCopy'];

		$Sql = "SELECT
					acc_delegate_detail.RefDocNoAcc,
					acc_delegate_detail.DocNo_acc_delegate
				FROM
				acc_delegate_detail
				WHERE acc_delegate_detail.RowId = '$RowId'
				";
		$meQuery = mysqli_query($conn, $Sql);
		$Result = mysqli_fetch_assoc($meQuery);
		$RefDocNoAcc = $Result['RefDocNoAcc'];
		$DocNo_acc_delegate = $Result['DocNo_acc_delegate'];
	

		$query = "DELETE FROM acc_delegate_detail WHERE RowId ='$RowId'";
		mysqli_query($conn, $query);

		if($IsCopy>'0'){
			$Sql_updatebill = "UPDATE sale_x 
								SET sale_x.IsPayAcc_delegate = '0'
								WHERE sale_x.DocNoAcc = '$RefDocNoAcc' ";
			$conn->query( $Sql_updatebill );
		}else{
			$Sql_updatebill = "UPDATE sale 
								SET sale.IsPayAcc_delegate = '0'
								WHERE sale.DocNoAcc = '$RefDocNoAcc' ";
			$conn->query( $Sql_updatebill );
		}

		$SqlUpdateSum = "SELECT
								SUM(acc_delegate_detail.Sumtotal) AS Sumtotal
							FROM
								acc_delegate_detail
								INNER JOIN acc_delegate ON acc_delegate_detail.DocNo_acc_delegate = acc_delegate.DocNo 
							WHERE
								acc_delegate_detail.DocNo_acc_delegate = '$DocNo_acc_delegate' 
								GROUP BY  acc_delegate.DocNo 
						";

		$meQueryUpdateSum  = mysqli_query($conn, $SqlUpdateSum );
		$ResultUpdateSum  = mysqli_fetch_assoc($meQueryUpdateSum );
		$Sumtotal2 = $ResultUpdateSum['Sumtotal'];

		$sumtotal_tax = 0;
        $tax = ($Sumtotal2/1.07) *1/100;

        $sumtotal_tax = $Sumtotal2 - $tax;


			$Sql_update_sumtotal = "UPDATE acc_delegate 
									SET acc_delegate.Sumtotal = '$Sumtotal2',
										acc_delegate.TaxPay = '$sumtotal_tax',
										acc_delegate.Sumtotal_Tax = '$tax'
									WHERE acc_delegate.DocNo = '$DocNo_acc_delegate' ";
			$conn->query( $Sql_update_sumtotal );

	$return['status']	= "success";
	$return['form']		= "delete_detail";
	echo json_encode($return);
	mysqli_close($conn);
	die;
	}

?>