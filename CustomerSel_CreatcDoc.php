<?php
session_start();
require 'connect.php';
	if($_SESSION["Area"] == "") header('location:index.html');
	$Area 	= $_SESSION["Area"];
	$xTitle = $_SESSION["xName"];
    $Cus_Code = $_REQUEST["Cus_Code"];
    $CusName = $_REQUEST["CusName"];
    $IsStatus = $_REQUEST["IsStatus"];
    $DocNoP = $_REQUEST["DocNoP"];
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
    <link rel="stylesheet" href="assets/plugins/dropify/dist/css/dropify.min.css">
    <link rel="stylesheet" href="assets/datepicker/dist/css/datepicker.min.css">

	<script src="js/jquery/3.5.1/jquery.min.js "></script>
	<script src="assets/dist/js/bootstrap.js "></script>
	<script src="assets/dist/js/bootstrap.bundle.min.js "></script>
    <script src="assets/dist/js/sweetalert2.min.js"></script>
    <script src="assets/plugins/dropify/dist/js/dropify.min.js"></script>
    <script src="assets/datepicker/dist/js/datepicker.min.js"></script>
    <script src="assets/datepicker/dist/js/i18n/datepicker.en.js"></script>
    
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

        .dropify-wrapper .dropify-message span.file-icon {
            font-size: 18px;
            color: #CCC;
        }


    </style>
</head>

