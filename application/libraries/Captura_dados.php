<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Captura_dados {


	public function getDados($ip){
		
		$ctx = stream_context_create(array(
			'http' => array(
				'timeout' => 3
				)
			)
		);
		
		
		
		@$txt = file_get_contents("http://$ip/", 0, $ctx); #teste.json
		
		if($txt == ""){
			return false;
		}
		
		$arr = json_decode($txt);
		return $arr;
	}

}

/*cad ip do arduino, sala e marca do arcond*/
