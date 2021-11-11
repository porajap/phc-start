<?php
session_start();
require 'connect.php';

//print("<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html;  charset=UTF-8\">\n");
	$uName = $_POST['uName'];
	$pWord = $_POST['pWord'];

	$Sql = "SELECT Employee_Code,AreaCode,FName,LName,xUname,xPword FROM employee WHERE xUname = '$uName' AND xPword = '$pWord'";
	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$Employee_Code	=  $Result["AreaCode"];
		$xName	=  $Result["FName"] . " " . $Result["LName"];
		$_SESSION["Area"] = $Employee_Code;
		$_SESSION["xName"] = $xName;
		$_SESSION["Cus_Search"] = "";
		$_SESSION["Item_Search"] = "";
		session_write_close();
		//echo $Employee_Code ." :  ".$xName . "<br>";
		//echo $Employee_Code ." :  ". $xName;
		$i++;
	}

	if($Employee_Code == "")
		header('location:index.html');
	else
		header('location:p2.php');

?>