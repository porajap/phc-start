<?php
session_start();
require 'connect.php';
	if($_SESSION["Area"] == "") header('location:index.html');
	$Area 	= $_SESSION["Area"];
	$xTitle = $_SESSION["xName"];
    $Cus_Code = $_REQUEST["Cus_Code"];
    $CusName = $_REQUEST["CusName"];
	$xAdd	= 0;
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
	<script src="js/jquery/3.5.1/jquery.min.js "></script>
	<script src="assets/dist/js/bootstrap.js "></script>
	<script src="assets/dist/js/bootstrap.bundle.min.js "></script>
    <script src="assets/dist/js/sweetalert2.min.js"></script>
    <style>
        .xTop1{
            margin-top: 7px;
            margin-left: 1px;
            margin-right: 1px;
        }

        .xTb{
            margin-top: 7px;
            margin-left: 1px;
            margin-right: 1px;
            margin-bottom: 7px;
        }

        .label1{
            margin-left: 10px;
            margin-top: 7px;
        }

        .label2{
            margin-left: 10px;
            margin-top: 1px;
            margin-bottom: 3px;
            font-size:17px;
        }
        .label3{
            margin-left: 10px;
            margin-top: 1px;
            margin-bottom: 3px;
            font-size:19px;
        }

		.caption div {
			box-shadow: 0 0 5px #C8C8C8;
			transition: all 0.3s ease 0s;
		}
		.img-circle {
			border-radius: 50%;
		}
		.img-circle {
			border-radius: 0;
		}

		.ratio {
			background-position: center center;
			background-repeat: no-repeat;
			background-size: cover;

			height: 0;
			padding-bottom: 15%;
			position: relative;
			width: 15%;
		}
		.img-circle {
			border-radius: 50%;
		}
		.img-responsive {
			display: block;
			height: auto;
			max-width: 15%;
		}

    </style>
</head>

<body>
	<div class="topnav">
        <a href="CustomerSel.php?Menu=2"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $Area ?> : <?= $xTitle ?> | ลูกค้า รหัส : <?= $Cus_Code ?>  : <?= $CusName ?></div>
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
            <button type="submit" class="btn btn-primary mb-3" onclick="createDoc();">สร้างเอกสารจ่าย</button>
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
        var d = new Date();
        var gMonth = d.getMonth();
        var gYear = d.getFullYear();
		var xAdd = 0;
        var Cus_Code =   <?= $Cus_Code ?>;
        var iTxt1 = document.getElementById("inputTxt1").value;
        // alert(xMenu +"_"+ xAdd + " / " +gMonth+ "-" +gYear);
        var data = {
                'STATUS'    : 'SearchData',
                'Search'    : iTxt1,
                'SelMonth'  : gMonth,
				'SelYear'   : gYear,
				'xAdd'		: xAdd,
                'Cus_Code'		: Cus_Code,
            };
        senddata(JSON.stringify(data));
    }

    function createDoc() {
     var Cus_Code =   <?= $Cus_Code ?>;
     var CusName =   '<?= $CusName ?>';

        location.href="CustomerSel_CreatcDoc.php?Cus_Code="+Cus_Code+"&CusName="+CusName+"&IsStatus=0&DocNoP=0";
    }


    

    function senddata(data) {
        var form_data = new FormData();
        form_data.append("DATA", data);
        var URL = 'process/CustomerSel_DocDetail.php';
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

                        var Str = '<div class="row"> <div class="col-12"> <div class="list-group">';
                        for (var i = 0; i < temp["rCnt"]; i++) {
                            var Cus_Code =   <?= $Cus_Code ?>;
                            var CusName =   '<?= $CusName ?>';

                            if(temp[i]["IsStatus"]=='1'){
                                var IsStatus ='รอการอนุมัติ';
                                Style = "style='color: #FF6633;text-align:left;'";
                            }else if(temp[i]["IsStatus"]=='2'){
                                var IsStatus ='อนุมัติเรียบร้อยแล้ว';
                                Style = "style='color: #20B80E;text-align:left;'";
                            }else{
                                var IsStatus ='ไม่อนุมัติโปรดทำการแก้ไข';
                                Style = "style='color: #FF0000;text-align:left;'";
                            }

                            if(temp[i]["IsStatusTax"]=='1'){
                                var IsStatusTax ='รอการอนุมัติ';
                                StyleTax = "style='color: #FF6633;text-align:left;'";
                            }else if(temp[i]["IsStatusTax"]=='2'){
                                var IsStatusTax ='อนุมัติเรียบร้อยแล้ว';
                                StyleTax = "style='color: #20B80E;text-align:left;'";
                            }else{
                                var IsStatusTax ='ไม่อนุมัติโปรดทำการแก้ไข';
                                StyleTax = "style='color: #FF0000;text-align:left;'";
                            }

                                    Str += '<a class="list-group-item list-group-item-action" href="CustomerSel_CreatcDoc.php?Cus_Code='+Cus_Code+'&CusName='+CusName+'&IsStatus='+temp[i]["IsStatus"]+'&DocNoP='+temp[i]["DocNo"]+'">' +
                                                '<div class="card"' +
                                                    '<div class="card-body">' +
                                                        '<h5 class="card-title label1">เลขที่เอกสาร : '+temp[i]["DocNo"]+'</h5>'+
                                                        '<p class="card-text label2">วันที่เอกสาร : '+temp[i]["DocDate"]+' </p>'+
                                                        '<p class="card-text label2">ชื่อลูกค้า : '+temp[i]["CusName"]+' เขต : '+temp[i]["AreaCode"]+'</p>'+
                                                        '<p class="card-text label2">จำนวนบิลที่จ่าย : '+temp[i]["QtyDoc"]+' </p>'+
                                                        '<p class="card-text label3">สถานะ Pay In/Slip : <span '+Style+'>'+IsStatus+'</span> | สถานะภาษี : <span '+StyleTax+'>'+IsStatusTax+'</span> </p>';
                                            
                                                        Str += '</div>' +
                                                '</div>' +
                                            '</a>';
						}
                        Str += "</div></div></div>";

						// var link = "";
                        // var Str = '<div class="row"> <div class="col-12"> <div class="list-group">';
						
						// for (var i = 0; i < temp["rCnt"]; i++) {
							
						// 			// switch(temp["xMenu"]){
						// 			// 	case 1: link="ProductHidden.php?Cus_Code="+temp[i]["Cus_Code"];break;
                        //             //     case 2: link="UploadCheck.php?Cus_Code="+temp[i]["Cus_Code"];break;
						// 			// }

                        //             Str += '<a class="list-group-item list-group-item-action" href="'+link+'">' +
						// 						'<div class="card"' +
						// 							'<div class="card-body">' +
						// 								'<h5 class="card-title label2">รหัสลูกค้า : '+temp[i]["Cus_Code"]+
						// 								'<p class="card-text label2">ชื่อลูกค้า : '+temp[i]["CusName"]+'</p>'+
						// 								// '<p>'+link+'</p>'+
						// 							'</div>' +
						// 						'</div>' +
                        //                     '</a>';
						// }
                        // Str += "</div></div></div>";

                        // $("#Sql").html(temp["Sql"]);
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
