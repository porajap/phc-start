<?php

	
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
            	<h1> <?php echo $Area ?> : คุณ<?php echo $xName ?></h1>
				<a href="logoff.php" class="ui-btn-right ui-btn ui-btn-b ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-power">ออก</a>
			</div>
		</div>
        <div class="ui-content" data-role="main">  
            <div data-role="main" class="ui-content">
                            <form action="GetList.php" method="post">
                            	<fieldset  data-role="controlgroup" data-iconpos="left" >
                            		<?php for($i=0;$i<20;$i++){ ?>
                                                <input type="checkbox" name="check_list[]" id="checkbox-<?php echo $i ?>"  value="Sports-<?php echo $i ?>">
                                                <label  for="checkbox-<?php echo $i ?>">Sports-<?php echo $i ?></label>
                                     <?php } ?>   
                            	</fieldset>    
                                <input type="submit" />
                            </form>

             </div>
        
        </div>
</body>

</html>
