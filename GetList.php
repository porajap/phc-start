<?php
echo "================== ";
if(!empty($_POST['check_list'])){
     foreach($_POST['check_list'] as $report_id){
        echo "$report_id was checked! ";
     }
   }
echo "================== ";
   
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Login</title>
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.min.css">
	<link rel="stylesheet" href="_assets/css/jqm-demos.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
    <link rel="stylesheet" href="css/jquery.mobile.datepicker.css">
	<script src="js/jquery.js"></script>
	<script src="js/jquery.mobile-1.4.5.min.js"></script>
    <script src="js/jquery.ui.datepicker.js"></script>
    <script id="mobile-datepicker" src="js/jquery.mobile.datepicker.js"></script>
    <script language="javascript" >

   </script>
</head>

<body>
			<div data-demo-html="true">
			<div data-role="header">
            
<?php
if(!empty($_POST['check_list'])){
     foreach($_POST['check_list'] as $report_id){
        echo "$report_id was checked! <br>";
     }
   }

?>
			</div>
		</div>
        
</body>

</html>