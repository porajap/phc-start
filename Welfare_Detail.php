<?php
session_start();
require 'connect.php';

	if($_SESSION["Area"] == "") header('location:index.html');

	$Area       = $_SESSION["Area"];
    $xName      = $_SESSION["xName"];
	$xDocNo     = $_REQUEST["DocNo"];
	$xDocNoAcc  = $_REQUEST["DocNoAcc"];
	$xSel       = $_REQUEST["Sel"];
    $xIsCopy     = $_REQUEST["IsCopy"];
	$xPrice     = $_REQUEST["Price"];
    $CheckT     = $_REQUEST["CheckT"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>PHC</title>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    
    <style id="custom-icon">
        .xTop1{
            margin-top: 7px;
            margin-left: 1px;
            margin-right: 1px;
        }

		.bkcolor{
			background-color: #CCD4DB;
			font-weight: 900;
		}
    </style>
</head>

<body >
	<div class="topnav">
        <a href="Welfare.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?php echo $Area ?></div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
    </div>


	<table class="table">
		<thead>
			<tr>
			<th scope="col">รายการ</th>
			<th scope="col">จำนวน</th>
			<th scope="col">ราคา</th>
			<th scope="col">เป็นเงิน</th>
			</tr>
		</thead>
		<tbody>
		<?php
		    $sumTotal = 0;

            if($xIsCopy ==0){
                $Sql = "SELECT item.NameTH,sale_detail.Qty_tmp,sale_detail.Price_tmp,sale_detail.Total_tmp
					FROM sale_detail
					INNER JOIN item ON sale_detail.Item_Code = item.Item_Code
					WHERE sale_detail.DocNo = '$xDocNo'
					ORDER BY item.NameTH ASC";
            }else{
                $Sql = "SELECT item.NameTH,sale_x_detail.Qty_tmp,sale_x_detail.Price_tmp,sale_x_detail.Total_tmp
					FROM sale_x_detail
					INNER JOIN item ON sale_x_detail.Item_Code = item.Item_Code
					WHERE sale_x_detail.DocNo = '$xDocNo'
					ORDER BY item.NameTH ASC";
            }

			
					$i=0;
					$meQuery = mysqli_query($conn, $Sql);
					while ($Result = mysqli_fetch_assoc($meQuery)) {
						echo "<tr> 
								<td class='bd-left'> ".$Result["NameTH"] . " </td> 
								<td class='bd-center'> ".number_format($Result["Qty_tmp"], 2, '.', ','). " </td> 
								<td class='bd-right'> ". number_format($Result["Price_tmp"], 2, '.', ','). " </td>
								<td class='bd-right'> ".number_format($Result["Total_tmp"], 2, '.', ','). " </td>
							</tr>";
							$sumTotal += $Result["Total_tmp"];
					}
					$sumTotal = sprintf("%.2f", $sumTotal)
		?>
		</tbody>
		<tfoot class="bkcolor">
			<tr style="height: 35px"> 
				<td colspan="3">รวมเป็นเงินทั้งสิ้น</td>  
				<td class='bd-right'> <?= number_format($sumTotal, 2, '.', ',') ?> </td>
			</tr>
		</tfoot>
	</table>

	<div>
		<h2 class="card-title">เลขที่เอกสาร : <?= $xDocNo ?></h2>
		<h2 class="card-title">เอกสารบัญชี : <?= $xDocNoAcc ?></h2>
		<h3 class="card-title">เบิกครั้งที่ : <?= $xSel ?></h3>
		<input type="hidden" class="form-control" name="xDocNo" id="xDocNo" value="<?= $xDocNo ?>">
		<input type="hidden" class="form-control" name="xSel" id="xSel" value="<?= $xSel ?>">
        <input type="hidden" class="form-control" name="CheckT" id="CheckT" value="<?= $CheckT ?>">
		<div class="input-group mb-3">
			<span class="input-group-text">$</span>
			<input name="xAmount" id="xAmount" step="any" onClick="this.select();"  type="number" class="form-control" aria-label="Amount (to the nearest dollar)" value="<?=$xPrice?>">
			
		</div>
		<div class="d-grid gap-2 xTop1">
			<button type="submit" onclick="SaveData()" class="btn btn-primary">บันทึก</button>
		</div>
	</div>

</body>
<script>

	// $( document ).ready(function() {
    //     SaveData();
	// });
	
    function SaveData() {
        var xDocNo = document.getElementById("xDocNo").value;
		var xSel = document.getElementById("xSel").value;
        var xAmount = document.getElementById("xAmount").value;
        var xCheckT = document.getElementById("CheckT").value;
        
        // alert(xSel + " / " +xDocNo + " / " + xAmount);
        var data = {
                'STATUS'    : 'SaveData',
                'xAmount'   : xAmount,
				'xSel'      : xSel,
				'xDocNo'    : xDocNo,
                'xCheckT'   : xCheckT,
            };
        senddata(JSON.stringify(data));
	}

	function senddata(data) {
        var form_data = new FormData();
        form_data.append("DATA", data);
        var URL = 'process/Welfare_Detail.php';
        // alert(data);
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
                    swal({
                        type: 'warning',
                        title: 'Something Wrong',
                        text: 'Error#542-decode error'
                    });
                }

                if (temp["status"] == 'success') {
                    if (temp["form"] == 'SaveData') {
                        swal({
                            title: 'บันทึก',
                            text: temp["msg"],
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            timer: 2000,
                            confirmButtonText: 'Ok',
                            showConfirmButton: false
                        });
                        setTimeout(function(){ 
                            window.location.href = 'Welfare.php';
                        }, 1000);
                    } 
                } else {
                    swal({
                        title: 'บันทึก',
                        text: temp["msg"],
                        type: 'error',
                        showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            timer: 2000,
                            confirmButtonText: 'Ok',
                            showConfirmButton: false
                    });
                }

            },
            failure: function(result) {
                alert(result);
            },
            error: function(xhr, status, p3, p4) {
                var err = "Error " + " " + status + " " + p3 + " " + p4;
                if (xhr.responseText && xhr.responseText[0] == "{ ")
                    err = JSON.parse(xhr.responseText).Message;
                console.log(err);
            }
        });
    }
</script>
</html>
