<?php
session_start();
require 'connect.php';

	if($_SESSION["Area"] == "") header('location:index.html');

	$Area       = $_SESSION["Area"];
    $xName      = $_SESSION["xName"];
	$Cus_Code     = $_REQUEST["Cus_Code"];

function Chkbox($id,$Val,$iCode){
    if($Val == 0)
        $Str = "<input type='checkbox' class='form-check-input' id='v$id' value='$iCode' onclick='UpdateItem($id,1);' checked>";
    else
        $Str = "<input type='checkbox' class='form-check-input' id='v$id' value='$iCode' onclick='UpdateItem($id,0);' >";
    return $Str;
}

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
        <a href="CustomerSel.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?php echo $Area ?>:<?php echo $xName ?></div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
    </div>

	<table class="table">
		<thead>
			<tr>
			<th scope="col">รายการ</th>
			<th scope="col" align="right" >ยกเลิก</th>
			</tr>
		</thead>
		<tbody>
		<?php
		    
            $Sql = "SELECT item.Item_Code,item.NameTH,itemorder.isHidden
                    FROM itemorder
                    INNER JOIN item ON item.Item_Code = itemorder.ItemCode 
                    WHERE itemorder.AreaCode = '$Area' 
                    AND itemorder.CusCode = '$Cus_Code' 
                    AND item.IsCancel = 0 
                    AND item.IsSale = 1
                    ORDER BY item.NameTH ASC";
					$i=0;
					$meQuery = mysqli_query($conn, $Sql);
					while ($Result = mysqli_fetch_assoc($meQuery)) {
						echo "<tr> 
								<td class='bd-left'> ".$Result["NameTH"] . " </td> 
								<td align='right'> ". Chkbox($i,$Result["isHidden"],$Result["Item_Code"]) . " </td>
							</tr>";
                            $i++; //$Result["Item_Code"]
					}
		?>
		</tbody>
	</table>

</body>
<script type = "text/javascript">

	// $( document ).ready(function() {
    //     SaveData();
	// });
	
    function UpdateItem(i,val) {
        var iCode = $("#v"+i).val();
        // alert("v"+i+','+val+'::'+iCode);
        var data = {
                'STATUS'    : 'SaveData',
                'iCode'     : iCode,
				'val'       : val,
                'CusCode'   : <?= $Cus_Code; ?>,
            };
        senddata(JSON.stringify(data));
    }

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
        var URL = 'process/ProductHidden.php';
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
                            timer: 1000,
                            confirmButtonText: 'Ok',
                            showConfirmButton: false
                        });
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
