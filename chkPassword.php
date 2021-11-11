<?php
session_start();
require 'connect.php';
	$pWordN = $_POST['pWordN'];
	$pWordC = $_POST['pWordC'];

	if($pWordN == $pWordC){
		$Sql = "UPDATE employee SET xPword = '".$pWordN."' WHERE Employee_Code = '" . $_SESSION["Area"] . "'";
		$meQuery = mysqli_query($conn,$Sql);
		header('location:index.html');
	}else{
		header('location:cPassword.php');
	}
?>