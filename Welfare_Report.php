<?php
date_default_timezone_set("Asia/Bangkok");
session_start();
require 'connect.php';
	if($_SESSION["Area"] == "") header('location:index.html');

	$Area   = $_SESSION["Area"];
    $xName  = $_SESSION["xName"];
    $Sel    = $_REQUEST["Sel1"];
    $SelM   = $_REQUEST["SelM"];
    $SelY   = $_REQUEST["SelY"];
    $thai_month_arr=array(
        "0"=>"-",
        "1"=>"มกราคม",
        "2"=>"กุมภาพันธ์",
        "3"=>"มีนาคม",
        "4"=>"เมษายน",
        "5"=>"พฤษภาคม",
        "6"=>"มิถุนายน", 
        "7"=>"กรกฎาคม",
        "8"=>"สิงหาคม",
        "9"=>"กันยายน",
        "10"=>"ตุลาคม",
        "11"=>"พฤศจิกายน",
        "12"=>"ธันวาคม"                 
    );
    $thai_month_arr=array(
        "มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"                 
    );
    $max = sizeof($thai_month_arr);
    $gYear = date("Y");
    $gMonth = date("m");
    $bYear = $gYear-2;
    if($SelM == "")$SelM = $gMonth-1;
    if($SelY == "")$SelY = $gYear;


    if($SelM<10) 
        $xSelM = "0".($SelM+1);
    else
        $xSelM = ($SelM+1);    

    $Sqlse = "SELECT perioddallycall.sDate,perioddallycall.eDate
            FROM perioddallycall
            WHERE perioddallycall.`Year` = '$SelY' AND perioddallycall.`Month` = '$xSelM'";
    $meQuery = mysqli_query($conn, $Sqlse);
    while ($Result = mysqli_fetch_assoc($meQuery)) {
        $sDate = $Result["sDate"];
        $eDate = $Result["eDate"];
    }
    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>PHC</title>
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

        .xTop2{
            margin: 10px;
            padding: 7px;
        }

		.bkcolor{
			background-color: #CCD4DB;
			font-weight: 900;
		}
    </style>

</head>

<body>
    <div class="topnav">
        <a href="Welfare.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?php echo $Area ?></div>
        <div class="topnav-right">     
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
    </div>

    <div class="row xTop1">
        <div class="col-auto">
            <select id="SelMonth" class="form-select" aria-label="Default select example">
            <?php
                for($i=0;$i<$max;$i++){
                    if($SelM == $i)
                        echo '<option value="'.$i.'" selected>'.$thai_month_arr[$i].'</option>';
                    else
                        echo '<option value="'.$i.'">'.$thai_month_arr[$i].'</option>';    
                }
            ?>
            </select>
        </div>
        <div class="col-auto">
            <select id="SelYear" class="form-select" aria-label="Default select example">
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" onclick="SearchData()">ค้นหา</button>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-warning mb-3" onclick="show_report();">ดูรายงาน</button>
        </div>
    </div>
    
    <!-- <div id="Sqlse"></div>
    <br />
    <div id="Sql"></div>
    <br /> -->
    <div id="Grid1"></div>
</body>
<script>
	$( document ).ready(function() {
        getYear();
	});

    function getYear() {
        var d = new Date();
        var gYear = d.getFullYear();
        var bYear = gYear - 3;
        // alert(gYear + ' / ' + bYear);
        var Str = '';
        for(var i=gYear;i>bYear;i--){
            if(gYear == i)
                Str += '<option value="'+i+'" selected>'+i+'</option>';
            else
                Str += '<option value="'+i+'">'+i+'</option>';    
        }

        $("#SelYear").html(Str);
    }

    function SearchData() {
        var SelMonth = document.getElementById("SelMonth").value;
        var SelYear = document.getElementById("SelYear").value;
        // alert(SelMonth + " / " +SelYear);
        var data = {
                'STATUS': 'SearchData',
                'SelMonth': SelMonth,
                'SelYear': SelYear
            };
        senddata(JSON.stringify(data));
    }

    function show_report(){
        var Area = '<?php echo $Area; ?>';

        var SelMonth = $('#SelMonth').val();
        var SelYear = $('#SelYear').val();
        

        var url = "report/Welfare_Report.php?SelMonth="+SelMonth+"&SelYear="+SelYear+"&Area="+Area;
        window.open(url);

        
    }
//----------------------------------------------------------------------------------------------------------------------
    function senddata(data) {
        var form_data = new FormData();
        form_data.append("DATA", data);
        var URL = 'process/Welfare_Report.php';
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
                        if(temp["rCnt"] > 0){
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
                                Str += '<div class="card xTop2"' +
                                            '<div class="card-body">' +
                                                '<h5 class="card-title label1">เลขที่เอกสาร : '+temp[i]["DocNo"]+' </h5>' +
                                                '<p class="card-text label1">เลขที่บัญชี : '+temp[i]["DocNoAcc"]+'</p>' +
                                                '<p class="card-text label2">ชื่อลูกค้า : '+temp[i]["CusName"]+'</p>' +
                                                '<p class="card-text label2">จำนวนที่เบิกครั้งที่1 : '+temp[i]["Bring1"]+' &nbsp จำนวนที่เบิกครั้งที่2 : '+temp[i]["Bring2"]+'    </p>' +
                                            '</div>' +
                                        '</div>';
                            }
                            Str += "</div></div></div>";
                        
                            $("#Grid1").html(Str);
                        }else{
                            swal({
                                title: 'ค้นหา',
                                text: 'ไม่พบรายการ...!',
                                type: 'warning',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                timer: 2000,
                                confirmButtonText: 'Ok',
                                showConfirmButton: false
                            });
                        }




                        // $("#Sqlse").html(temp["Sqlse"]);
                        // $("#Sql").html(temp["Sql"]);
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
