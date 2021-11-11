<?php
session_start();
require 'connect.php';
	if($_SESSION["Area"] == "") header('location:index.html');

	$Area   = $_SESSION["Area"];
    $xName  = $_SESSION["xName"];
    $Sel    = $_REQUEST["Sel1"];    
    
    // echo $Sel;
    // exit();
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
    </style>
</head>

<body>
    <div class="topnav">
        <a href="p2.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?php echo $Area ?></div>
        <div class="topnav-right">            
            <a href="Welfare_Report.php"><img src="img/Report02.png" width="30px" height="30px" /> </a>
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
    </div>
    <div id="xx"></div>
    <div class="row xTop1">
        <div class="col-auto">
            <select id="xSel1" class="form-select" aria-label="Default select example">
                <option value="3" >ทั้งหมด</option>
                <option value="0" >รอเบิก</option>
                <option value="1">รออนุมัติ</option>
                <option value="2">อนุมัติเรียบร้อย</option>
                
            </select>

        </div>
        <div class="col">
            <label for="inputTxt1" class="visually-hidden">Search</label>
            <input type="Text" class="form-control" id="inputTxt1" placeholder="ค้นหา">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" onclick="SearchData()">ค้นหา</button>
        </div>
    </div>

    <div class="row"> 
        <div class="col-12"> 
            <div class="list-group">
                <div id="Grid1"></div>
            </div>
        </div>
    </div>


</body>
<script>
    $( document ).ready(function() {
        SearchData();
    });
    

    function SearchData() {
        var iTxt1 = document.getElementById("inputTxt1").value;
        var xSel1 = document.getElementById("xSel1").value;
        // alert(xSel1 + " / " +iTxt1);
        var data = {
                'STATUS': 'SearchData',
                'Search': iTxt1,
                'xSel': xSel1
            };
        senddata(JSON.stringify(data));
    }

    function senddata(data) {
        var form_data = new FormData();
        form_data.append("DATA", data);
        var URL = 'process/Welfare.php';
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
                var temp;
                try {
                     temp = JSON.parse(result);
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
                        //     title: 'ค้นหา',
                        //     text: 'พบรายการทั้งหมด '+temp["rCnt"] + ' รายการ',
                        //     type: 'success',
                        //     showCancelButton: false,
                        //     confirmButtonColor: '#3085d6',
                        //     cancelButtonColor: '#d33',
                        //     timer: 2000,
                        //     confirmButtonText: 'Ok',
                        //     showConfirmButton: false
                        // });
                        
                        var CBill = "";
                        var Str = '';
                        for (var i = 0; i < temp["rCnt"]; i++) 
                        {
                            if(temp[i]["CheckT"] == 's')
                                CBill = "บิลปกติ";
                            else
                                CBill = "แยกบิล";

                            
                            var sel = temp[i]["sel"];
                            var img1 = "img/unsuccess-1.png";
                            var img2 = "img/unsuccess-1.png";
                            var img3 = "img/unsuccess-1.png";

                            var price = temp[i]["Bring1"];
                            var bring = "1";

                            if(temp[i]['Status_Finish_Bring'] == 0) 
                            {
                                if(temp[i]['bFinish1'] == 0 && temp[i]['bFinish2'] == 0 && temp[i]['bFinish3'] == 0) {
                                    img1 = "img/unsuccess-1.png";
                                    img2 = "img/unsuccess-1.png";
                                    img3 = "img/unsuccess-1.png";
                                    bring = "1";

                                }else if(temp[i]['bFinish1'] == 1 && temp[i]['bFinish2'] == 0 && temp[i]['bFinish3'] == 0) {
                                    img1 = "img/success-2.png";
                                    img2 = "img/unsuccess-1.png";
                                    img3 = "img/unsuccess-1.png";

                                    price = temp[i]["Bring2"];
                                    bring = "2";

                                   

                                }else if(temp[i]['bFinish1'] == 1 && temp[i]['bFinish2'] == 1 && temp[i]['bFinish3'] == 0) {
                                    img1 = "img/success-2.png";
                                    img2 = "img/success-2.png";
                                    img3 = "img/unsuccess-1.png";

                                    price = temp[i]["Bring2"];
                                    bring = "2";

                                }else if(temp[i]['bFinish1'] == 1 && temp[i]['bFinish2'] == 1 && temp[i]['bFinish3'] == 1) {
                                    img1 = "img/success-2.png";
                                    img2 = "img/success-2.png";
                                    img3 = "img/success-2.png";

                                    price = temp[i]["Bring3"];
                                    bring = "3";
                                }
                            
                                Str += `<a class="list-group-item list-group-item-action" href="Welfare_Detail.php?DocNo=${temp[i]["DocNo"]}&DocNoAcc=${temp[i]["DocNoAcc"]}&Sel=${bring}&Price=${price}&CheckT=${temp[i]["CheckT"]}&IsCopy=${temp[i]["IsCopy"]}">
                                                <div class="row align-items-start xTb">
                                                        <div class="col">
                                                            <img src="${img1}" width="25" height="25" /> เบิกครั้งที่ 1
                                                        </div>
                                                        <div class="col">
                                                            <img src="${img2}" width="25" height="25" /> เบิกครั้งที่ 2
                                                        </div>
                                                        <div class="col">
                                                            <img src="${img3}" width="25" height="25" /> เบิกครั้งที่ 3
                                                        </div>
                                                        <div class="col">
                                                            ${CBill} 
                                                        </div>
                                                        <div class="col">
                                                                <span class="set-text">${sel}</span>
                                                        </div>
                                                        
                                                </div>
                                                <div class="card"
                                                    <div class="card-body">
                                                        <h5 class="card-title label1">เลขที่เอกสาร : ${temp[i]["DocNo"]} </h5>
                                                        <p class="card-text label1">เลขที่บัญชี : ${temp[i]["DocNoAcc"]} </p>
                                                        <p class="card-text label2">ชื่อลูกค้า : ${temp[i]["CusName"]} </p>
                                                
                                                    </div>
                                                </div>
                                            </a>`;
                            }
                            else
                            {
                                Str += `<a class="list-group-item list-group-item-action" href="#">
                                                <div class="row align-items-start xTb">
                                                        <div class="col-1">
                                                            <img src="img/success-2.png" width="25" height="25" />
                                                        </div>
                                                        <div class="col">
                                                            <span class="set-text2">${sel}</span>
                                                        </div>
                                                </div>
                                                <div class="card"
                                                    <div class="card-body">
                                                        <h5 class="card-title label1">เลขที่เอกสาร : ${temp[i]["DocNo"]} </h5>
                                                        <p class="card-text label1">เลขที่บัญชี : ${temp[i]["DocNoAcc"]} </p>
                                                        <p class="card-text label2">ชื่อลูกค้า : ${temp[i]["CusName"]} </p>
                                                    </div>
                                                </div>
                                            </a>`;
                            }

                            
                        }

                        $("#Grid1").html(Str);
                        // $("#xx").html(temp["rCnt"] + "<br>" + temp["Sql1"] + "<br>");
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
