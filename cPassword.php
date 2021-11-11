<?php
session_start();
require 'connect.php';

//print("<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html;  charset=UTF-8\">\n");

	$Sql = "SELECT Employee_Code,FName,LName,xUname,xPword FROM employee WHERE Employee_Code = '" . $_SESSION["Area"] . "'";
	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$Employee_Code	=  $Result["Employee_Code"];
		$uName = $Result["xUname"];
		$pWord = $Result["xPword"];
		$xName	=  $Result["FName"] . " " . $Result["LName"];
		$_SESSION["Area"] = $Employee_Code;
		$_SESSION["xName"] = $xName;
		
		session_write_close();
		//echo $Employee_Code ." :  ".$xName . "<br>";
		//echo $Employee_Code ." :  ". $xName;
		$i++;
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
    
    <style>
		.center {
			margin: auto;
			width: 50%;
		}

        .xTop1{
            margin-top: 7px;
            margin-left: 1px;
            margin-right: 1px;
        }

		.xBoxWh{
            width: 200px;
        }

		.bkcolor{
			background-color: #CCD4DB;
			font-weight: 900;
		}
    </style>
</head>

<body>
	<div class="topnav">
        <a href="p2.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?php echo $Area ?></div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
	</div>
	
	<div class="center">
		<img src="img/key1.png" width="150px" height="150px">
	</div>
	<div id="xx"></div>
	<div class="xTop1">
		<div class="input-group mb-3">
			<span class="input-group-text xBoxWh">User Name :</span>
			<input type="text" name="uName" id="uName" value="<?php echo $uName ?>" class="form-control" placeholder="xx/xx/xxxx" aria-describedby="basic-addon1">
		</div>
		<div class="input-group mb-3">
			<span class="input-group-text xBoxWh">Password :</span>
			<input type="password" name="pWord" id="pWord" class="form-control" placeholder="xxxxxxxxx" aria-describedby="basic-addon1">
		</div>
		<div class="input-group mb-3">
			<span class="input-group-text xBoxWh">New Password :</span>
			<input type="password" name="pWordC" id="pWordC" class="form-control" placeholder="xxxxxxxxx" aria-describedby="basic-addon1">
		</div>

		<div class="d-grid">
			<button class="btn btn-primary" name="submit-button-1" id="submit-button-1" onclick="chgPassword()" >บันทึก</button>
		</div>
	</div>
</body>

<script>
    $(document).ready(function() {
        $("button").click(function() {
            $.ajax({
                url: 'demo_test.txt',
                success: function(result) {
                    $("#div1").html(result);
                }
            });
        });
    });

    function chgPassword() {
        var user = document.getElementById("uName").value;
		var password = document.getElementById("pWord").value;
		var newpassword = document.getElementById("pWordC").value;
		// alert(user + " / " + password + " / " + newpassword);
        if (user != "" && password != "" && newpassword != "") {
            var data = {
                'STATUS'		: 'chgPassword',
                'USERNAME'		: user,
				'PASSWORD'		: password,
				'NEWPASSWORD'	: newpassword,
            };
            senddata(JSON.stringify(data));
        } else {
            swal({
                type: 'warning',
                title: 'Something Wrong',
                timer: 3000,
                text: 'Please recheck your username and password!'
            })
        }
    }

    function senddata(data) {
        var form_data = new FormData();
        form_data.append("DATA", data);
        var URL = 'process/login.php';
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
                    if (temp["form"] == 'chgPassword') {
                        swal({
                            title: '',
                            text: temp["msg"],
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            timer: 1000,
                            confirmButtonText: 'Ok',
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            window.location.href = 'index.html';
						}, 1000);
                    }
                } else {
                    swal({
                        title: 'Something Wrong',
                        text: temp["Sql"],
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

                    $("#Sql").html(temp["Sql"]);

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