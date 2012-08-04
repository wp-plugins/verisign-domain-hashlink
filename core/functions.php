<?php
    $errors = array();
    $errors['test'] = "test";
	
	// Load all the classes
	function dhl_load($className) {
		$filename = DHL_DIRPATH . '/components/' . $className . '.php' ;
		if (file_exists($filename)) {
			include_once($filename) ;
		}
	}
	spl_autoload_register('dhl_load') ;
	
	function getv($v) {
        return isset($_GET[$v]) ? $_GET[$v] : (isset($_POST[$v]) ? $_POST[$v] : "");
	}
	
	function v_extract($dt) {
        $datalist = explode("&", $dt);
        $data = array();
        foreach($datalist as $dataelem) {
            list($t1, $t2) = explode("=", $dataelem);
            $data[$t1] = urldecode($t2);
        }
        return $data;
    }
    
    function v_compact($dt) {
        $data = "";
        if(isset($dt))
            if(count($dt))
                foreach($dt as $key => $val) {
                    $data .= ($data == "" ? "" : "&").$key."=".urlencode($val);
                }
        return $data;
    }

?>
