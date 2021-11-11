<?php
session_start();
require 'connect.php';
	if($_SESSION["Area"] == "") header('location:index.html');
	$xArea = $_SESSION["Area"];
  $xTitle = $_SESSION["xName"];
	$Sel	= $_REQUEST["sel"];
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
	<script src="js/jquery/3.5.1/jquery.min.js "></script>
	<script src="assets/dist/js/bootstrap.js "></script>
	<script src="assets/dist/js/bootstrap.bundle.min.js "></script>
	<script src="assets/dist/js/sweetalert2.min.js"></script>
	<Style>
    .block1 {
      color: red;
	  }

    .block2 {
      color: green;
	  }

    .block3 {
      color: blue;
      font-weight: bold;
	  }

    a:link {
      text-decoration: none;
      text-decoration: underline;
    }

    a:visited {
      text-decoration: none;
      text-decoration: underline;
    }

    a:hover {
      text-decoration: underline;
    }

    a:active {
      text-decoration: underline;
    }

    .box_raduis {
      border:solid 1px #4F4C4D;
      -webkit-border-radius:10px;
      -moz-border-radius:10px;
      border-radius:10px;
      background:while;
    }

    hr {
      margin-top: 1rem;
      margin-bottom: 1rem;
      border: 0;
      border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .nav-tabs .nav-link {
      font-size: 12px;
      color:#2B2B2B;
      text-decoration: none; 
    }

    .nav-tabs .nav-link.visited {
      font-size: 12px;
      color:#2B2B2B;
      text-decoration: none; 
    }

    .nav-tabs .nav-link.hover {
      font-size: 12px;
      color:#2B2B2B;
      text-decoration: none; 
    }

    .nav-tabs .nav-link.link {
      font-size: 12px;
      color:#2B2B2B;
      text-decoration: none; 
    }

    .nav-tabs .nav-link.active {
      font-weight: bold;
      font-size: 18px;
      color:blue;
      text-decoration: none; 
    }

	</Style>
</head>

<body>

<div class="topnav">
		<a href="PieChart.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $xArea ?> : <?= $xTitle ?></div>
</div>

<div class="container">
              <div class="row">
                <div class="col-xs-12 ">

                  <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                      <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">ยอดเก็บ</a>
                      <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">ยอดค้าง</a>
                      <a class="nav-item nav-link" id="nav-3-tab" data-toggle="tab" href="#nav-3" role="tab" aria-controls="nav-3" aria-selected="false">Target เก็บ</a>
                    </div>
                  </nav>
                  <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                      <div id="Grid1"></div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                      <div class="row">
                        <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                          <select name="mySelect" id="mySelect" class="form-select" aria-label="วันที่เกินบิล" onchange="changeFunc()">
                            <option value="0" selected>ทั้งหมด</option>
                            <option value="1">1-120</option>
                            <option value="2">121-180</option>
                            <option value="3">181-240</option>
                            <option value="4">241-360</option>
                            <option value="5">มากกว่า 360</option>
                          </select>
                        </div>
                      </div><hr />
                      <div id="Grid2"></div>
                    </div>
                    <div class="tab-pane fade" id="nav-3" role="tabpanel" aria-labelledby="nav-3-tab">
                      <div id="Grid3"></div>
                    </div>
                  </div>
                
                </div>
              </div>
</div>

<script>
  var xArea = '<?= $xArea ?>';
  var Sel = '<?= $Sel ?>';
  $(document).ready(function(){
    if(Sel==1){
      List1();
      $('.nav-tabs a[href="#nav-home"]').tab('show');
    }else if(Sel==2){
      List2(4);
      $('.nav-tabs a[href="#nav-profile"]').tab('show');
      $("#mySelect option[value='4']").attr("selected", "selected");
    }else if(Sel==3){
      List2(5);
      $('.nav-tabs a[href="#nav-profile"]').tab('show');
      $("#mySelect option[value='5']").attr("selected", "selected");
    }else if(Sel==4){
      List3();
      $('.nav-tabs a[href="#nav-3"]').tab('show');
    }

    $(".nav-tabs a").click(function(e){
      $(this).tab('show');
      var target = $(e.target).attr("href")
      if(target == "#nav-home"){
        List1();
      }else if(target == "#nav-profile"){
        List2(0);  
      }else{
        // List3();
      }
    });
  });

  function List1() {
    var data = {
      'STATUS': 'list1',
      'Sel': Sel,
      'AreaCode' : xArea,
    };

    senddata(JSON.stringify(data));
  }

  function List2(xSel) {
    var data = {
      'STATUS': 'list2',
      'Sel': xSel,
      'AreaCode' : xArea,
    };
    
    senddata(JSON.stringify(data));
  }

  function List3() {
    var data = {
      'STATUS': 'list3',
      'Sel': Sel,
      'AreaCode' : xArea,
    };
    senddata(JSON.stringify(data));
  }

  function changeFunc() {
    var selectBox = document.getElementById("mySelect");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;

    var data = {
      'STATUS': 'list2',
      'Sel': selectedValue,
      'AreaCode' : xArea,
    };

    senddata(JSON.stringify(data));
  }

  function addCommas(nStr)
  {
      nStr += '';
      x = nStr.split('.');
      x1 = x[0];
      x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
          x1 = x1.replace(rgx, '$1' + ',' + '$2');
      }
      return x1 + x2;
  }

  function senddata(data) {
        var form_data = new FormData();
        form_data.append("DATA", data);
        var URL = 'process/listView1.php';
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

                // alert(temp["status"]+" :: "+temp["form"]);

                if (temp["status"] == 'success') {
                    if (temp["form"] == 'list1') {
                      // alert(temp["status"]+" :: "+temp["form"]+" :: "+temp["rCnt"]);
                      $("#Grid1").empty;
                      var Str = '';
                        for (var i = 0; i < temp["rCnt"]; i++) {
                                    Str += '<div class="row"> <a:hover href="#">' +
                                                    
                                                        '<div class="row">' +
                                                        '   <div class="col-sm-8"><p class="card-text label2">เอกสาร : '+temp[i]["DocNo"]+'</p></div>'+
                                                        '</div>' +
                                                        '<div class="row">' +
                                                        '   <div class="col-sm-8"><strong class="card-text label2">เอกสารบัญชี : '+temp[i]["DocNoAcc"]+'</strong></div>'+
                                                        '</div>' +
                                                        '<div class="row">' +
                                                        '   <div class="col-sm-8"><p class="card-text label2">วันที่ : '+temp[i]["Check_ModifyDate"]+'</p></div>'+
                                                        '</div>' +
                                                        '<div class="row">' +
                                                        '   <div class="col-sm-8"><p class="card-text label2">ชื่อลูกค้า : '+temp[i]["FName"]+'</p></div>'+
                                                        '</div>' +
                                                        '<div class="row">' +
                                                        '   <div class="col-sm-8"><p class="card-text label2">เป็นเงิน : '+addCommas(temp[i]["Total"])+' บาท</p></div>'+
                                                        '</div>' +
                                                        '<div class="row">' +
                                                        '   <div class="col-sm-8"><strong class="card-text label2" style="color:'+temp[i]["xStatusColor"]+';">สถานะ : '+temp[i]["xStatus"]+'</strong></div>'+
                                                        '</div>' +
                                                        '<div class="row">' +
                                                        '   <div class="col-sm-8"><strong class="card-text label2">การจ่าย : '+temp[i]["PayType"]+'</strong></div>'+
                                                        '</div>' +

                                              '</a><div><hr />';
						            }
                        Str += '';
                        // alert( Str );
                        $("#Grid1").html(Str);
                    } else if (temp["form"] == 'list2') {
                      // swal({
                      //   type: 'warning',
                      //   title: 'Something Wrong',
                      //   text: temp["msg"]
                      // });

                      $("#Grid2").empty;
                      var Str = '';
                        for (var i = 0; i < temp["rCnt"]; i++) {
                                    Str += '<div class="row"> <a:hover href="#">' +
                                                    
                                                        '<div class="row">' +
                                                        '   <div class="col-sm-8"><p class="card-text label2">เอกสาร : '+temp[i]["DocNo"]+'</p></div>'+
                                                        '</div>' +
                                                        '<div class="row">' +
                                                        '   <div class="col-sm-8"><strong class="card-text label2">เอกสารบัญชี : '+temp[i]["DocNoAcc"]+'</strong></div>'+
                                                        '</div>' +
                                                        '<div class="row">' +
                                                        '   <div class="col-sm-8"><p class="card-text label2">ชื่อลูกค้า : '+temp[i]["FName"]+'</p></div>'+
                                                        '</div>' +
                                                        '<div class="row">' +
                                                        '   <div class="col-sm-8"><p class="card-text label2 block1">วันที่เกิน : '+temp[i]["Day"]+' วัน</p></div>'+
                                                        '</div>' +
                                                        '<div class="row">' +
                                                        '   <div class="col-sm-8"><p class="card-text label2 block3">เป็นเงิน : '+ addCommas(temp[i]["Total"]) +' บาท</p></div>'+
                                                        '</div>' +

                                              '</a><div><hr />';
						            }
                        Str += '';
                        // alert( Str );
                        $("#Grid2").html(Str);
                    } else if (temp["form"] == 'list3') {
                      // swal({
                      //   type: 'warning',
                      //   title: 'Something Wrong',
                      //   text: temp["msg"]
                      // });
                      $("#Grid3").empty;
                      var Total = 0;
                          var Str = '';
                            for (var i = 0; i < temp["rCnt"]; i++) {
                              Total += parseInt( temp[i]["Total"] );
                                        Str += '<div class="row"> <a:hover href="#">' +
                                                        
                                                            '<div class="row">' +
                                                            '   <div class="col-sm-8"><p class="card-text label2">เอกสาร : '+temp[i]["DocNo"]+'</p></div>'+
                                                            '</div>' +
                                                            '<div class="row">' +
                                                            '   <div class="col-sm-8"><strong class="card-text label2">เอกสารบัญชี : '+temp[i]["DocNoAcc"]+'</strong></div>'+
                                                            '</div>' +
                                                            '<div class="row">' +
                                                            '   <div class="col-sm-8"><p class="card-text label2">ชื่อลูกค้า : '+temp[i]["FName"]+'</p></div>'+
                                                            '</div>' +
                                                            '<div class="row">' +
                                                            '   <div class="col-sm-8"><p class="card-text label2 block3">เป็นเงิน : '+ addCommas(temp[i]["Total"]) +' บาท</p></div>'+
                                                            '</div>' +

                                                  '</a><div><hr />';
                            }

                            Str += '</div>' +
                                    '   <div class="col-sm-8"><strong class="card-text label2 block3">รวมเป็นเงินทั้งสิ้น : '+ addCommas(Total) +' บาท</strong></div>'+
                                    '</div>';
                            // alert( Str );
                            $("#Grid3").html(Str);
                    }
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

</body>
</html>