<?php

namespace App\Help;
use Illuminate\Support\Facades\Storage;
use App\ClimaPreguntaEmpleados;
use Illuminate\Support\Facades\URL;

class Help
{

	public static function url(){
      $url =  URL::to('/')."/";
			return $url;
	}

	 public static function yearToday(){
	 	$hoy = getdate();
	 	return $hoy['year'];
	 }


	 public static function dateYear(){
		 $hoy = getdate();
     return $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'];
	 }

	 public static function replace_char($cadena){
	 $data = array('á','é','í','ó','ú','ñ',' ');
	 $sup = array('a','e','i','o','u','n','-');
	 $a = $cadena;

	 for ($i=0; $i <count($data) ; $i++) {
		 $a = str_replace($data[$i],$sup[$i], $a);
	 }

	 $a = strtolower($a);
	 return $a;
 }


}
 ?>
