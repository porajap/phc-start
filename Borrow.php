<?php
session_start();
	if($_SESSION["Area"] == "") header('location:index.html');
	$Area = $_SESSION["Area"];
    $xTitle = "ใบยืมสินค้า";
    $xBack = "order.php";

    $_SESSION["xTitle"] = $xTitle;
    $_SESSION["xBack"] = $xBack;
    $_SESSION["xMenu"] = 1;
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
        <div class="xlabel"><?= $Area ?> : <?= $xTitle ?></div>
        <div class="topnav-right">            
            <a href="CustomerBorrow.php"><img src="img/add_doc_2.png" width="30px" height="30px" /> </a>
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

        var iTxt1 = document.getElementById("inputTxt1").value;
        // alert(iTxt1 + " / " +gMonth+ "-" +gYear);
        var data = {
                'STATUS'    : 'SearchData',
                'Search'    : iTxt1,
                'SelMonth'  : gMonth,
                'SelYear'   : gYear
            };
        senddata(JSON.stringify(data));
    }

    function senddata(data) {
        var form_data = new FormData();
        form_data.append("DATA", data);
        var URL = 'process/Borrow.php';
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
                        var Str = '<div class="row"> <div class="col-12"> <div class="list-group">';
                        for (var i = 0; i < temp["rCnt"]; i++) {
                                    Str += '<a class="list-group-item list-group-item-action" href="Borrow_DocNo.php?DocNo='+temp[i]["DocNo"]+'&add=1">' +
                                                '<div class="card"' +
                                                    '<div class="card-body">' +
                                                        '<h5 class="card-title label1">เลขที่เอกสาร : '+temp[i]["DocNo"]+
                                                        '<p class="card-text label2">ชื่อลูกค้า : '+temp[i]["Item"]+'</p>'+
                                                        '<p class="card-text label2">ลงเวลา : '+temp[i]["DocDate"]+'</p>'+
                                                        '<strong class="card-text label2">'+temp[i]["Status"]+'</strong>'+
                                                        '<div class="row align-items-start xTb">';
                                                            if(temp[i]["IsSave"] == 1)
                                                                Str += '<div class="col">' +
                                                                    '<img src="img/Circle_Green.png" width="25" height="25" /></div>';
                                                            else    
                                                                Str += '<div class="col">' +
                                                                    '<img src="img/Circle_Red.png" width="25" height="25" /></div>';

                                                            if(temp[i]["IsFinish"] == 1)
                                                                Str += '<div class="col">' +
                                                                    '<img src="img/Circle_Green.png" width="25" height="25" /></div>';
                                                            else    
                                                                Str += '<div class="col">' +
                                                                    '<img src="img/Circle_Red.png" width="25" height="25" /></div>';

                                                        Str += '</div>' +
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
