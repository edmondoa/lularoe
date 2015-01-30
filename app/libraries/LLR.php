<?php

use \SimpleXMLElement;
class LLR {

	public static function check_for_mobile($number) {
		//echo"<pre>"; print_r($number); echo"</pre>";
		if((strlen($number) != 10)||(!is_numeric($number)))
		{
			return false;
		}
		$data['npa'] = substr($number,0,3);
		$data['nxx'] = substr($number,3,3);
		$data_string = http_build_query($data);
		//echo"<pre>"; print_r($data); echo"</pre>";
		//echo"<pre>"; print_r($data_string); echo"</pre>";
		$curl_connection = curl_init('http://www.localcallingguide.com/xmlprefix.php?'.$data_string);
		curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($curl_connection);
		$data = new \SimpleXMLElement($result);
		$data_array = (array)$data->prefixdata;
		//echo"<pre>"; print_r($data_array); echo"</pre>";
		curl_close($curl_connection);		//echo $str."<br />";
		//return whether it is a wireless number
		if(!isset($data_array['company-type'])) return false;
		return ($data_array['company-type'] == "W")?true:false;
	}

	public static function _maskUrlParam($param) {
	    return str_replace('=', '', base64_encode($param));
	}

	##############################################################################################
	public static function _unmaskUrlParam($param) {
	    return base64_decode($param);
	}
?>
