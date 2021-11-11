<?php
session_start();
require 'connect.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
	$Area = $_SESSION["Area"];
	$Cus_Code = $_SESSION["Cus_Code"];
	$Cus_Name =$_SESSION["Cus_Name"];
	$xMonth = $_POST["xMonth"];
	$xYear = $_POST["xYear"];
	$xMonth2 = $_POST["xMonth1"];
	$xYear2 = $_POST["xYear1"];
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
    <link rel="stylesheet" href="css/hr.css">
    <link rel="stylesheet" href="css/all.css">
    <script src="js/jquery/3.5.1/jquery.min.js "></script>
    <script src="assets/dist/js/bootstrap.js "></script>
    <script src="assets/dist/js/bootstrap.bundle.min.js "></script>
    <script src="assets/dist/js/sweetalert2.min.js"></script>
</head>

<body>
	<!-- <input type="hidden" id="xMonth1" value="<?= $xMonth ?>">
	<input type="hidden" id="xMonth2" value="<?= $xMonth2 ?>">
	<input type="hidden" id="xYear1" value="<?= $xYear ?>">
	<input type="hidden" id="xYear2" value="<?= $xYear2 ?>">
	<input type="hidden" id="Cus_Code" value="<?= $Cus_Code ?>"> -->

	<div class="topnav">
        <a href="Date02.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $Area ?> : <?= $Cus_Name ?></div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
	</div>
	<div class="row xTop1">
        <div class="col">
            <label for="inputTxt1" class="visually-hidden">Search</label>
            <input type="Text" class="form-control" id="inputTxt1" placeholder="ค้นหา">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" onclick="SearchData()">ค้นหา</button>
        </div>
    </div>

    <div id="Sql"></div>
    <div id="Grid1"></div>

</body>
<script>
    $( document ).ready(function() {
        SearchData();
    });
    
    function SearchData() {
        // var d = new Date();
        // var gMonth = d.getMonth();
        // var gYear = d.getFullYear();
		var iTxt1 = document.getElementById("inputTxt1").value;
		var gMonth1 = <?= $xMonth ?>; //document.getElementById("xMonth1").value;
		var gMonth2 = <?= $xMonth2 ?>; //document.getElementById("xMonth2").value;
		var gYear1 = <?= $xYear ?>; //document.getElementById("xYear1").value;
		var gYear2 = <?= $xYear2 ?>; //document.getElementById("xYear2").value;
		var Cus_Code = <?= $Cus_Code ?>; //document.getElementById("Cus_Code").value;
		// alert( Cus_Code+" :: "+gMonth1+"/"+gYear1+" :: "+gMonth2+"/"+gYear2 );
        var data = {
                'STATUS'    : 'SearchData',
                'Search'    : iTxt1,
                'sMonth1'	: gMonth1,
				'sYear1'	: gYear1,
				'sMonth2'	: gMonth2,
				'sYear2'	: gYear2,
				'Cus_Code'	: Cus_Code
            };
        senddata(JSON.stringify(data));
    }

    function senddata(data) {
        var form_data = new FormData();
        form_data.append("DATA", data);
        var URL = 'process/Bill.php';
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
                    if (temp["form"] == 'SearchData') {
                        swal({
                            title: 'ค้นหา',
                            text: 'พบรายการทั้งหมด '+temp["rCnt"] + ' รายการ',
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            timer: 2000,
                            confirmButtonText: 'Ok',
                            showConfirmButton: false
						});

						var sBill = "";
                        var Str = '<div class="row"> <div class="col-12"> <div class="list-group">';
                        for (var i = 0; i < temp["rCnt"]; i++) {
							if(temp[i]["IsCheckIn"] == 1){
								sBill = '<img src="img/success-1.png" width="25" height="25" /> ชำระแล้ว';
							}else{
								sBill = '<img src="img/unsuccess-1.png" width="25" height="25" /> ค้างชำระ';
							}
                                    Str += '<a class="list-group-item list-group-item-action" href="Price2.php?DocNo='+temp[i]["DocNo"]+'">' +
														'<div class="input-group">' +
															'<span class="input-group-text xBoxWh">เลขที่เอกสาร</span>' +
															'<div class="form-control" aria-describedby="basic-addon1">'+temp[i]["DocNo"]+'  '+sBill+'</div>' +
														'</div>' +
														'<div class="input-group">' +
															'<span class="input-group-text xBoxWh">วันที่เอกสาร</span>' +
															'<div class="form-control" aria-describedby="basic-addon1">'+temp[i]["DocDate"]+'</div>' +
														'</div>' +
														// '<div class="input-group">' +
														// 	'<span class="input-group-text xBoxWh">ชื่อลูกค้า</span>' +
														// 	'<div class="form-control" aria-describedby="basic-addon1">'+temp[i]["FName"]+'</div>' +
														// '</div>' +
                                            '</a>';
						}
                        Str += "</div></div></div>";

                        $("#Sql").html(temp["Sql"]);
                        $("#Grid1").html(Str);
                    } 
                } else {
                    swal({
                        title: 'Something Wrong',
                        text: temp["msg"],
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ok'
                    }).then(function() {

                    }, function(dismiss) {
                        // dismiss can be 'cancel', 'overlay',
                        // 'close', and 'timer'
                        if (dismiss === 'cancel') {

                        }
                    })
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
