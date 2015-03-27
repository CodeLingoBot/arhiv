<?php 
	
	// iz nekog razloga automatska funkcija ispod ne radi

	function prevediOblast($sirovo){
		if($sirovo==2) {
			$sirovo="Crna Gora";
		}
		if($sirovo==3) {
			$sirovo="Bosna i Hercegovina";
		}
		if($sirovo==4) {
			$sirovo="Hrvatska";
		}
		if($sirovo==5) {
			$sirovo="Slovenija";
		}
		if($sirovo==6) {
			$sirovo="Jadran";
		}
		if($sirovo==7) {
			$sirovo="NDH";
		}
		if($sirovo==8) {
			$sirovo="Dalmacija";
		}
		if($sirovo==9) {
			$sirovo="Slavonija";
		}
		if($sirovo==10) {
			$sirovo="Vojvodina";
		}
		if($sirovo==11) {
			$sirovo="Srbija";
		}
		if($sirovo==12) {
			$sirovo="Sandžak";
		}
		if($sirovo==13) {
			$sirovo="Srem";
		}
		if($sirovo==15) {
			$sirovo="Kosovo i Metohija";
		}
		if($sirovo==16) {
			$sirovo="Makedonija";
		}
		if($sirovo==17) {
			$sirovo="Italijanska okupaciona zona";
		}
		if($sirovo==18) {
			$sirovo="Jugoslavija";
		}
		if($sirovo==19) {
			$sirovo="Albanija";
		}
		if($sirovo==20) {
			$sirovo="Bugarska";
		}
		if($sirovo==21) {
			$sirovo="Nemačka";
		}
		if($sirovo==22) {
			$sirovo="SSSR";
		}
		if($sirovo==23) {
			$sirovo="Italija";
		}
		if($sirovo==24) {
			$sirovo="Kairo";
		}
		if($sirovo==25) {
			$sirovo="Alžir";
		}	
		if($sirovo==26) {
			$sirovo="Sredozemlje";
		}
		if($sirovo==27) {
			$sirovo="Austrija";
		}
		if($sirovo==28) {
			$sirovo="Grčka";
		}
		return $sirovo;
	}
	
	/*
	function prevediOblast($sirovo) {
		$upit = "SELECT naziv FROM mesta WHERE id='$sirovo'; ";
		$rezultat = mysqli_query($konekcija,$upit);
		$red = mysqli_fetch_assoc($rezultat);
		$sirovo = $red['naziv'];
		return $sirovo;
	}
	*/

?>