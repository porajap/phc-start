<?php
$mm = (int)date("m");
$sDate1 = substr(date("Y-m-d"),0,4)."-" . sprintf("%'.02d", ($mm-1)) . "-01";
echo $sDate1;
?>
