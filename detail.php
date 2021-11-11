<?php
require 'connect.php';
print("<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html;  charset=tis-620\">\n");
	$Sql = "SELECT * FROM ingredient";
	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$xBarcode[$i]	= $Result["barcode"];
		$xDetail1[$i]	=  $Result["ingred1"] . " " . $Result["amount1"] . "%," . $Result["ingred2"] . " " . $Result["amount2"] . "%,";
		
		$xDetail2[$i]	=  $Result["ingred3"] . " " . $Result["amount3"] . "%," . $Result["ingred4"] . " " . $Result["amount4"] . "%,";
		
		$xDetail3[$i]	=  $Result["ingred5"] . " " . $Result["amount5"] . "%," . $Result["ingred6"] . " " . $Result["amount6"] . "%";
		
		$i++;
	}
	
	for($j=0;$j<$i;$j++){
		$Sql = "UPDATE item SET Detail1 ='$xDetail1[$j]',Detail2 ='$xDetail2[$j]',Detail3 ='$xDetail3[$j]' WHERE Barcode = '$xBarcode[$j]'";
		echo $Sql.";<br>";
		//$meQuery = mysqli_query($conn,$Sql);
	}
	
	function tis620_to_utf8($tis) {
		for( $i=0 ; $i< strlen($tis) ; $i++ ){
			$s = substr($tis, $i, 1);
			$val = ord($s);
			if( $val < 0x80 ){
				$utf8 .= $s;
			} elseif ((0xA1 <= $val and $val <= 0xDA) 
			or (0xDF <= $val and $val <= 0xFB)) {
			$unicode = 0x0E00 + $val - 0xA0;
			$utf8 .= chr( 0xE0 | ($unicode >> 12) );
			$utf8 .= chr( 0x80 | (($unicode >> 6) & 0x3F) );
			$utf8 .= chr( 0x80 | ($unicode & 0x3F) );
			}
		}
		return $utf8;
	}

	function utf8_to_tis620($string) {
		$str = $string;
		$res = "";
		for ($i = 0; $i < strlen($str); $i++) {
			if (ord($str[$i]) == 224) {
				$unicode = ord($str[$i+2]) & 0x3F;
				$unicode |= (ord($str[$i+1]) & 0x3F) << 6;
				$unicode |= (ord($str[$i]) & 0x0F) << 12;
				$res .= chr($unicode-0x0E00+0xA0);
				$i += 2;
			} else {
				$res .= $str[$i];
			}
		}
		return $res;
	}
?>
