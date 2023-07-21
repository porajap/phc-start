<?php
session_start();
require 'connect.php';
if ($_SESSION["Area"] == "") header('location:index.html');
$Area     = $_SESSION["Area"];
$xTitle = $_SESSION["xName"];
$xUname = $_SESSION["xUname"];
$IsShowBoothDetail = $_SESSION["IsShowBoothDetail"];
// $CusName = $_REQUEST["CusName"];
// $IsStatus = $_REQUEST["IsStatus"];
// $DocNoP = $_REQUEST["DocNoP"];
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
    <link rel="stylesheet" href="css/select2222.css">

    <script src="js/jquery/3.5.1/jquery.min.js "></script>
    <script src="assets/dist/js/bootstrap.js "></script>
    <script src="assets/dist/js/bootstrap.bundle.min.js "></script>
    <script src="assets/dist/js/sweetalert2.min.js"></script>
    <script src="assets/plugins/dropify/dist/js/dropify.min.js"></script>
    <script src="assets/datepicker/dist/js/datepicker.min.js"></script>
    <script src="assets/datepicker/dist/js/i18n/datepicker.en.js"></script>
    <script src="js/select2.min.js"></script>

    <style>
        .xTop1 {
            margin-top: 7px;
            margin-left: 1px;
            margin-right: 1px;
        }

        .xTb {
            margin-top: 7px;
            margin-left: 1px;
            margin-right: 1px;
            margin-bottom: 7px;
        }

        .label1 {
            margin-left: 10px;
            margin-top: 7px;
        }

        .label2 {
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

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 4px;
            height: 37px;
            margin-left: 1%;
        }
    </style>
</head>

