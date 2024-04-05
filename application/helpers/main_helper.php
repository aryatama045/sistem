<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/***
	* Debug Error
*/

	if(! function_exists("tesx")) {

		/**  Error Tracing */
		function tesx()
		{
			$env = (ENVIRONMENT == 'production') ? 'none' : 'block; background-color: #c7c5b2;';
			$args = func_get_args();
			if(is_array($args) && count($args)){ foreach($args as $x){
				$echo = "<div style='display:$env'><pre style='padding: 1rem;'>";
				if(is_array($x) || is_object($x)){
					$echo .= print_r($x, true);
				}else{
					$echo .= var_export($x, true);
				}
				$echo .= "</pre><hr /></div>";
				echo $echo;
			}}
			die();
		}
	}

/*** -- END Debug Error -- */


/*** Convert Text
	* - Unstrip
	* - Strip
	* - Lowecase
	* - Uppercase
	* - Capital
 */

	if(! function_exists("un_strip")) {
		function un_strip($val){
			$string = str_replace(array('_', '.', '?'), ' ', $val);
			return $string;
		}
	}

	if(! function_exists("to_strip")) {
		function to_strip($val){
			$string = strtolower(str_replace(array(' ', '.', '?'), '_', $val));
			return $string;
		}
	}

	if(! function_exists("lowercase")) {
		function lowercase($val){
			$string = strtolower(str_replace(array('_', '.', '?'), ' ', $val));
			return $string;
		}
	}

	if(! function_exists("uppercase")) {
		function uppercase($val){
			$string = strtoupper(str_replace(array('_', '.', '?'), ' ', $val));
			return $string;
		}
	}

	if(! function_exists("capital")) {
		function capital($val){
			$string = ucwords(str_replace(array('_', '.', '?'), ' ', $val));
			return $string;
		}
	}

/** -- END Convert Text  -- */



/**  Convert Date & Numeric */

	if(! function_exists("nominal")) {
		function nominal($angka){
			$jd = number_format($angka,2,',','.');
			return $jd;
		}
	}

	if(! function_exists("diskon")) {
		function diskon($angka){
			$jd = number_format($angka,1,',','.').' %';
			return $jd;
		}
	}

	if(! function_exists("tanggal_indo")) {
		function tanggal_indo($date){
			date_default_timezone_set('Asia/Jakarta');
			// array hari dan bulan
			$Hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
			$Bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

			// pemisahan tahun, bulan, hari, dan waktu
			$tahun = substr($date,0,4);
			$bulan = substr($date,5,2);
			$tgl = substr($date,8,2);
			$waktu = substr($date,11,5);
			$hari = date("w",strtotime($date));
			$result = $Hari[$hari];

			return $result;
		}
	}

	if(! function_exists("time_ago")) {
		function time_ago($time, $now)
		{
			$periods = array("detik", "menit", "jam", "hari", "minggu", "bulan", "tahun", "decade");
			$lengths = array("60","60","24","7","4.35","12","10");

			if($now == NULL){
				$now = time();
			}

			$difference     = $now - $time;
			$tense         = "ago";

			for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
				$difference /= $lengths[$j];
			}

			$difference = round($difference);

			if($difference != 1) {
				$periods[$j].= "s";
			}

			return "$difference $periods[$j] ";
		}
	}

	if(! function_exists("selisih_jam")) {
		function selisih_jam($time, $now){

			$diff  = $now-$time;
			$jam   = floor($diff / (60 * 60));
			$menit = $diff - ( $jam * (60 * 60) );
			$detik = $diff % 60;

			$result = $jam . ' Jam : ' . floor( $menit / 60 ) . ' Menit : ' .$detik. ' Detik';
			// tesx($result);
			return $result;
		}
	}

/**  End Convert Date & Numeric */



/**  Helper Auth User */

	if(! function_exists("check")) {

		/** Check if current user is logged in. */
		function check()
		{
			$auth = new Auth();
			return $auth->loginStatus();
		}
	}

	if(! function_exists("can")) {

		/**  Check if current user has a permission by its name.
		 *   Example: if( can('edit-posts') ) {} or if( can(['edit-posts', 'publish-posts']) ) {}
		 */
		function can($permissions)
		{
			$auth = new Auth();
			return $auth->can($permissions);
		}
	}

	if(! function_exists("hasRole")) {

		/**  Checks if the current user has a role by its name. */
		function hasRole($roles)
		{
			$auth = new Auth();
			return $auth->hasRole($roles);
		}
	}

/** End Helper Auth User */