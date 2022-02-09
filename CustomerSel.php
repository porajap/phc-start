<?php
session_start();
require 'connect.php';
	if($_SESSION["Area"] == "") header('location:index.html');
	$Area 	= $_SESSION["Area"];
	$xTitle = $_SESSION["xName"];
	$xMenu	= $_REQUEST["Menu"];
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
            margin-top: 7px;
            margin-bottom: 7px;
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
        <a href="p2.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $Area ?> : <?= $xTitle ?></div>
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
        var d = new Date();
        var gMonth = d.getMonth();
        var gYear = d.getFullYear();
		var xMenu = <?= $xMenu ?>;
		var xAdd = 0;
        var iTxt1 = document.getElementById("inputTxt1").value;
        // alert(xMenu +"_"+ xAdd + " / " +gMonth+ "-" +gYear);
        var data = {
                'STATUS'    : 'SearchData',
                'Search'    : iTxt1,
                'SelMonth'  : gMonth,
				'SelYear'   : gYear,
				'xMenu'		: xMenu,
				'xAdd'		: xAdd,
            };
        senddata(JSON.stringify(data));
    }

    function senddata(data) {
        var form_data = new FormData();
        form_data.append("DATA", data);
        var URL = 'process/Customer.php';
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
                        // swal({
                        //     title: 'ค้นหา' + temp["xMenu"],
                        //     text: 'พบรายการทั้งหมด '+temp["rCnt"] + ' รายการ',
                        //     type: 'success',
                        //     showCancelButton: false,
                        //     confirmButtonColor: '#3085d6',
                        //     cancelButtonColor: '#d33',
                        //     timer: 2000,
                        //     confirmButtonText: 'Ok',
                        //     showConfirmButton: false
						// });
						var link = "";
                        var Str = '<div class="row"> <div class="col-12"> <div class="list-group">';
						
						for (var i = 0; i < temp["rCnt"]; i++) {
                                  
							        link="CustomerSel_DocDetail.php?Cus_Code="+temp[i]["Cus_Code"]+"&CusName="+temp[i]["CusName"];
                                    if(temp["xMenu"] == 1){
                                        link="ProductHidden.php?Cus_Code="+temp[i]["Cus_Code"];
                                    }
									// switch(temp["xMenu"]){
									// 	case 1: link="ProductHidden.php?Cus_Code="+temp[i]["Cus_Code"];break;
                                    //     case 2: link="CustomerSel_DocDetail.php?Cus_Code="+temp[i]["Cus_Code"];break;
									// }

                                    Str += '<a class="list-group-item list-group-item-action" href="'+link+'">' +
												'<div class="card"' +
													'<div class="card-body">' +
														'<h5 class="card-title label2">รหัสลูกค้า : '+temp[i]["Cus_Code"]+
														'<p class="card-text label2">ชื่อลูกค้า : '+temp[i]["CusName"]+'</p>'+
														// '<p>'+link+'</p>'+
													'</div>' +
												'</div>' +
                                            '</a>';
						}
                        Str += "</div></div></div>";

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