<body>
    <div class="topnav">
        <a href="p2.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel ">เขตที่ : <?= $Area ?></div>
        <div class="topnav-right">
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
    </div>

    <div class="row xTop1">

    </div>
    <center>
        <h2>Exhibition Booth</h2>
    </center>
    <div class="col-12 d-flex justify-content-end px-2">
        <a href="History_Booth.php">
            <button type="button" class="btn btn-warning">ประวัติเอกสาร</button>
        </a>
    </div>
    <div class=" col-12 mt-3 mb-3" style="width: 98%;margin-left: 1%;">
        <div class="card" style="border: solid;border-color: darkgray;">

            <div class="card-body">
                <div class="row">
                    <div class="col-12 mt-3 px-3">
                        <p for="" style="font-size: 16px;font-weight: bold;" class="form-label">1.เลือกชื่อลูกค้า<span style="color: red;">*</span></p>
                        <select class="form-select js-example-basic-single form-control" aria-label="Default select example" data-live-search="true" id="Select_Customer" onchange="show_Text_Customer();" style="margin-left: 3%;">
                        </select>
                    </div>
                    <div class="col-12 mt-3 px-3" id="div_TextCustomer">
                        <p for="" style="font-size: 16px;font-weight: bold;" class="form-label"></p>
                        <input type="text" class="form-control" id="Text_Customer" placeholder="ชื่อลูกค้า" style="margin-left: 1%;">
                    </div>
                    <div class="col-12 mt-3 px-3" id="div_TextCustomer">
                        <p for="" style="font-size: 16px;font-weight: bold;" class="form-label">2.แผนก<span style="color: red;">*</span></p>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-check mb-3 mt-2" style="margin-left: 1%;">
                                    <input class="form-check-input" type="checkbox" value="IC" id="checkBox_Dap1" style="width: 25px;height: 25px;">
                                    <label class="form-check-label" for="checkBox_Dap1" style="margin-left: 10px;margin-top: 3px;">
                                        IC
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check mb-3 mt-1" style="margin-left: 1%;">
                                    <input class="form-check-input" type="checkbox" value="OR" id="checkBox_Dap2" style="width: 25px;height: 25px;">
                                    <label class="form-check-label" for="checkBox_Dap2" style="margin-left: 10px;margin-top: 3px;">
                                        OR
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check mb-3 mt-1" style="margin-left: 1%;">
                                    <input class="form-check-input" type="checkbox" value="CSSD" id="checkBox_Dap3" style="width: 25px;height: 25px;">
                                    <label class="form-check-label" for="checkBox_Dap3" style="margin-left: 10px;margin-top: 3px;">
                                        CSSD
                                    </label>
                                </div>
                            </div>


                            <div class="col-4">
                                <div class="form-check mb-3 mt-1" style="margin-left: 1%;">
                                    <input class="form-check-input" type="checkbox" value="แพทย์" id="checkBox_Dap4" style="width: 25px;height: 25px;">
                                    <label class="form-check-label" for="checkBox_Dap4" style="margin-left: 10px;margin-top: 3px;">
                                        แพทย์
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check mb-3 mt-1" style="margin-left: 1%;">
                                    <input class="form-check-input" type="checkbox" value="เภสัชกร" id="checkBox_Dap5" style="width: 25px;height: 25px;">
                                    <label class="form-check-label" for="checkBox_Dap5" style="margin-left: 10px;margin-top: 3px;">
                                        เภสัช
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check mb-3 mt-1" style="margin-left: 1%;">
                                    <input class="form-check-input" type="checkbox" value="พยาบาล" id="checkBox_Dap6" style="width: 25px;height: 25px;">
                                    <label class="form-check-label" for="checkBox_Dap6" style="margin-left: 10px;margin-top: 3px;">
                                        พยาบาล
                                    </label>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-check mb-3 mt-1" style="margin-left: 1%;">
                                    <input class="form-check-input" type="checkbox" value="0" id="checkBox_Other" style="width: 25px;height: 25px;">
                                    <label class="form-check-label" for="checkBox_Other" style="margin-left: 10px;margin-top: 3px;">
                                        อื่นๆ
                                    </label>
                                </div>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" id="Text_Dep" placeholder="ชื่อแผนก">
                            </div>
                        </div>


                    </div>
                    <div class="col-12 mt-3 px-3">
                        <p for="" style="font-size: 16px;font-weight: bold;" class="form-label">3.ชื่อผู้สนใจ<span style="color: red;">*</span></p>
                        <input type="text" class="form-control" id="Text_NameUser" placeholder="ชื่อผู้สนใจ">
                    </div>
                    <div class="col-12 mt-3 px-3">
                        <p for="" style="font-size: 16px;font-weight: bold;" class="form-label">4.เบอร์โทร</p>
                        <input type="text" class="form-control numonly" id="Text_PhoneNumber" maxlength="10" placeholder="เบอร์โทร">
                    </div>
                    <div class="col-12 mt-3 px-3">
                        <p for="" style="font-size: 16px;font-weight: bold;" class="form-label">5.สนใจผลิตภัณฑ์<span style="color: red;">*</span></p>
                        <div class="form-check mb-2 mt-2" style="margin-left: 1%;">
                            <input class="form-check-input" type="checkbox" value="เยี่ยมบูท" id="checkBox_visit_booth" style="width: 25px;height: 25px;" checked>
                            <label class="form-check-label" for="checkBox_visit_booth" style="margin-left: 10px;margin-top: 3px;">
                                เยี่ยมบูท
                            </label>
                        </div>

                        <div class="form-check mb-2 mt-2" style="margin-left: 1%;">
                            <input class="form-check-input" type="checkbox" value="Alcohol pad" id="checkBox_product_1" style="width: 25px;height: 25px;">
                            <label class="form-check-label" for="checkBox_product_1" style="margin-left: 10px;margin-top: 3px;">
                                Alcohol pad
                            </label>
                            <input type="text" class="form-control mt-2" id="Text_product_1" placeholder="รายละเอียดรายการ" style="margin-left: 0%;" hidden>
                        </div>

                        <div class="form-check mb-2 mt-2" style="margin-left: 1%;">
                            <input class="form-check-input" type="checkbox" value="Sr#3" id="checkBox_product_2" style="width: 25px;height: 25px;">
                            <label class="form-check-label" for="checkBox_product_2" style="margin-left: 10px;margin-top: 3px;">
                                Sr#3
                            </label>
                            <input type="text" class="form-control mt-2" id="Text_product_2" placeholder="รายละเอียดรายการ" style="margin-left: 0%;" hidden>
                        </div>

                        <div class="form-check mb-2 mt-2" style="margin-left: 1%;">
                            <input class="form-check-input" type="checkbox" value="Q-Bac 2A (PAD,SWAB,ขวด)" id="checkBox_product_3" style="width: 25px;height: 25px;">
                            <label class="form-check-label" for="checkBox_product_3" style="margin-left: 10px;margin-top: 3px;">
                                Q-Bac 2A (PAD,SWAB,ขวด)
                            </label>
                            <input type="text" class="form-control mt-2" id="Text_product_3" placeholder="รายละเอียดรายการ" style="margin-left: 0%;" hidden>
                        </div>

                        <div class="form-check mb-2 mt-2" style="margin-left: 1%;">
                            <input class="form-check-input" type="checkbox" value="Hand Gel" id="checkBox_product_4" style="width: 25px;height: 25px;">
                            <label class="form-check-label" for="checkBox_product_4" style="margin-left: 10px;margin-top: 3px;">
                                Hand Gel
                            </label>
                            <input type="text" class="form-control mt-2" id="Text_product_4" placeholder="รายละเอียดรายการ" style="margin-left: 0%;" hidden>
                        </div>

                        <div class="form-check mb-2 mt-2" style="margin-left: 1%;">
                            <input class="form-check-input" type="checkbox" value="Qbac 4 - Posidone Cartridge" id="checkBox_product_5" style="width: 25px;height: 25px;">
                            <label class="form-check-label" for="checkBox_product_5" style="margin-left: 10px;margin-top: 3px;">
                                Qbac 4 - Posidone Cartridge
                            </label>
                            <input type="text" class="form-control mt-2" id="Text_product_5" placeholder="รายละเอียดรายการ" style="margin-left: 0%;" hidden>
                        </div>

                        <div class="form-check mb-2 mt-2" style="margin-left: 1%;">
                            <input class="form-check-input" type="checkbox" value="Sr#1,Sr#2" id="checkBox_product_6" style="width: 25px;height: 25px;">
                            <label class="form-check-label" for="checkBox_product_6" style="margin-left: 10px;margin-top: 3px;">
                                Sr#1,Sr#2
                            </label>
                            <input type="text" class="form-control mt-2" id="Text_product_6" placeholder="รายละเอียดรายการ" style="margin-left: 0%;" hidden>
                        </div>

                        <div class="form-check mb-2 mt-2" style="margin-left: 1%;">
                            <input class="form-check-input" type="checkbox" value="Enzyne" id="checkBox_product_7" style="width: 25px;height: 25px;">
                            <label class="form-check-label" for="checkBox_product_7" style="margin-left: 10px;margin-top: 3px;">
                                Enzyne
                            </label>
                            <input type="text" class="form-control mt-2" id="Text_product_7" placeholder="รายละเอียดรายการ" style="margin-left: 0%;" hidden>
                        </div>

                        <div class="form-check mb-2 mt-2" style="margin-left: 1%;">
                            <input class="form-check-input" type="checkbox" value="High Level" id="checkBox_product_8" style="width: 25px;height: 25px;">
                            <label class="form-check-label" for="checkBox_product_8" style="margin-left: 10px;margin-top: 3px;">
                                High Level
                            </label>
                            <input type="text" class="form-control mt-2" id="Text_product_8" placeholder="รายละเอียดรายการ" style="margin-left: 0%;" hidden>
                        </div>

                        <div class="form-check mb-2 mt-2" style="margin-left: 1%;">
                            <input class="form-check-input" type="checkbox" value="Posequat pad" id="checkBox_product_9" style="width: 25px;height: 25px;">
                            <label class="form-check-label" for="checkBox_product_9" style="margin-left: 10px;margin-top: 3px;">
                                Posequat pad
                            </label>
                            <input type="text" class="form-control mt-2" id="Text_product_9" placeholder="รายละเอียดรายการ" style="margin-left: 0%;" hidden>
                        </div>
                        <!-- 
                        <div class="form-check mb-2 mt-2" style="margin-left: 1%;">
                            <input class="form-check-input" type="checkbox" value="Pose Sr# 1  stain remover" id="checkBox_product_10" style="width: 25px;height: 25px;">
                            <label class="form-check-label" for="checkBox_product_10" style="margin-left: 10px;margin-top: 3px;">
                                Pose Sr# 1 stain remover
                            </label>
                            <input type="text" class="form-control mt-2" id="Text_product_10" placeholder="รายละเอียดรายการ" style="margin-left: 0%;" hidden>
                        </div>

                        <div class="form-check mb-2 mt-2" style="margin-left: 1%;">
                            <input class="form-check-input" type="checkbox" value="Pose Sr# 2  stain remover" id="checkBox_product_11" style="width: 25px;height: 25px;">
                            <label class="form-check-label" for="checkBox_product_11" style="margin-left: 10px;margin-top: 3px;">
                                Pose Sr# 2 stain remover
                            </label>
                            <input type="text" class="form-control mt-2" id="Text_product_11" placeholder="รายละเอียดรายการ" style="margin-left: 0%;" hidden>
                        </div>

                        <div class="form-check mb-2 mt-2" style="margin-left: 1%;">
                            <input class="form-check-input" type="checkbox" value="Pose Sr# 3  stain remover" id="checkBox_product_12" style="width: 25px;height: 25px;">
                            <label class="form-check-label" for="checkBox_product_12" style="margin-left: 10px;margin-top: 3px;">
                                Pose Sr# 3 stain remover
                            </label>
                            <input type="text" class="form-control mt-2" id="Text_product_12" placeholder="รายละเอียดรายการ" style="margin-left: 0%;" hidden>
                        </div>

                        <div class="form-check mb-2 mt-2" style="margin-left: 1%;">
                            <input class="form-check-input" type="checkbox" value="Sterex" id="checkBox_product_13" style="width: 25px;height: 25px;">
                            <label class="form-check-label" for="checkBox_product_13" style="margin-left: 10px;margin-top: 3px;">
                                Sterex
                            </label>
                            <input type="text" class="form-control mt-2" id="Text_product_13" placeholder="รายละเอียดรายการ" style="margin-left: 0%;" hidden>
                        </div>

                        <div class="form-check mb-2 mt-2" style="margin-left: 1%;">
                            <input class="form-check-input" type="checkbox" value="Posequat pad" id="checkBox_product_14" style="width: 25px;height: 25px;">
                            <label class="form-check-label" for="checkBox_product_14" style="margin-left: 10px;margin-top: 3px;">
                                Posequat pad
                            </label>
                            <input type="text" class="form-control mt-2" id="Text_product_14" placeholder="รายละเอียดรายการ" style="margin-left: 0%;" hidden>
                        </div> -->



                        <div class="row">
                            <div class="col-4">
                                <div class="form-check mb-2 mt-2" style="margin-left: 1%;">
                                    <input class="form-check-input" type="checkbox" value="" id="checkBox_Other_Product" style="width: 25px;height: 25px;">
                                    <label class="form-check-label" for="checkBox_Other_Product" style="margin-left: 10px;margin-top: 3px;">
                                        อื่นๆ
                                    </label>
                                </div>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control mt-2" id="Text_Other_Product" placeholder="ชื่อกลุ่มผลิตภัณฑ์" style="margin-left: 0%;">
                            </div>
                        </div>


                    </div>
                    <div class="col-12 mt-3 px-3">
                        <p for="" style="font-size: 16px;font-weight: bold;" class="form-label">6.สถานะความเร่งด่วน<span style="color: red;">*</span></p>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="RadioStu" id="Radio_Stu_very_urgent" value="very_urgent" style="width: 25px;height: 25px;">
                            <label class="form-check-label" for="Radio_Stu_very_urgent" style="margin-left: 10px;margin-top: 3px;">ด่วนมาก</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="RadioStu" id="Radio_Stu_urgent" value="urgent" style="width: 25px;height: 25px;">
                            <label class="form-check-label" for="Radio_Stu_urgent" style="margin-left: 10px;margin-top: 3px;">ด่วน</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="RadioStu" id="Radio_Stu_normal" value="normal" checked style="width: 25px;height: 25px;">
                            <label class="form-check-label" for="Radio_Stu_normal" style="margin-left: 10px;margin-top: 3px;">ปกติ</label>
                        </div>



                    </div>
                    <div class="col-12 mt-3 px-3">
                        <p for="" style="font-size: 16px;font-weight: bold;" class="form-label">7.Note</p>
                        <input type="text" class="form-control" id="Text_Note" placeholder="Note" style="margin-left: 3%;">
                    </div>
                </div>


                <hr>
                <!-- ----------------------------------------------------------------------------------- -->


                <div class="row mt-3 ">
                    <div class="col-6">
                        <button type="submit" id="bt_SaveDoc" style="width: 100%;" class="btn btn-danger " onclick="clean();">ล้างข้อมูล</button>
                    </div>
                    <div class="col-6">
                        <button type="submit" id="bt_SaveDoc" style="width: 100%;" class="btn btn-success " onclick="Chk_Save();">บันทึกเอกสาร</button>
                    </div>

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
                        <div class="card-body" style="max-height: 350px;overflow-y: auto;">
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
                        <button type="button" id="btn_SaveAdd" class="btn btn-primary" onclick="SaveAdd_Docdetail();">เพิ่มรายการ</button>
                    </div>
                </div>
            </div>
        </div>


