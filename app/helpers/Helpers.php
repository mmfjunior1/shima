<?php 

namespace App\helpers;

class Helpers {
 
   public static function dateFormat($data)
    {
    	if(strstr($data,"-"))
    	{
    		$data		= explode("-",$data);
    		$dia		= substr($data[2],0,2);
    		$novaData	= $dia."/".$data[1]."/".$data[0];
    		return $novaData;
    	}
    	if(strstr($data,"/"))
    	{
    		$data		= explode("/",$data);
    		$ano		= substr($data[2],0,4);
    		$novaData	= $ano."-".$data[1]."-".$data[0];
    		return $novaData;
    	}
    }
    public static function formatNumber($numero)
    {
    	return number_format($numero,2,",",".");
    }
}