<body>
	<div class="topnav">
        <a href="CustomerSel_DocDetail.php?Cus_Code=<?= $Cus_Code ?>&CusName=<?= $CusName ?>"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel "> รับชำระผู้แทน  เขตที่ : <?= $Area ?></div>
        <div class="topnav-right">
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
	</div>

    <div class="row xTop1">
        <!-- <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" onclick="createDoc();">สร้างเอกสารจ่าย</button>
        </div> -->
    </div>

    <div class=" col-12 mt-3" style="width: 98%;margin-left: 1%;">
        <div class="card" style="border: solid;border-color: darkgray;">
            <div class="col-10 mt-4" style="margin-left: 1%;">
                <label for="inputTxt1" class="visually-hidden">Search</label>
                <input type="Text" class="form-control" id="inputTxt1" placeholder="ค้นหาเลขที่บิล">
            </div>
            <div class="card-body"  style="max-height: 350px;overflow-y: auto;">
                    <div class="modal-body row">
                        <table class='table table-bordered' id='Table_DocSale' style='width:100%;'>
                            <thead id='theadsum'>
                                <tr style='text-align: center;'>
                                    <th style='font-size: 16px;font-weight: bold; color: #000000; text-align: center;'>เลือก</th>
                                    <th style='font-size: 16px;font-weight: bold; color: #000000; text-align: center;'>วันที่บิล</th>
                                    <th style='font-size: 16px;font-weight: bold; color: #000000; text-align: center;'>เลขที่บิล</th>
                                    <th style='font-size: 16px;font-weight: bold; color: #000000; text-align: center;'>ยอดเงิน</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
            </div>
            <div class="row">
                <div class="col-4  mb-3" style="margin-left: 65.5%;">
                  <button type="submit" id="bt_AddDocDetail" style="width: 100%;" class="btn btn-primary mb-3" onclick="AddDocDetail();">เพิ่มบิลเอกสาร</button>
                </div>
   
            </div>
            <div class="row">
                <div class="col-4  mb-3" >
                 
                </div>
                <div class="col-3  mb-3" style="text-align: right;">
                    <label for="inputPassword" class=" col-form-label"><input class="form-check-input" type="radio" name="Radio_Sum" id="Radio_Sum1" value="1" checked onclick="chk_typeSum();"> ยอดรวม </label>
                 </div>
                

                <div class="col-5 mb-3 row" >
                    <div class="">
                    <input style="text-align: right;" type="Text" class="form-control" id="text_sum" placeholder="ยอดรวม" readonly>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-4  mb-3" >
                 
                </div>
                <div class="col-3  mb-3" style="text-align: right;">
                    <label for="inputPassword" class=" col-form-label"><input class="form-check-input" type="radio" name="Radio_Sum" id="Radio_Sum2" value="2" onclick="chk_typeSum();"> ยอดหลังหักภาษี </label>
                 </div>
            
                <div class="col-5 mb-3 row">
                    <div class="">
                    <input style="text-align: right;" type="Text" class="form-control" id="text_sum_tax" placeholder="ยอดหลังหักภาษี" readonly>
                    </div>
                </div>
            </div>
          
        </div>
        
    </div>
    

    <div class=" col-12 mt-3 mb-3" style="width: 98%;margin-left: 1%;">
        <div class="card" style="border: solid;border-color: darkgray;">

            <div class="col-10 mt-4" style="margin-left: 1%;">
                <label for="inputTxt1" style="font-size: 16px;font-weight: bold;" class="">วิธีการจ่าย</label>
            </div>

            <div class="col-10 mt-3 " style="margin-left: 3%;">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="Radiopay" id="Radiopay1" value="1" checked onclick="chkRadiopay();">
                    <label class="form-check-label" for="Radiopay1">เงินสด</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="Radiopay" id="Radiopay2" value="2" onclick="chkRadiopay();">
                    <label class="form-check-label" for="Radiopay2">เงินโอน</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="Radiopay" id="Radiopay3" value="3" onclick="chkRadiopay();">
                    <label class="form-check-label" for="Radiopay3">เช็ค</label>
                </div>
            </div>
            

            <div class="col-10 mt-3 " style="margin-left: 1%;">
                <div class=" mt-3" style="width: 90%;">
                <input style="text-align: right;" type="Text" class="form-control" id="text_imageSlip"  hidden>
                <input style="text-align: right;" type="Text" class="form-control" id="text_imageSlip2"  hidden>
                    <label style="font-size: 16px;font-weight: bold;" class="col-sm-4 col-form-label ">อัพโหลดรูป Pay In / Slip</label>
                    <div class="row">
                        <div class="col-6" >
                            <p>รูปที่ 1</p>
                            <div class='form-group row'>
                                <div class="" style="height: 200px;margin-left: 3%;">
                                    <input  type="file" id="imageSlip" accept="image/x-png,image/gif,image/jpeg" class="dropify">
                                </div>
                            </div>

                        </div>
                        <div class="col-6 " >
                            <p>รูปที่ 2</p>
                            <div class='form-group row'>
                                <div class="" style="height: 200px;margin-left: 3%;">
                                    <input  type="file" id="imageSlip2" accept="image/x-png,image/gif,image/jpeg" class="dropify">
                                </div>
                            </div>

                        </div>
                       

                    </div>
                 
                </div>

                <div class="mb-3 mt-3" id="div_number">
                    <label style="font-size: 16px;font-weight: bold;" for="exampleFormControlTextarea1" class="form-label">เลขที่เช็ค</label>
                    <input type="text" class="form-control" id="Text_number"  placeholder="เลขที่เช็ค" style="margin-left: 1%;">
                </div>

                <div class="mb-3 mt-3" id="div_Bank">
                    <label for="exampleFormControlTextarea1" style="font-size: 16px;font-weight: bold;" class="form-label">เลือกธนาคาร</label>
                    <select class="form-select" aria-label="Default select example" style="margin-left: 1%;" id="Select_Bank">
       
                    </select>
                </div>

                <div class="mb-3 mt-3" id="div_branch">
                    <label style="font-size: 16px;font-weight: bold;" for="exampleFormControlTextarea1" class="form-label">กรอกสาขา</label>
                    <input type="text" class="form-control" id="Text_branch"  placeholder="กรอกสาขา" style="margin-left: 1%;">
                </div>

                <div class="mb-3 mt-3">
                    <label style="font-size: 16px;font-weight: bold;" for="exampleFormControlTextarea1" class="form-label">วันที่จ่าย</label>
                    <input style="margin-left: 1%;" type="text" autocomplete="off" class="form-control  datepicker-here " id="txt_dateBank" data-language='en' data-date-format='dd-mm-yyyy' placeholder="วันที่นำเช็คเข้าธนาคาร" readonly>
                </div>

                <div style="font-size: 16px;font-weight: bold;" class="mb-3 mt-3">
                    <label for="exampleFormControlTextarea1" class="form-label">ยอดเงิน</label>
                    <input type="text" class="form-control" id="Text_total"  style="margin-left: 1%;" placeholder="ยอดเงินรวมหน้าเช็ค" hidden>
                    <input type="text" class="form-control" id="Text_total_check"  style="margin-left: 1%;" placeholder="ยอดเงินรวมหน้าเช็ค" >
                </div>

                

                <hr>
            <!-- ----------------------------------------------------------------------------------- -->
            <div class="col-10 mt-4" style="margin-left: 1%;">
                <label style="font-size: 16px;font-weight: bold;" for="inputTxt1" class="">รูปแบบภาษี</label>
            </div>
                <div class="col-10 mt-3 mb-3" style="margin-left: 3%;">


                
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="Radiotax" id="Radiotax1" value="1" checked onclick="chkRadio_Tax();"()>
                        <label class="form-check-label" for="Radiotax1">แนบภาษี</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="Radiotax" id="Radiotax3" value="3" onclick="chkRadio_Tax();">
                        <label class="form-check-label" for="Radiotax3">ขาดภาษี</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="Radiotax" id="Radiotax2" value="2" onclick="chkRadio_Tax();">
                        <label class="form-check-label" for="Radiotax2">ไม่แนบภาษี</label>
                    </div>
                </div>

                <div class=" mt-3" style="width: 50%;" id="div_imageTax">
                <input style="text-align: right;" type="Text" class="form-control" id="text_imageTax" hidden>
                    <label style="font-size: 16px;font-weight: bold;" class="col-sm-4 col-form-label ">อัพโหลดรูป ภาษีหัก ณ ที่จ่าย</label>
                    <div class='form-group row'>
                        <div class="col-md-7" style="height: 200px;margin-left: 3%;">
                            <input  type="file" id="imageTax" accept="image/x-png,image/gif,image/jpeg" class="dropify">
                        </div>
                    </div>
                </div>

                <div class="mb-3 mt-3" id="div_taxpay" hidden>
                    <label style="font-size: 16px;font-weight: bold;" for="exampleFormControlTextarea1" class="form-label">กรอกภาษีหัก ณ ที่จ่าย</label>
                    <input type="text" class="form-control" id="Text_taxpay"  placeholder="ภาษีหัก ณ ที่จ่าย" style="margin-left: 1%;">
                </div>

                <div class="mb-3 mt-3" id="div_Text_totaltax">
                    <label style="font-size: 16px;font-weight: bold;" for="exampleFormControlTextarea1" class="form-label">ราคารวม(หักภาษี 1 %)</label>
                    <input type="text" class="form-control" id="Text_totaltax"  style="margin-left: 1%;" placeholder="ยอดเงินรวมหักภาษี" readonly>
                </div>
                
            </div>





            <div class="col-12 mt-3 mb-3" style="margin-left: 1.5%;">
                <button type="submit" id="bt_SaveDoc" style="width: 84%;" class="btn btn-success mb-3" onclick="chkSave();">บันทึกเอกสาร</button>
            </div>

        </div>
    </div>



    <div id="Sql"></div>
    <div id="Grid1"></div>


        <!-- Modal -->
        <div class="modal fade" id="AddDocDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เพิ่มรายการบิลชำระ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body"  style="max-height: 350px;overflow-y: auto;">
                        <div class="modal-body row">
                            <table class='table table-bordered' id='Table_DocSaleAdd_Modal' style='width:100%;'>
                                <thead id='theadsum'>
                                    <tr style='text-align: center;'>
                                        <th style='font-size: 16px;font-weight: bold; color: #000000; text-align: center;'>เลือก</th>
                                        <th style='font-size: 16px;font-weight: bold; color: #000000; text-align: center;'>วันที่บิล</th>
                                        <th style='font-size: 16px;font-weight: bold; color: #000000; text-align: center;'>เลขที่บิล</th>
                                        <th style='font-size: 16px;font-weight: bold; color: #000000; text-align: center;'>ยอดเงิน</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="SaveAdd_Docdetail();">เพิ่มรายการ</button>
            </div>
            </div>
        </div>
        </div>
   