</body>
<script>
    $('#div_Text_Dep').hide();
    $("#div_TextCustomer").hide();
    $(document).ready(function() {
        $('.js-example-basic-single').select2();


        $('#select2-Select_Customer-container').click(function() {
            $(".select2-search__field").focus();
        });



        $("#Text_Dep").click(function() {
            $('#checkBox_Other').attr('checked', true);
            // $('#checkBox_visit_booth').attr('checked', false);
        });
        $("#Text_Other_Product").click(function() {
            $('#checkBox_Other_Product').attr('checked', true);
            $('#checkBox_visit_booth').attr('checked', false);
        });


        $("#checkBox_Other").click(function() {
            var checkBox_Other = $("#checkBox_Other").is(":checked");
            if (checkBox_Other == true) {
                $('#div_Text_Dep').show();
                $('#Text_Dep').focus();

            } else {
                $('#div_Text_Dep').hide();
            }
        });


        get_Select_Customer();

        $('.numonly').on('input', function() {
            this.value = this.value.replace(/[^0-9.]/g, ''); //<-- replace all other than given set of values
        });



        $("#checkBox_Other_Product").click(function() {
            var checkBox_product_1 = $("#checkBox_Other_Product").is(":checked");
            if (checkBox_product_1 == true) {
                $('#Text_Other_Product').focus();
                $('#checkBox_visit_booth').attr('checked', false);
            } else {

            }
        });
        $("#checkBox_product_1").click(function() {
            var checkBox_product_1 = $("#checkBox_product_1").is(":checked");
            if (checkBox_product_1 == true) {
                $('#Text_product_1').attr('hidden', false);
                $('#Text_product_1').focus();
                $('#checkBox_visit_booth').attr('checked', false);
            } else {
                $('#Text_product_1').attr('hidden', true);

            }
        });
        $("#checkBox_product_2").click(function() {
            var checkBox_product_2 = $("#checkBox_product_2").is(":checked");
            if (checkBox_product_2 == true) {
                $('#Text_product_2').attr('hidden', false);
                $('#Text_product_2').focus();
                $('#checkBox_visit_booth').attr('checked', false);
            } else {
                $('#Text_product_2').attr('hidden', true);

            }
        });
        $("#checkBox_product_3").click(function() {
            var checkBox_product_3 = $("#checkBox_product_3").is(":checked");
            if (checkBox_product_3 == true) {
                $('#Text_product_3').attr('hidden', false);
                $('#Text_product_3').focus();
                $('#checkBox_visit_booth').attr('checked', false);
            } else {
                $('#Text_product_3').attr('hidden', true);

            }
        });
        $("#checkBox_product_4").click(function() {
            var checkBox_product_4 = $("#checkBox_product_4").is(":checked");
            if (checkBox_product_4 == true) {
                $('#Text_product_4').attr('hidden', false);
                $('#Text_product_4').focus();
                $('#checkBox_visit_booth').attr('checked', false);
            } else {
                $('#Text_product_4').attr('hidden', true);

            }
        });
        $("#checkBox_product_5").click(function() {
            var checkBox_product_5 = $("#checkBox_product_5").is(":checked");
            if (checkBox_product_5 == true) {
                $('#Text_product_5').attr('hidden', false);
                $('#Text_product_5').focus();
                $('#checkBox_visit_booth').attr('checked', false);
            } else {
                $('#Text_product_5').attr('hidden', true);

            }
        });
        $("#checkBox_product_6").click(function() {
            var checkBox_product_6 = $("#checkBox_product_6").is(":checked");
            if (checkBox_product_6 == true) {
                $('#Text_product_6').attr('hidden', false);
                $('#Text_product_6').focus();
                $('#checkBox_visit_booth').attr('checked', false);
            } else {
                $('#Text_product_6').attr('hidden', true);

            }
        });
        $("#checkBox_product_7").click(function() {
            var checkBox_product_7 = $("#checkBox_product_7").is(":checked");
            if (checkBox_product_7 == true) {
                $('#Text_product_7').attr('hidden', false);
                $('#Text_product_7').focus();
                $('#checkBox_visit_booth').attr('checked', false);
            } else {
                $('#Text_product_7').attr('hidden', true);

            }
        });
        $("#checkBox_product_8").click(function() {
            var checkBox_product_8 = $("#checkBox_product_8").is(":checked");
            if (checkBox_product_8 == true) {
                $('#Text_product_8').attr('hidden', false);
                $('#Text_product_8').focus();
                $('#checkBox_visit_booth').attr('checked', false);
            } else {
                $('#Text_product_8').attr('hidden', true);

            }
        });
        $("#checkBox_product_9").click(function() {
            var checkBox_product_9 = $("#checkBox_product_9").is(":checked");
            if (checkBox_product_9 == true) {
                $('#Text_product_9').attr('hidden', false);
                $('#Text_product_9').focus();
                $('#checkBox_visit_booth').attr('checked', false);
            } else {
                $('#Text_product_9').attr('hidden', true);

            }
        });
        $("#checkBox_product_10").click(function() {
            var checkBox_product_10 = $("#checkBox_product_10").is(":checked");
            if (checkBox_product_10 == true) {
                $('#Text_product_10').attr('hidden', false);
                $('#checkBox_visit_booth').attr('checked', false);
            } else {
                $('#Text_product_10').attr('hidden', true);

            }
        });
        $("#checkBox_product_11").click(function() {
            var checkBox_product_11 = $("#checkBox_product_11").is(":checked");
            if (checkBox_product_11 == true) {
                $('#Text_product_11').attr('hidden', false);
                $('#checkBox_visit_booth').attr('checked', false);
            } else {
                $('#Text_product_11').attr('hidden', true);

            }
        });
        $("#checkBox_product_12").click(function() {
            var checkBox_product_12 = $("#checkBox_product_12").is(":checked");
            if (checkBox_product_12 == true) {
                $('#Text_product_12').attr('hidden', false);
                $('#checkBox_visit_booth').attr('checked', false);
            } else {
                $('#Text_product_12').attr('hidden', true);

            }
        });
        $("#checkBox_product_13").click(function() {
            var checkBox_product_13 = $("#checkBox_product_13").is(":checked");
            if (checkBox_product_13 == true) {
                $('#Text_product_13').attr('hidden', false);
                $('#checkBox_visit_booth').attr('checked', false);
            } else {
                $('#Text_product_13').attr('hidden', true);

            }
        });
        $("#checkBox_product_14").click(function() {
            var checkBox_product_14 = $("#checkBox_product_14").is(":checked");
            if (checkBox_product_14 == true) {
                $('#Text_product_14').attr('hidden', false);
                $('#checkBox_visit_booth').attr('checked', false);
            } else {
                $('#Text_product_14').attr('hidden', true);

            }
        });


    });


    function chkRadio_Tax() {

        var Radiotax = document.querySelector('input[name="Radiotax"]:checked').value;

        if (Radiotax == 1) {
            $("#div_imageTax").show();

            $("#div_Text_totaltax").show();
        } else if (Radiotax == 3) {
            $("#div_imageTax").hide();

            $("#div_Text_totaltax").hide();
        } else if (Radiotax == 2) {
            $("#div_imageTax").hide();

            $("#div_Text_totaltax").show();
        }
    }

    function get_Select_Customer() {

        $.ajax({
            url: "process/Add_Booth.php",
            type: 'POST',
            data: {
                'FUNC_NAME': 'get_Select_Customer'
            },
            success: function(result) {
                var ObjData = JSON.parse(result);
                $("#Select_Customer").empty();
                var Str = "";
                Str += "<option value=00 >เลือกชื่อลูกค้า</option>";
                if (!$.isEmptyObject(ObjData)) {
                    $.each(ObjData, function(key, value) {
                        Str += "<option value=" + value.Cus_Code + " >" + value.FName + "</option>";

                    });
                }
                Str += "<option value=0 > อื่นๆ </option>";
                $("#Select_Customer").append(Str);

            }
        });

    }


    function show_Text_Customer() {
        var Select_Customer = $("#Select_Customer").val();
        if (Select_Customer == '0') {
            $("#div_TextCustomer").show();
        } else {
            $("#div_TextCustomer").hide();
        }

    }


    function Chk_Save() {

        swal({
            title: "ยืนยันการบันทึกข้อมูล",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "ยืนยัน",
            cancelButtonText: "ยกเลิก",
            confirmButtonColor: '#228B22',
            cancelButtonColor: '#d33',
            closeOnConfirm: false,
            closeOnCancel: false,
            reverseButtons: true,
        }).then(result => {
            if (result.value) {
                SaveAdd_Booth();
            } else if (result.dismiss == 'cancel') {
                swal.close();
            }
        });
    }

    var CustomerArray = {};
    CustomerArray.NameCustomer = [];

    var product = {};
    product.NameProduct = [];
    product.DetailProduct = [];


    function SaveAdd_Booth() {
        var xUname = '<?= $xUname ?>';
        var Area = '<?= $Area ?>';
        var Select_Customer = $("#Select_Customer").val();
        var Text_NameUser = $("#Text_NameUser").val();
        var Text_PhoneNumber = $("#Text_PhoneNumber").val();
        var RadioStu = document.querySelector('input[name="RadioStu"]:checked').value;
        var Text_Note = $("#Text_Note").val();
        var Cus_Code = $("#Select_Customer").val();
        if (Select_Customer == '0') {
            var Select_Customer = $("#Text_Customer").val();

            if (Select_Customer == "") {
                swal({
                    title: "กรุณากรอกชื่อลูกค้า",
                    text: "",
                    type: "info",
                    showConfirmButton: false,
                    timer: 2000,
                });
                return;
            }

        }

        if (Select_Customer == "00") {
            swal({
                title: "กรุณาเลือกลูกค้า",
                text: "",
                type: "info",
                showConfirmButton: false,
                timer: 2000,
            });
            return;
        }



        var checkBox_Dap1 = $("#checkBox_Dap1").is(":checked");
        if (checkBox_Dap1 == true) {
            var NameCustomer_Dap1 = $("#checkBox_Dap1").val();
            CustomerArray.NameCustomer.push(NameCustomer_Dap1);
        } else {

        }

        var checkBox_Dap2 = $("#checkBox_Dap2").is(":checked");
        if (checkBox_Dap2 == true) {
            var NameCustomer_Dap2 = $("#checkBox_Dap2").val();
            CustomerArray.NameCustomer.push(NameCustomer_Dap2);
        } else {

        }

        var checkBox_Dap3 = $("#checkBox_Dap3").is(":checked");
        if (checkBox_Dap3 == true) {
            var NameCustomer_Dap3 = $("#checkBox_Dap3").val();
            CustomerArray.NameCustomer.push(NameCustomer_Dap3);
        } else {

        }

        var checkBox_Dap4 = $("#checkBox_Dap4").is(":checked");
        if (checkBox_Dap4 == true) {
            var NameCustomer_Dap4 = $("#checkBox_Dap4").val();
            CustomerArray.NameCustomer.push(NameCustomer_Dap4);
        } else {

        }

        var checkBox_Dap5 = $("#checkBox_Dap5").is(":checked");
        if (checkBox_Dap5 == true) {
            var NameCustomer_Dap5 = $("#checkBox_Dap5").val();
            CustomerArray.NameCustomer.push(NameCustomer_Dap5);
        } else {

        }

        var checkBox_Dap6 = $("#checkBox_Dap6").is(":checked");
        if (checkBox_Dap6 == true) {
            var NameCustomer_Dap6 = $("#checkBox_Dap6").val();
            CustomerArray.NameCustomer.push(NameCustomer_Dap6);
        } else {

        }

        var checkBox_Other = $("#checkBox_Other").is(":checked");
        if (checkBox_Other == true) {
            var NameCustomer_Other = $("#Text_Dep").val();

            if (NameCustomer_Other == "") {
                swal({
                    title: "กรุณากรอกชื่อแผนก",
                    text: "",
                    type: "info",
                    showConfirmButton: false,
                    timer: 2000,
                });
                product.NameProduct = [];
                product.DetailProduct = [];
                CustomerArray.NameCustomer = [];
                return;
            } else {
                CustomerArray.NameCustomer.push(NameCustomer_Other);
            }

        } else {

        }

        if (CustomerArray.NameCustomer == "") {
            swal({
                title: "กรุณาเลือกแผนก",
                text: "",
                type: "info",
                showConfirmButton: false,
                timer: 2000,
            });
            product.NameProduct = [];
            product.DetailProduct = [];
            CustomerArray.NameCustomer = [];
            return;
        }
        //----------------------------------------------------------------------------          


        var checkBox_visit_booth = $("#checkBox_visit_booth").is(":checked");
        if (checkBox_visit_booth == true) {
            var NameProduct_visit_booth = $("#checkBox_visit_booth").val();
            product.NameProduct.push(NameProduct_visit_booth);
            product.DetailProduct.push("");
        } else {

        }

        var checkBox_product_1 = $("#checkBox_product_1").is(":checked");
        if (checkBox_product_1 == true) {
            var NameProduct_product_1 = $("#checkBox_product_1").val();
            var Text_product_1 = $("#Text_product_1").val();

            product.NameProduct.push(NameProduct_product_1);
            product.DetailProduct.push(Text_product_1);


        } else {

        }

        var checkBox_product_2 = $("#checkBox_product_2").is(":checked");
        if (checkBox_product_2 == true) {
            var NameProduct_product_2 = $("#checkBox_product_2").val();
            var Text_product_2 = $("#Text_product_2").val();

            product.NameProduct.push(NameProduct_product_2);
            product.DetailProduct.push(Text_product_2);


        } else {

        }

        var checkBox_product_3 = $("#checkBox_product_3").is(":checked");
        if (checkBox_product_3 == true) {
            var NameProduct_product_3 = $("#checkBox_product_3").val();
            var Text_product_3 = $("#Text_product_3").val();

            product.NameProduct.push(NameProduct_product_3);
            product.DetailProduct.push(Text_product_3);


        } else {

        }

        var checkBox_product_4 = $("#checkBox_product_4").is(":checked");
        if (checkBox_product_4 == true) {
            var NameProduct_product_4 = $("#checkBox_product_4").val();
            var Text_product_4 = $("#Text_product_4").val();

            product.NameProduct.push(NameProduct_product_4);
            product.DetailProduct.push(Text_product_4);


        } else {

        }

        var checkBox_product_5 = $("#checkBox_product_5").is(":checked");
        if (checkBox_product_5 == true) {
            var NameProduct_product_5 = $("#checkBox_product_5").val();
            var Text_product_5 = $("#Text_product_5").val();

            product.NameProduct.push(NameProduct_product_5);
            product.DetailProduct.push(Text_product_5);


        } else {

        }

        var checkBox_product_6 = $("#checkBox_product_6").is(":checked");
        if (checkBox_product_6 == true) {
            var NameProduct_product_6 = $("#checkBox_product_6").val();
            var Text_product_6 = $("#Text_product_6").val();

            product.NameProduct.push(NameProduct_product_6);
            product.DetailProduct.push(Text_product_6);


        } else {

        }

        var checkBox_product_7 = $("#checkBox_product_7").is(":checked");
        if (checkBox_product_7 == true) {
            var NameProduct_product_7 = $("#checkBox_product_7").val();
            var Text_product_7 = $("#Text_product_7").val();

            product.NameProduct.push(NameProduct_product_7);
            product.DetailProduct.push(Text_product_7);


        } else {

        }

        var checkBox_product_8 = $("#checkBox_product_8").is(":checked");
        if (checkBox_product_8 == true) {
            var NameProduct_product_8 = $("#checkBox_product_8").val();
            var Text_product_8 = $("#Text_product_8").val();

            product.NameProduct.push(NameProduct_product_8);
            product.DetailProduct.push(Text_product_8);


        } else {

        }

        var checkBox_product_9 = $("#checkBox_product_9").is(":checked");
        if (checkBox_product_9 == true) {
            var NameProduct_product_9 = $("#checkBox_product_9").val();
            var Text_product_9 = $("#Text_product_9").val();

            product.NameProduct.push(NameProduct_product_9);
            product.DetailProduct.push(Text_product_9);


        } else {

        }

        var checkBox_product_10 = $("#checkBox_product_10").is(":checked");
        if (checkBox_product_10 == true) {
            var NameProduct_product_10 = $("#checkBox_product_10").val();
            var Text_product_10 = $("#Text_product_10").val();

            product.NameProduct.push(NameProduct_product_10);
            product.DetailProduct.push(Text_product_10);


        } else {

        }

        var checkBox_product_11 = $("#checkBox_product_11").is(":checked");
        if (checkBox_product_11 == true) {
            var NameProduct_product_11 = $("#checkBox_product_11").val();
            var Text_product_11 = $("#Text_product_11").val();

            product.NameProduct.push(NameProduct_product_11);
            product.DetailProduct.push(Text_product_11);


        } else {

        }

        var checkBox_product_12 = $("#checkBox_product_12").is(":checked");
        if (checkBox_product_12 == true) {
            var NameProduct_product_12 = $("#checkBox_product_12").val();
            var Text_product_12 = $("#Text_product_12").val();

            product.NameProduct.push(NameProduct_product_12);
            product.DetailProduct.push(Text_product_12);


        } else {

        }

        var checkBox_product_13 = $("#checkBox_product_13").is(":checked");
        if (checkBox_product_13 == true) {
            var NameProduct_product_13 = $("#checkBox_product_13").val();
            var Text_product_13 = $("#Text_product_13").val();

            product.NameProduct.push(NameProduct_product_13);
            product.DetailProduct.push(Text_product_13);


        } else {

        }

        var checkBox_product_14 = $("#checkBox_product_14").is(":checked");
        if (checkBox_product_14 == true) {
            var NameProduct_product_14 = $("#checkBox_product_14").val();
            var Text_product_14 = $("#Text_product_14").val();

            product.NameProduct.push(NameProduct_product_14);
            product.DetailProduct.push(Text_product_14);


        } else {

        }

        var checkBox_product_15 = $("#checkBox_product_15").is(":checked");
        if (checkBox_product_15 == true) {
            var NameProduct_product_15 = $("#checkBox_product_15").val();
            var Text_product_15 = $("#Text_product_15").val();

            product.NameProduct.push(NameProduct_product_15);
            product.DetailProduct.push(Text_product_15);


        } else {

        }



        var checkBox_Other_Product = $("#checkBox_Other_Product").is(":checked");
        if (checkBox_Other_Product == true) {
            var NameProduct_Other_Product = $("#Text_Other_Product").val();

            if (NameProduct_Other_Product == "") {
                swal({
                    title: "กรุณากรอกชื่อผลิตภัณฑ์",
                    text: "",
                    type: "info",
                    showConfirmButton: false,
                    timer: 2000,
                });
                product.NameProduct = [];
                product.DetailProduct = [];
                CustomerArray.NameCustomer = [];
                return;
            } else {
                product.NameProduct.push(NameProduct_Other_Product);
            }

        } else {

        }



        var findDuplicates = arr => arr.filter((item, index) => arr.indexOf(item) != index)
        var NameCustomer_chk = findDuplicates(CustomerArray.NameCustomer);

        CustomerArray.NameCustomer = Array.from(new Set(CustomerArray.NameCustomer));

        $.each(CustomerArray.NameCustomer, function(key, value) {
            if (value == NameCustomer_chk) {
                CustomerArray.NameCustomer.splice(key, 1);
            }
            // alert(value+"|"+IDdep_chk+"|"+key);
        });

        var findDuplicates = arr => arr.filter((item, index) => arr.indexOf(item) != index)
        var NameProduct_chk = findDuplicates(product.NameProduct);

        product.NameProduct = Array.from(new Set(product.NameProduct));

        $.each(product.NameProduct, function(key, value) {
            if (value == NameProduct_chk) {
                product.NameProduct.splice(key, 1);
                product.DetailProduct.splice(key, 1);
            }
            // alert(value+"|"+IDdep_chk+"|"+key);
        });



        if (Text_NameUser == "") {
            swal({
                title: "กรุณากรอกชื่อผู้สนใจ",
                text: "",
                type: "info",
                showConfirmButton: false,
                timer: 2000,
            });
            product.NameProduct = [];
            product.DetailProduct = [];
            CustomerArray.NameCustomer = [];
            return;
        }


        if (product.NameProduct == "") {
            swal({
                title: "กรุณาเลือกผลิตภัณฑ์",
                text: "",
                type: "info",
                showConfirmButton: false,
                timer: 2000,
            });
            product.NameProduct = [];
            product.DetailProduct = [];
            CustomerArray.NameCustomer = [];
            return;

        }



        $.ajax({
            url: "process/Add_Booth.php",
            type: 'POST',
            data: {
                'FUNC_NAME': 'SaveAdd_Booth',
                'xUname': xUname,
                'Area': Area,
                'Select_Customer': Select_Customer,
                'Text_NameUser': Text_NameUser,
                'Text_PhoneNumber': Text_PhoneNumber,
                'RadioStu': RadioStu,
                'Text_Note': Text_Note,
                'NameCustomer': CustomerArray.NameCustomer,
                'NameProduct': product.NameProduct,
                'DetailProduct': product.DetailProduct,
                'Cus_Code': Cus_Code
            },
            success: function(result) {
                swal({
                    title: 'Success',
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
                    location.reload();
                }, 500);

            }
        });

    }

    function clean() {
        location.reload();
    }

    // function showDateDetail() {
    //     var DocNoPs = '<?= $DocNoP ?>';

    //     $.ajax({
    //         url: "process/saveDoc_cusSale.php",
    //         type: 'POST',
    //         data: {
    //             'FUNC_NAME': 'showDateDetail',
    //             'DocNoPs': DocNoPs
    //         },
    //         success: function(result) {
    //             var ObjData = JSON.parse(result);

    //           if (!$.isEmptyObject(ObjData)) {
    //             $.each(ObjData, function(key, value) {

    //                     $('#txt_dateBank').val(value.dateBank);
    //                     $('#Text_total').val(value.Sumtotal);
    //                     $('#Select_Bank').val(value.Bank);
    //                     $('#Text_branch').val(value.branch_Bank);
    //                     $('#Text_taxpay').val(value.TaxPay);
    //                     $('#Text_totaltax').val(value.Sumtotal_Tax);
    //                     $('#text_imageSlip').val(value.img_slip);
    //                     $('#text_imageSlip2').val(value.img_slip2);
    //                     $('#text_imageSlip3').val(value.img_slip3);
    //                     $('#text_imageTax').val(value.img_tax);
    //                     $('#Text_number').val(value.check_number);
    //                     $('#Text_total_check').val(value.SlipPay);



    //                     var Ispay = value.Ispay;
    //                     if(Ispay=='1'){
    //                         document.getElementById("Radiopay1").checked = true;
    //                     }else if(Ispay=='2'){
    //                         document.getElementById("Radiopay2").checked = true;
    //                     }else{
    //                         document.getElementById("Radiopay3").checked = true;
    //                     }

    //                     var TaxType = value.TaxType;
    //                     if(TaxType =='1'){
    //                         document.getElementById("Radiotax1").checked = true;
    //                         $("#div_imageTax").show();
    //                         $("#div_Text_totaltax").show();
    //                     }else if(TaxType =='2'){
    //                         document.getElementById("Radiotax2").checked = true;
    //                         $("#div_imageTax").hide();
    //                         $("#div_Text_totaltax").hide();
    //                     }else{
    //                         document.getElementById("Radiotax3").checked = true;
    //                         $("#div_imageTax").hide();
    //                         $("#div_Text_totaltax").hide();
    //                     }

    //                     var Type_sum = value.Type_sum;
    //                     if(Type_sum =='1'){
    //                         document.getElementById("Radio_Sum1").checked = true;
    //                     }else{
    //                         document.getElementById("Radio_Sum2").checked = true;
    //                     }



    //                     var image = `${"imageSlip/"+value.img_slip}`;


    //                     if (image != "imageSlip/") {

    //                     var drEvent = $('#imageSlip').dropify({
    //                         defaultFile: image
    //                     });
    //                     drEvent = drEvent.data('dropify');
    //                     drEvent.resetPreview();
    //                     drEvent.clearElement();
    //                     drEvent.settings.defaultFile = image;
    //                     drEvent.destroy();
    //                     drEvent.init();
    //                     document.getElementById("imageSlip").src = image;

    //                     } else {

    //                     var drEvent = $('#imageSlip').dropify({
    //                         defaultFile: null
    //                         });
    //                         drEvent = drEvent.data('dropify');
    //                         drEvent.resetPreview();
    //                         drEvent.clearElement();
    //                         drEvent.settings.defaultFile = null;
    //                         drEvent.destroy();
    //                         drEvent.init();
    //                     // $(".dropify-clear").click();
    //                     }
    //                 //------------------------------------------------------------
    //                  var image2 = `${"imageSlip/"+value.img_slip2}`;

    //                     if (image2 != "imageSlip/") {

    //                     var drEvent = $('#imageSlip2').dropify({
    //                         defaultFile: image2
    //                     });
    //                     drEvent = drEvent.data('dropify');
    //                     drEvent.resetPreview();
    //                     drEvent.clearElement();
    //                     drEvent.settings.defaultFile = image2;
    //                     drEvent.destroy();
    //                     drEvent.init();
    //                     document.getElementById("imageSlip2").src = image2;

    //                     } else {

    //                     var drEvent = $('#imageSlip2').dropify({
    //                         defaultFile: null
    //                         });
    //                         drEvent = drEvent.data('dropify');
    //                         drEvent.resetPreview();
    //                         drEvent.clearElement();
    //                         drEvent.settings.defaultFile = null;
    //                         drEvent.destroy();
    //                         drEvent.init();
    //                     // $(".dropify-clear").click();
    //                     }

    //                 //------------------------------------------------------------
    //                  var image3 = `${"imageSlip/"+value.img_slip3}`;

    //                     if (image3 != "imageSlip/") {

    //                     var drEvent = $('#imageSlip3').dropify({
    //                         defaultFile: image3
    //                     });
    //                     drEvent = drEvent.data('dropify');
    //                     drEvent.resetPreview();
    //                     drEvent.clearElement();
    //                     drEvent.settings.defaultFile = image3;
    //                     drEvent.destroy();
    //                     drEvent.init();
    //                     document.getElementById("imageSlip3").src = image3;

    //                     } else {

    //                     var drEvent = $('#imageSlip3').dropify({
    //                         defaultFile: null
    //                         });
    //                         drEvent = drEvent.data('dropify');
    //                         drEvent.resetPreview();
    //                         drEvent.clearElement();
    //                         drEvent.settings.defaultFile = null;
    //                         drEvent.destroy();
    //                         drEvent.init();
    //                     // $(".dropify-clear").click();
    //                     }


    //                 //---------------------------------------------------

    //                     var imagetax = `${"imageSlip/"+value.img_tax}`;

    //                     if (imagetax != "imageSlip/") {

    //                     var drEvent = $('#imageTax').dropify({
    //                         defaultFile: imagetax
    //                     });
    //                     drEvent = drEvent.data('dropify');
    //                     drEvent.resetPreview();
    //                     drEvent.clearElement();
    //                     drEvent.settings.defaultFile = imagetax;
    //                     drEvent.destroy();
    //                     drEvent.init();
    //                     document.getElementById("imageTax").src = imagetax;

    //                     } else {

    //                     var drEvent = $('#imageTax').dropify({
    //                         defaultFile: null
    //                         });
    //                         drEvent = drEvent.data('dropify');
    //                         drEvent.resetPreview();
    //                         drEvent.clearElement();
    //                         drEvent.settings.defaultFile = null;
    //                         drEvent.destroy();
    //                         drEvent.init();
    //                     // $(".dropify-clear").click();
    //                     }
    //             //--------------------------------------------------------------------------------
    //                 setTimeout(() => {
    //                 $('#imageSlip').data("value", value.img_slip);
    //                 $('#imageSlip2').data("value", value.img_slip2);
    //                 $('#imageSlip3').data("value", value.img_slip3);   
    //                 $('#imageTax').data("value", value.img_tax);   
    //                 }, 300);

    //                 // setTimeout(() => {
    //                 //     alert($('#imageTax').data("value"));
    //                 // }, 500);



    //                     var IsStatus = value.IsStatus;
    //                     var IsStatusTax = value.IsStatusTax;



    //                     setTimeout(function() {
    //                         if(IsStatus=='2'){
    //                         document.getElementById("txt_dateBank").disabled = true;
    //                         document.getElementById("Text_total").disabled = true;
    //                         document.getElementById("Select_Bank").disabled = true;
    //                         document.getElementById("Text_branch").disabled = true;
    //                         document.getElementById("Radiopay1").disabled = true;
    //                         document.getElementById("Radiopay2").disabled = true;
    //                         document.getElementById("Radiopay3").disabled = true;
    //                         document.getElementById("imageSlip").disabled = true;
    //                         document.getElementById("imageSlip2").disabled = true;
    //                         document.getElementById("imageSlip3").disabled = true;
    //                         document.getElementById("Text_total_check").disabled = true;
    //                     }

    //                     if(IsStatusTax=='2'){
    //                         document.getElementById("imageTax").disabled = true;
    //                         document.getElementById("Text_taxpay").disabled = true;
    //                         document.getElementById("Radiotax1").disabled = true;
    //                         document.getElementById("Radiotax2").disabled = true;
    //                     }

    //                     if(IsStatus=='2'&&IsStatusTax=='2'){
    //                        $('#bt_SaveDoc').hide();
    //                     }
    //                     }, 100);

    //                     setTimeout(function() {
    //                         chk_typeSum();
    //                     }, 400);

    //             });
    //           }

    //         }
    //     });
    // }
</script>

</html>