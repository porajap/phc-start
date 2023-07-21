<?php
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
	
	function createDigit($digit) 
	{ 
		$num = strlen($digit); 
		$max = 5; 
		$zeros = $max - $num; 
		
		$new_digit = str_repeat("0", $zeros)."".$digit;	
		return $new_digit; 
	}

	function createDigit2($digit) 
	{ 
		$num = strlen($digit); 
		$max = 2; 
		$zeros = $max - $num; 
		
		$new_digit = str_repeat("0",$zeros)."".$digit;	
		return $new_digit; 
	}	
	
	function Cut100($B100)
	{
		if( strlen($B100) > 3)
			return  number_format( substr($B100,0,strlen($B100)-3) + xRound( substr($B100,strlen($B100)-3,strlen($B100)) ) ).",";
	}
	
	function xRound($RD)
	{
		if(substr($RD,0,1) < 5 )
			return 0;
		else
			return 1;
	}
	
    function getWeeks($date, $rollover)
    {
        $cut = substr($date, 0, 8);
        $daylen = 86400;

        $timestamp = strtotime($date);
        $first = strtotime($cut . "00");
        $elapsed = ($timestamp - $first) / $daylen;

        $i = 1;
        $weeks = 1;

        for($i; $i<=$elapsed; $i++)
        {
            $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
            $daytimestamp = strtotime($dayfind);

            $day = strtolower(date("l", $daytimestamp));

            if($day == strtolower($rollover))  $weeks ++;
        }

        return $weeks;
    }

	function getAddDay($date) {
		$day  = 2;
		$days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday','Thursday','Friday', 'Saturday');
    	return date('Y-m-d', strtotime($days[$day], strtotime($date)));
	}
	
	function getLastDayOfMonth($date) {
		$a_date = "$date-23";
		return  date("t", strtotime($a_date));
	}
	
	function getFirstDayOfWeek( $vl ) {
		return  createDigit2($vl[0]);
	}
	
	function getLastDayOfWeek( $vl ) {
		$n = 0;
		foreach ($vl as $value) {
			if($value == "") return $vl[$n-1];
		}
		return  createDigit2($value);
	}
?>