</body>
<script>
    $( document ).ready(function() {
        var d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        var output = (('' + day).length < 2 ? '0' : '') + day + '-' +
                    (('' + month).length < 2 ? '0' : '') + month + '-' +
                    d.getFullYear();

        $("#txt_dateBank").val(output);

    //-------------------------------------------------------
        $('.dropify').dropify();

        var drEvent = $('#imageSlip').dropify();
        var drEvent3 = $('#imageSlip2').dropify();
        var drEvent2 = $('#imageTax').dropify();

        drEvent.on('dropify.afterClear ', function(event, element) {
        $('#imageSlip').data("value", "default");
        // document.getElementById("show_img1").src = "../img/icon/no-image.jpg";
        });

        drEvent3.on('dropify.afterClear ', function(event, element) {
        $('#imageSlip2').data("value", "default");
        // document.getElementById("show_img1").src = "../img/icon/no-image.jpg";
        });

        drEvent2.on('dropify.afterClear ', function(event, element) {
        $('#imageTax').data("value", "default");
        // document.getElementById("show_img1").src = "../img/icon/no-image.jpg";
        });


        var IsStatus = <?= $IsStatus ?>;
        var DocNoP = '<?= $DocNoP ?>';
        getBank();

        setTimeout(function() {
            if(DocNoP != '0'){    
                showDateDetail();
                SearchDataSalecDocEdit();
            }else{
                SearchDataSaleDoc();
            }
        }, 100);

        
        setTimeout(function() {
            chkRadiopay();
        }, 300);
        
    });


    function chkRadio_Tax() {
      
        var Radiotax= document.querySelector('input[name="Radiotax"]:checked').value;
       
        if(Radiotax==1){
            $("#div_imageTax").show();
    
            $("#div_Text_totaltax").show(); 
        }else if(Radiotax==2){
            $("#div_imageTax").hide();
          
            $("#div_Text_totaltax").hide();
        }
        else if(Radiotax==3){
            $("#div_imageTax").hide();
          
          $("#div_Text_totaltax").show();
        }
  }

  function chkRadiopay() {
      
      var Radiopay= document.querySelector('input[name="Radiopay"]:checked').value;
     
      if(Radiopay==1){
          $("#div_number").hide();
          $("#div_Bank").hide(); 
          $("#div_branch").hide(); 
      }else if(Radiopay==2){
          $("#div_number").hide();
          $("#div_Bank").show(); 
          $("#div_branch").show(); 
      }else{
          $("#div_number").show();
          $("#div_Bank").show(); 
          $("#div_branch").show(); 
      }
}

  function chk_typeSum() {
    var Radio_Sum= document.querySelector('input[name="Radio_Sum"]:checked').value;  
    var _sumTotal = parseFloat(0);
    if(Radio_Sum=='1'){
        _sumTotal = $('#text_sum').val();
    }else{
        _sumTotal = $('#text_sum_tax').val();
    }

    if(_sumTotal){
        _sumTotal =parseFloat(_sumTotal.replace(/,/g, ''));
    }
    const _resultSumTotal = parseFloat(_sumTotal*0.01).toFixed(2);
    $('#Text_totaltax').val(_resultSumTotal);
  }

    function getBank() {
      
        var data = {
                'STATUS'    : 'getBank',
            };
        senddata(JSON.stringify(data));
    }
    
    function SearchDataSaleDoc() {
        var Cus_Code = <?= $Cus_Code ?>;
        var Area =   '<?= $Area ?>';

        var data = {
                'STATUS'    : 'SearchDataSaleDoc',
                'Cus_Code'  : Cus_Code,
                'Area'  : Area,
            };
        senddata(JSON.stringify(data));
    }

    function SearchDataSalecDocEdit() {
        var Cus_Code = <?= $Cus_Code ?>;
        var Area =   '<?= $Area ?>';
        var DocNoP = '<?= $DocNoP ?>';
        var data = {
                'STATUS'    : 'SearchDataSalecDocEdit',
                'Cus_Code'  : Cus_Code,
                'Area'  : Area,
                'DocNoP'  : DocNoP,
            };
        senddata(JSON.stringify(data));
    }

    function update_QtyDoc() {
        var DocNoP = '<?= $DocNoP ?>';
        var data = {
                'STATUS'    : 'update_QtyDoc',
                'DocNoP'  : DocNoP,
            };
        senddata(JSON.stringify(data));
    }
    

    function SaveAdd_Docdetail() {
        var DocNoP = '<?= $DocNoP ?>';
        var Cus_Code = <?= $Cus_Code ?>;
        var Area =   '<?= $Area ?>';

        var RadioModal= document.querySelector('input[name="RadioModal"]:checked').value;

        $.ajax({
            url: "process/saveDoc_cusSale.php",
            type: 'POST',
            data: {
                'FUNC_NAME': 'SaveAdd_Docdetail',
                'DocNoP': DocNoP,
                'DocNO_sale': RadioModal,
                'Cus_Code': Cus_Code,
                'Area': Area
            },
            success: function(result) {
            swal({
                    title:'Success',
                    text: 'เพิ่มรายการเรียบร้อย',
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    timer: 1000,
                    confirmButtonText: 'Ok',
                    showConfirmButton: false
                });
                setTimeout(function() {
                    $('#AddDocDetail').modal('toggle');
                    SearchDataSalecDocEdit();
                    update_QtyDoc();
                }, 500);

            }
        });
        
    }

    function showDateDetail() {
        var DocNoPs = '<?= $DocNoP ?>';
    
        $.ajax({
            url: "process/saveDoc_cusSale.php",
            type: 'POST',
            data: {
                'FUNC_NAME': 'showDateDetail',
                'DocNoPs': DocNoPs
            },
            success: function(result) {
                var ObjData = JSON.parse(result);
              
              if (!$.isEmptyObject(ObjData)) {
                $.each(ObjData, function(key, value) {

                        $('#txt_dateBank').val(value.dateBank);
                        $('#Text_total').val(value.Sumtotal);
                        $('#Select_Bank').val(value.Bank);
                        $('#Text_branch').val(value.branch_Bank);
                        $('#Text_taxpay').val(value.TaxPay);
                        $('#Text_totaltax').val(value.Sumtotal_Tax);
                        $('#text_imageSlip').val(value.img_slip);
                        $('#text_imageSlip2').val(value.img_slip2);
                        $('#text_imageTax').val(value.img_tax);
                        $('#Text_number').val(value.check_number);
                        $('#Text_total_check').val(value.SlipPay);
                      
                        
                        
                        var Ispay = value.Ispay;
                        if(Ispay=='1'){
                            document.getElementById("Radiopay1").checked = true;
                        }else if(Ispay=='2'){
                            document.getElementById("Radiopay2").checked = true;
                        }else{
                            document.getElementById("Radiopay2").checked = true;
                        }
                        
                        var TaxType = value.TaxType;
                        if(TaxType =='1'){
                            document.getElementById("Radiotax1").checked = true;
                            $("#div_imageTax").show();
                            $("#div_Text_totaltax").show();
                        }else{
                            document.getElementById("Radiotax2").checked = true;
                            $("#div_imageTax").hide();
                            $("#div_Text_totaltax").hide();
                        }

                        var Type_sum = value.Type_sum;
                        if(Type_sum =='1'){
                            document.getElementById("Radio_Sum1").checked = true;
                        }else{
                            document.getElementById("Radio_Sum2").checked = true;
                        }

                        

                        var image = `${"imageSlip/"+value.img_slip}`;
                        
                        if (image != "imageSlip/") {

                        var drEvent = $('#imageSlip').dropify({
                            defaultFile: image
                        });
                        drEvent = drEvent.data('dropify');
                        drEvent.resetPreview();
                        drEvent.clearElement();
                        drEvent.settings.defaultFile = image;
                        drEvent.destroy();
                        drEvent.init();
                        document.getElementById("imageSlip").src = image;

                        } else {

                        var drEvent = $('#imageSlip').dropify({
                            defaultFile: null
                            });
                            drEvent = drEvent.data('dropify');
                            drEvent.resetPreview();
                            drEvent.clearElement();
                            drEvent.settings.defaultFile = null;
                            drEvent.destroy();
                            drEvent.init();
                        // $(".dropify-clear").click();
                        }
                    //------------------------------------------------------------
                    var image2 = `${"imageSlip/"+value.img_slip2}`;
                        
                        if (image2 != "imageSlip/") {

                        var drEvent = $('#imageSlip2').dropify({
                            defaultFile: image2
                        });
                        drEvent = drEvent.data('dropify');
                        drEvent.resetPreview();
                        drEvent.clearElement();
                        drEvent.settings.defaultFile = image2;
                        drEvent.destroy();
                        drEvent.init();
                        document.getElementById("imageSlip2").src = image2;

                        } else {

                        var drEvent = $('#imageSlip2').dropify({
                            defaultFile: null
                            });
                            drEvent = drEvent.data('dropify');
                            drEvent.resetPreview();
                            drEvent.clearElement();
                            drEvent.settings.defaultFile = null;
                            drEvent.destroy();
                            drEvent.init();
                        // $(".dropify-clear").click();
                        }

             
                    //---------------------------------------------------

                        var image2 = `${"imageSlip/"+value.img_tax}`;
                        
                        if (image2 != "imageSlip/") {

                        var drEvent = $('#imageTax').dropify({
                            defaultFile: image2
                        });
                        drEvent = drEvent.data('dropify');
                        drEvent.resetPreview();
                        drEvent.clearElement();
                        drEvent.settings.defaultFile = image2;
                        drEvent.destroy();
                        drEvent.init();
                        document.getElementById("imageTax").src = image2;

                        } else {

                        var drEvent = $('#imageTax').dropify({
                            defaultFile: null
                            });
                            drEvent = drEvent.data('dropify');
                            drEvent.resetPreview();
                            drEvent.clearElement();
                            drEvent.settings.defaultFile = null;
                            drEvent.destroy();
                            drEvent.init();
                        // $(".dropify-clear").click();
                        }
                //--------------------------------------------------------------------------------
                        var IsStatus = value.IsStatus;
                        var IsStatusTax = value.IsStatusTax;
                    
                 

                        setTimeout(function() {
                            if(IsStatus=='2'){
                            document.getElementById("txt_dateBank").disabled = true;
                            document.getElementById("Text_total").disabled = true;
                            document.getElementById("Select_Bank").disabled = true;
                            document.getElementById("Text_branch").disabled = true;
                            document.getElementById("Radiopay1").disabled = true;
                            document.getElementById("Radiopay2").disabled = true;
                            document.getElementById("Radiopay3").disabled = true;
                            document.getElementById("imageSlip").disabled = true;
                            document.getElementById("imageSlip2").disabled = true;
                            document.getElementById("Text_total_check").disabled = true;
                        }

                        if(IsStatusTax=='2'){
                            document.getElementById("imageTax").disabled = true;
                            document.getElementById("Text_taxpay").disabled = true;
                            document.getElementById("Radiotax1").disabled = true;
                            document.getElementById("Radiotax2").disabled = true;
                        }

                        if(IsStatus=='2'&&IsStatusTax=='2'){
                           $('#bt_SaveDoc').hide();
                        }
                        }, 100);

                        setTimeout(function() {
                            chk_typeSum();
                        }, 400);
                        
                });
              }

            }
        });
    }


    function chkSave() {
        var DocNoPs = '<?= $DocNoP ?>';
        if(DocNoPs=='0'){
            SaveDoc();
        }else{
            SaveEdit();
        }
    }

    function AddDocDetail() {
        //    alert(RowId);
        $('#AddDocDetail').modal('toggle');
        var Cus_Code = <?= $Cus_Code ?>;
        var Area =   '<?= $Area ?>';

        var data = {
                'STATUS'    : 'SearchDataSaleDoc_Modal',
                'Cus_Code'  : Cus_Code,
                'Area'  : Area,
            };
        senddata(JSON.stringify(data));

    }

    function delete_detail(RowId,IsCopy) {
    //    alert(RowId);

       swal({
               title: "ยืนยันลบรายการ",
               text: "ต้องการลบรายการเอกสาร  ใช่หรือไม่ ?",
               type: "warning",
               showCancelButton: true,
               confirmButtonClass: "btn-danger",
               confirmButtonText: "ใช่",
               cancelButtonText: "ยกเลิก",
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               closeOnConfirm: false,
               closeOnCancel: false,
               showCancelButton: true
            }).then(result => {
               if (result.value) {
                  var data = {
                    'STATUS'    : 'delete_detail',
                    'RowId'  : RowId,
                    'IsCopy':IsCopy,
                  };
                  senddata(JSON.stringify(data));

               }
            })

    }

    
    var DocArray = {};
    DocArray.DocNO = [];
    DocArray.amount = [];

    function add_Doc(row) {
        var iArray = [];
        DocArray.DocNO = [];
        DocArray.amount = [];
        var i = 0;

        var DocNO = "";
        var amount = 0;
        var sumtotal = 0 ;
     

        $("#checkDoc:checked").each(function() {
          iArray.push($(this).val());
          // console.log( iArray.push($(this).val()));
        }); 
        

        for (var j = 0; j < iArray.length; j++) {
            
            DocNO = $("#DocNo_" + iArray[j]).val();
            amount = $("#amountID_" + iArray[j]).val();
            amount = parseFloat(amount);
            sumtotal += amount;
       
          if($.inArray(DocNO, DocArray.DocNO) != -1){
            var key = $.inArray(DocNO, DocArray.DocNO);
            // DocArray.Qty[key] = Qty;
          }else{
            DocArray.DocNO.push(DocNO);
            DocArray.amount.push(amount);
          }
         
        //   console.log(DocArray.DocNO);
        }
        var sumtotal_tax = 0;
        sumtotal_tax = sumtotal/1.07;;
        // sumtotal_tax = sumtotal_tax.toFixed(2);
        // sumtotal_tax =  Math.round(sumtotal_tax);
       
        var Text_sumtotal = sumtotal.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        var sumtotal_tax = sumtotal_tax.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        $("#text_sum").val(Text_sumtotal);
        $("#Text_total").val(Text_sumtotal);
        $("#text_sum_tax").val(sumtotal_tax);
        chk_typeSum();
        // alert(sumtotal);
    }
    
    function SaveEdit() {
        var form_data = new FormData();
        var Cus_Code = <?= $Cus_Code ?>;
        var CusName =   '<?= $CusName ?>';
        var Area =   '<?= $Area ?>';
        var DocNoP =   '<?= $DocNoP ?>';
        var Radio_Sum= document.querySelector('input[name="Radio_Sum"]:checked').value;
        var Radiopay= document.querySelector('input[name="Radiopay"]:checked').value;
        
        var imageSlip = $('#imageSlip').prop('files')[0];
        var data_imageSlip = $('#imageSlip').data('value');
        var imageSlip2 = $('#imageSlip2').prop('files')[0];
        var data_imageSlip2 = $('#imageSlip2').data('value');

        var Select_Bank= $("#Select_Bank").val();
        var Text_branch= $("#Text_branch").val();
        var txt_dateBank= $("#txt_dateBank").val();
        var Text_total= $("#Text_total").val();

        var imageTax = $('#imageTax').prop('files')[0];
        var data_imageTax = $('#imageTax').data('value');
        var Text_taxpay= $("#Text_taxpay").val();
        var Text_totaltax= $("#Text_totaltax").val();
        var Radiotax= document.querySelector('input[name="Radiotax"]:checked').value;
        var Text_number= $("#Text_number").val();
        var Text_total_check= $("#Text_total_check").val();
        var text_sum_tax = $("#text_sum_tax").val();
      
        if (imageSlip == undefined) {
            var text_imageSlip= $("#text_imageSlip").val();
            var text_imageSlip2= $("#text_imageSlip2").val();
            var text_imageTax= $("#text_imageTax").val();
        }else{

            if (imageTax == undefined) {
                var text_imageTax= $("#text_imageTax").val();
            }else{
                var text_imageTax= "";
            }

            var text_imageSlip= "";
            var text_imageSlip2= "";
            
        }

       if(Radiopay==1){

        }else if(Radiopay==2){

            if (Select_Bank == "0") {
            swal({
                title: "กรุณาเลือกธนาคาร",
                text: "",
                type: "info",
                showConfirmButton: false,
                timer: 2000,
              });
            return;
            }

        }else{
            if (Select_Bank == "0") {
            swal({
                title: "กรุณาเลือกธนาคาร",
                text: "",
                type: "info",
                showConfirmButton: false,
                timer: 2000,
              });
            return;
            }

            if (Text_branch == "") {
                swal({
                    title: "กรุณากรอกสาขาธนาคาร",
                    text: "",
                    type: "info",
                    showConfirmButton: false,
                    timer: 2000,
                });
                return;
            }
        }



        if (Text_total == "" || Text_total == "0.00") {
            swal({
                title: "กรุณาเลือกบิลจ่าย",
                text: "",
                type: "info",
                showConfirmButton: false,
                timer: 2000,
              });
        }

        if (Text_total_check == "" || Text_total_check == "0.00") {
            swal({
                title: "กรุณากรอกยอดรวมเช็ค",
                text: "",
                type: "info",
                showConfirmButton: false,
                timer: 2000,
              });
        }

        form_data.append('FUNC_NAME', 'SaveEdit');
        
        form_data.append('DocNoP', DocNoP);
        form_data.append('Radiopay', Radiopay);
        form_data.append('imageSlip', imageSlip);
        form_data.append('data_imageSlip', data_imageSlip);
        form_data.append('imageSlip2', imageSlip2);
        form_data.append('data_imageSlip2', data_imageSlip2);

        form_data.append('Select_Bank', Select_Bank);
        form_data.append('Text_branch', Text_branch);
        form_data.append('txt_dateBank', txt_dateBank);
        form_data.append('Text_total', Text_total);

        form_data.append('imageTax', imageTax);
        form_data.append('data_imageTax', data_imageTax);
        form_data.append('Text_taxpay', Text_taxpay);
        form_data.append('Text_totaltax', Text_totaltax);
        form_data.append('Radiotax', Radiotax);
        form_data.append('Cus_Code', Cus_Code);
        form_data.append('Area', Area);
        form_data.append('text_imageSlip', text_imageSlip);
        form_data.append('text_imageSlip2', text_imageSlip2);
        form_data.append('text_imageTax', text_imageTax);
        form_data.append('Text_number', Text_number);
        form_data.append('Text_total_check', Text_total_check);
        form_data.append('text_sum_tax', text_sum_tax);
        form_data.append('Radio_Sum', Radio_Sum);

        $.ajax({
            url: "process/saveDoc_cusSale.php",
            type: 'POST',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(result) {
            //  var ObjData = JSON.parse(result);

                // addDetailEdit(result);
                // alert(result);

                swal({
                    title:'Success',
                    text: 'แก้ไขข้อมูลเรียบร้อย',
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    timer: 2000,
                    confirmButtonText: 'Ok',
                    showConfirmButton: false
                });
                setTimeout(function() {
                    showDateDetail();
                }, 500);
            }
        });


       
    }

    function SaveDoc() {
        var form_data = new FormData();
        var Cus_Code = <?= $Cus_Code ?>;
        var CusName =   '<?= $CusName ?>';
        var Area =   '<?= $Area ?>';

        var Radiopay = document.querySelector('input[name="Radiopay"]:checked').value;
        var Radio_Sum = document.querySelector('input[name="Radio_Sum"]:checked').value;

        var imageSlip = $('#imageSlip').prop('files')[0];
        var data_imageSlip = $('#imageSlip').data('value');

        var imageSlip2 = $('#imageSlip2').prop('files')[0];
        var data_imageSlip2 = $('#imageSlip2').data('value');

        var Select_Bank= $("#Select_Bank").val();
        var Text_branch= $("#Text_branch").val();
        var txt_dateBank= $("#txt_dateBank").val();
        var Text_total= $("#Text_total").val();

        var imageTax = $('#imageTax').prop('files')[0];
        var data_imageTax = $('#imageTax').data('value');
        var Text_taxpay= $("#Text_taxpay").val();
        var Text_totaltax= $("#Text_totaltax").val();
        var Radiotax= document.querySelector('input[name="Radiotax"]:checked').value;
        var Text_number= $("#Text_number").val();
        var Text_total_check= $("#Text_total_check").val();
        var text_sum_tax = $("#text_sum_tax").val();
    
    
        if (imageSlip == undefined) {
            swal({
                title: "กรุณา อัพโหลด รูป Slip",
                text: "",
                type: "info",
                showConfirmButton: false,
                timer: 2000,
              });
            return;
        }

        if(Radiopay==1){

        }else if(Radiopay==2){

            if (Select_Bank == "0") {
            swal({
                title: "กรุณาเลือกธนาคาร",
                text: "",
                type: "info",
                showConfirmButton: false,
                timer: 2000,
              });
            return;
            }

        }else{
            if (Select_Bank == "0") {
            swal({
                title: "กรุณาเลือกธนาคาร",
                text: "",
                type: "info",
                showConfirmButton: false,
                timer: 2000,
              });
            return;
            }

            if (Text_branch == "") {
                swal({
                    title: "กรุณากรอกสาขาธนาคาร",
                    text: "",
                    type: "info",
                    showConfirmButton: false,
                    timer: 2000,
                });
                return;
            }
        }



        if (Text_total == "" || Text_total == "0.00") {
            swal({
                title: "กรุณาเลือกบิลจ่าย",
                text: "",
                type: "info",
                showConfirmButton: false,
                timer: 2000,
              });
              return;
        }


        if (Text_total_check == "" || Text_total_check == "0.00") {
            swal({
                title: "กรุณากรอกยอดจ่าย",
                text: "",
                type: "info",
                showConfirmButton: false,
                timer: 2000,
              });
              return;
        }

        form_data.append('FUNC_NAME', 'SaveDoc');
        form_data.append('Radiopay', Radiopay);
        form_data.append('imageSlip', imageSlip);
        form_data.append('data_imageSlip', data_imageSlip);
        form_data.append('imageSlip2', imageSlip2);
        form_data.append('data_imageSlip2', data_imageSlip2);

        form_data.append('Select_Bank', Select_Bank);
        form_data.append('Text_branch', Text_branch);
        form_data.append('txt_dateBank', txt_dateBank);
        form_data.append('Text_total', Text_total);

        form_data.append('imageTax', imageTax);
        form_data.append('data_imageTax', data_imageTax);
        form_data.append('Text_taxpay', Text_taxpay);
        form_data.append('Text_totaltax', Text_totaltax);
        form_data.append('Radiotax', Radiotax);
        form_data.append('Cus_Code', Cus_Code);
        form_data.append('Area', Area);
        form_data.append('Text_number', Text_number);
        form_data.append('Text_total_check', Text_total_check);
        form_data.append('text_sum_tax', text_sum_tax);
        form_data.append('Radio_Sum', Radio_Sum);
        
        $.ajax({
            url: "process/saveDoc_cusSale.php",
            type: 'POST',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(result) {
            //  var ObjData = JSON.parse(result);

                addDetail(result);
                // alert(result);
            }
        });


       
    }

    function addDetail(DocNo) {
   
        var Cus_Code = <?= $Cus_Code ?>;
        var Area =   '<?= $Area ?>';
        var CusName =   '<?= $CusName ?>';

        $.ajax({
            url: "process/saveDoc_cusSale.php",
            type: 'POST',
            data: {
                'FUNC_NAME': 'addDetail',
                'DocNo': DocNo,
                'DocNO_sale': DocArray.DocNO,
                'amount': DocArray.amount,
                'Area': Area,
                'Cus_Code': Cus_Code
            },
            success: function(result) {
            swal({
                    title:'Success',
                    text: 'บันทึกข้อมูลสำเร็จ',
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    timer: 2000,
                    confirmButtonText: 'Ok',
                    showConfirmButton: false
                });
                setTimeout(function() {
                    location.href="CustomerSel_DocDetail.php?Cus_Code="+Cus_Code+"&CusName="+CusName;
                }, 1500);

            }
        });
      



       
    }

    

    

    function senddata(data) {
        var form_data = new FormData();
        form_data.append("DATA", data);
        var URL = 'process/CustomerSel_CreatcDoc.php';
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
                    if (temp["form"] == 'SearchDataSaleDoc') {
                        var StrTR = "";
                        if(temp["rCnt"]!=0){
                            for (var i = 0; i < temp["rCnt"]; i++) {
                            var chkDoc = "<input style='margin-top:5px;' type='checkbox' name='checkDoc' id='checkDoc' value='" + i + "' onclick='add_Doc(" + i + ")' ><input type='hidden' id='amountID_" + i + "' value='" + temp[i]['Total_int'] + "'><input type='hidden' id='DocNo_" + i + "' value='" + temp[i]['DocNoAcc'] + "'>";
                            StrTR +=    "<tr style='border-radius: 15px 15px 15px 15px;margin-top: 6px;margin-bottom: 6px;font-size: 15px;'>" +
                                        "<td style='width:2%;text-align: center;'>" + chkDoc + "</td>" +
                                        "<td style='width:10%;text-align: center;'>" + temp[i]["DocDate"] + "</td>" +
                                        "<td style='width:10%;text-align: center;'>" + temp[i]["DocNoAcc"] + "</td>" +
                                        "<td style='width:10%;text-align: center;'>" + temp[i]["Total"] + "</td>" +
                                        "</tr>";
						    }   
                        }else{
                            StrTR += "<tr style='border-radius: 15px 15px 15px 15px;margin-top: 6px;margin-bottom: 6px;'>" +
                                        "<td colspan='4' style='width:6.5%;text-align: center;'><center> ยังไม่มีข้อมูล </center></td>" +
                                        "</tr>";
                        }
                       
                        $('#Table_DocSale tbody').html(StrTR);             
                        $('#bt_AddDocDetail').hide();
                    }else if(temp["form"] == 'SearchDataSaleDoc_Modal'){
                    
                        var StrTR = "";
                        if(temp["rCnt"]!=0){
                            for (var i = 0; i < temp["rCnt"]; i++) {
                            var chkDoc = "<input class='form-check-input' type='radio' name='RadioModal' id='RadioModal_"+i+"' value='"+temp[i]["DocNoAcc"]+"' >";
                            StrTR +=    "<tr style='border-radius: 15px 15px 15px 15px;margin-top: 6px;margin-bottom: 6px;font-size: 15px;'>" +
                                        "<td style='width:2%;text-align: center;'>" + chkDoc + "</td>" +
                                        "<td style='width:10%;text-align: center;'>" + temp[i]["DocDate"] + "</td>" +
                                        "<td style='width:10%;text-align: center;'>" + temp[i]["DocNoAcc"] + "</td>" +
                                        "<td style='width:10%;text-align: center;'>" + temp[i]["Total"] + "</td>" +
                                        "</tr>";
						    }   
                        }else{
                            StrTR += "<tr style='border-radius: 15px 15px 15px 15px;margin-top: 6px;margin-bottom: 6px;'>" +
                                        "<td colspan='4' style='width:6.5%;text-align: center;'><center> ยังไม่มีข้อมูล </center></td>" +
                                        "</tr>";
                        }
                       
                        $('#Table_DocSaleAdd_Modal tbody').html(StrTR);         

                      

                    }else if(temp["form"] == 'getBank'){
                        $('#Select_Bank').empty();
                        var StrTr = "<option value = '0'> ---- กรุณาเลือกธนาคาร ---- </option>";

                        for (var i = 0; i < temp['rCnt']; i++) {
                             StrTr += "<option value = '"+temp[i]['id']+"'> ("+ temp[i]['BankEng'] + ") "+temp[i]['Bank']+" </option>";
                           
                        }
                        $("#Select_Bank").append(StrTr);
                    }else if(temp["form"] == 'delete_detail'){
                        swal({
                            title:'Success',
                            text: 'ลบรายการเรียบร้อย',
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            timer: 1500,
                            confirmButtonText: 'Ok',
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            SearchDataSalecDocEdit();
                            update_QtyDoc();
                        }, 300);
                    } else if(temp["form"] == 'showDateDetail'){

                        $('#txt_dateBank').val(temp[0]['dateBank']);
                        $('#Text_total').val(temp[0]['Sumtotal']);
                        $('#Select_Bank').val(temp[0]['Bank']);
                        $('#Text_branch').val(temp[0]['branch_Bank']);
                        $('#Text_taxpay').val(temp[0]['TaxPay']);
                        $('#Text_totaltax').val(temp[0]['Sumtotal_Tax']);
      
                        var Ispay = temp[0]['Ispay'];
                        if(Ispay=='1'){
                            document.getElementById("Radiopay1").checked = true;
                        }else if(Ispay=='2'){
                            document.getElementById("Radiopay2").checked = true;
                        }else{
                            document.getElementById("Radiopay2").checked = true;
                        }
                        
                        var TaxType = temp[0]['TaxType'];
                        if(TaxType =='1'){
                            document.getElementById("Radiotax1").checked = true;
                        }else{
                            document.getElementById("Radiotax2").checked = true;
                        }

                        var image = `${"imageSlip/"+temp[0]['img_slip']}`;
                        
                        if (image != "imageSlip/") {

                        var drEvent = $('#imageSlip').dropify({
                            defaultFile: image
                        });
                        drEvent = drEvent.data('dropify');
                        drEvent.resetPreview();
                        drEvent.clearElement();
                        drEvent.settings.defaultFile = image;
                        drEvent.destroy();
                        drEvent.init();
                        document.getElementById("imageSlip").src = image;

                        } else {

                        var drEvent = $('#imageSlip').dropify({
                            defaultFile: null
                            });
                            drEvent = drEvent.data('dropify');
                            drEvent.resetPreview();
                            drEvent.clearElement();
                            drEvent.settings.defaultFile = null;
                            drEvent.destroy();
                            drEvent.init();
                        // $(".dropify-clear").click();
                        }

                        //---------------------------------------------------

                        var image2 = `${"imageSlip/"+temp[0]['img_tax']}`;
                        
                        if (image2 != "imageSlip/") {

                        var drEvent = $('#imageTax').dropify({
                            defaultFile: image2
                        });
                        drEvent = drEvent.data('dropify');
                        drEvent.resetPreview();
                        drEvent.clearElement();
                        drEvent.settings.defaultFile = image2;
                        drEvent.destroy();
                        drEvent.init();
                        document.getElementById("imageTax").src = image2;

                        } else {

                        var drEvent = $('#imageTax').dropify({
                            defaultFile: null
                            });
                            drEvent = drEvent.data('dropify');
                            drEvent.resetPreview();
                            drEvent.clearElement();
                            drEvent.settings.defaultFile = null;
                            drEvent.destroy();
                            drEvent.init();
                        // $(".dropify-clear").click();
                        }
                        //--------------------------------------------------------------------------------
                        var IsStatus = temp[0]['IsStatus'];
                        var IsStatusTax = temp[0]['IsStatusTax'];
                    
                  
                        // setTimeout(() => {
                        //     // alert(image);
                        
                        //     $('#imageSlip').data("value", image);
                        //     $('#imageTax').data("value", image2);
                        //  }, 500);

                        setTimeout(function() {
                            if(IsStatus=='2'){
                            document.getElementById("txt_dateBank").disabled = true;
                            document.getElementById("Text_total").disabled = true;
                            document.getElementById("Select_Bank").disabled = true;
                            document.getElementById("Text_branch").disabled = true;
                            document.getElementById("Radiopay1").disabled = true;
                            document.getElementById("Radiopay2").disabled = true;
                            document.getElementById("Radiopay3").disabled = true;
                            document.getElementById("imageSlip").disabled = true;
                        }

                        if(IsStatusTax=='2'){
                            document.getElementById("imageTax").disabled = true;
                            document.getElementById("Text_taxpay").disabled = true;
                            document.getElementById("Radiotax1").disabled = true;
                            document.getElementById("Radiotax2").disabled = true;
                        }

                        if(IsStatus=='2'&&IsStatusTax=='2'){
                           $('#bt_SaveDoc').hide();
                        }
                        }, 100);
                        
      
                    }else if(temp["form"] == 'SearchDataSalecDocEdit'){
                        var StrTR = "";
                        if(temp["rCnt"]!=0){
                            for (var i = 0; i < temp["rCnt"]; i++) {
                                if(temp[i]["IsStatus"]!='2'){
                                    var btdelete = "<a href='javascript:void(0)' onclick='delete_detail(\"" + temp[i]['RowId'] + "\",\"" + temp[i]['IsCopy'] + "\");'><img src='img/x-button.png' style='width:30px;'></a>";
                                }else{
                                    var btdelete = "";
                                }
                           
                            StrTR +=    "<tr style='border-radius: 15px 15px 15px 15px;margin-top: 6px;margin-bottom: 6px;font-size: 15px;'>" +
                                        "<td style='width:2%;text-align: center;'>"+btdelete+"</td>" +
                                        "<td style='width:10%;text-align: center;'>" + temp[i]["DocDate"] + "</td>" +
                                        "<td style='width:10%;text-align: center;'>" + temp[i]["DocNoAcc"] + "</td>" +
                                        "<td style='width:10%;text-align: center;'>" + temp[i]["Total"] + "</td>" +
                                        "</tr>";
						    }   
                        }else{
                            StrTR += "<tr style='border-radius: 15px 15px 15px 15px;margin-top: 6px;margin-bottom: 6px;'>" +
                                        "<td colspan='4' style='width:6.5%;text-align: center;'><center> ยังไม่มีข้อมูล </center></td>" +
                                        "</tr>";
                        }

                        if(temp[0]["IsStatus"]=='2'){
                            $('#bt_AddDocDetail').hide();
                        }else{
                            $('#bt_AddDocDetail').show();
                        }

                        $('#text_sum').val(temp["Sumtotal"]);
                        $('#text_sum_tax').val(temp[0]["TaxPay"]);
                        $('#Table_DocSale tbody').html(StrTR);             
                  
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
