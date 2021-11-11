<?php
session_start();
require 'connect.php';
$Area = $_SESSION["Area"];
$xName = $_SESSION["xName"];
if($_SESSION["Area"] == "") header('location:index.html');

 $Sql = "SELECT item.Item_Code,item.NameTH FROM item WHERE item.IsSale = 1";
 $meQuery = mysqli_query($conn,$Sql);
 $i=1;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<title>PHC</title>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="icon/icon.ico">
    <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/dist/css/sweetalert2.min.css">
	<link rel="stylesheet" href="css/topnav.css">
	<link rel="stylesheet" href="css/hr.css">
	<script src="js/jquery/3.5.1/jquery.min.js "></script>
	<script src="assets/dist/js/bootstrap.js "></script>
	<script src="assets/dist/js/bootstrap.bundle.min.js "></script>
    <script src="assets/dist/js/sweetalert2.min.js"></script>
    <style>
		.xBoxWh{
			width: 150px;
		}

        .xTop1{
            margin-top: 7px;
            margin-left: 3px;
            margin-right: 3px;
        }

        .xTop2{
            margin : 2px;
			padding: 5px;
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
        <a href="Date03.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $Area ?> : Daily call</div>
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
		<?php
		if($_REQUEST["Item_Code"] != ""){
			$_SESSION["Item_Search"] = $_REQUEST["Item_Code"];
		

			echo "<script>
			window.location.href ='Date03.php';
			</script>
			";
		}
		?>
	<table class='table'>
   		<thead>
			<tr>
				<th >ลำดับ</th>
				<th >รหัสสินค้า</th>
				<th >ชื่อสินค้า</th>
			</tr>
        </thead>
        <tbody id="iBody">
        </tbody>
    </table>

</body>
<script>
    $( document ).ready(function() {
        SearchData();
    });
    
    function SearchData() {
        var iTxt1 = document.getElementById("inputTxt1").value;
        // alert(iTxt1);
        var data = {
                'STATUS'    : 'SearchData',
                'Search'    : iTxt1
            };
        senddata(JSON.stringify(data));
    }

    function senddata(data) {
        var form_data = new FormData();
        form_data.append("DATA", data);
        var URL = 'process/item_search.php';
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
				// swal({
                //             title: 'ค้นหา',
                //             text: 'พบรายการทั้งหมด '+temp["rCnt"] + ' รายการ',
                //             type: 'success',
                //             showCancelButton: false,
                //             confirmButtonColor: '#3085d6',
                //             cancelButtonColor: '#d33',
                //             timer: 2000,
                //             confirmButtonText: 'Ok',
                //             showConfirmButton: false
                //         });
                if (temp["status"] == 'success') {
                    if (temp["form"] == 'SearchData') {
						var Str = "";
                        for (var i = 0; i < temp["rCnt"]; i++) {
							Str += "<tr>" +
										"<td>"+(i+1)+"</td>" +
 										"<td><a href='item_search.php?Item_Code="+temp[i]['Item_Code']+"'>"+temp[i]['Item_Code']+"</a></td>" +
 										"<td>" + temp[i]['NameTH'] + "</td>" +
									"</tr>";
						}
                        // $("#Sql").html(temp["Sql"]);
                        $("#iBody").html(Str);
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