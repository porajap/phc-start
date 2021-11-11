<?php
session_start();
require 'connect.php';

	if($_SESSION["Area"] == "") header('location:index.html');

	$Area = $_SESSION["Area"];
    $xName = $_SESSION["xName"];
    $xTitle = $_SESSION["xTitle"];

	if($Area=="P10"){
		$Sql = "SELECT customer.Cus_Code,customer.FName,customer.LName
		FROM customer
		INNER JOIN prefix ON prefix.Prefix_Code = customer.Prefix_Code
		WHERE customer.AreaCode = '$Area' 
		AND customer.IsActive = 1 
		AND prefix.Status = 1";
	}else{
		$Sql = "SELECT Cus_Code,FName,LName FROM customer WHERE AreaCode = '$Area' AND IsActive = 1";
	}
	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$CusCode[$i] = $Result["Cus_Code"];
		$Item[$i]	=  $CusCode[$i] . " : " .$Result["FName"] . "  " . $Result["LName"];
		$i++;
	}

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
        <a href="Dispenser.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
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

        var iTxt1 = document.getElementById("inputTxt1").value;
        // alert(xMenu +"_"+ xAdd + " / " +gMonth+ "-" +gYear);
        var data = {
                'STATUS'    : 'SearchData',
                'Search'    : iTxt1
            };
        senddata(JSON.stringify(data));
    }

    function senddata(data) {
        var form_data = new FormData();
        form_data.append("DATA", data);
        var URL = 'process/CustomerDispenser.php';
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
									link="Dispenser_DocNo.php?add=0&Cus_Code="+temp[i]["Cus_Code"];
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