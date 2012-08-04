<?php
define('DHL_UNKNOWN_ERROR', DHLOutput::__("Connection Error"));

    $suba = getv("suba");
    $errors = Array();
        
    // is cURL installed yet?
    if (!function_exists('curl_init')){
        die('Sorry cURL is not installed!');
    }
 
    // OK cool - then let's create a new cURL resource handle
    $ch = curl_init(); 
    // Now set some options (most are optional)
    
    // chop off last ampersand
    //$encoded = substr($encoded, 0, strlen($encoded)-1);

    // Set URL to download
    $ifRequestURL = DHL_WEBSERVICE."domain/".DHL_HOSTNAME."/iframe";
	
	$jsid 	 = DHLSettings::getVal('dhl_sessionid');
	$jsidstr = is_array($jsid) ? implode(';',$jsid) : $jsid;
    if(DHL_DEBUG) {
        echo "jsidstr:" . $jsidstr . "<br/>";
    }
    
    curl_setopt($ch, CURLOPT_URL, $ifRequestURL);
    curl_setopt($ch, CURLOPT_HEADER, 0); // Include header in result? (0 = yes, 1 = no)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Should cURL return or print out the data? (true = return, false = print)
    curl_setopt($ch, CURLOPT_TIMEOUT, DHL_TIMEOUT); // Timeout in seconds
    curl_setopt($ch, CURLOPT_COOKIE, $jsidstr);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, DHL_VERIFYPEER);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    $output = curl_exec($ch); // Download the given URL, and return output
    
    if(DHL_DEBUG) {
		$info = curl_getinfo($ch);
		echo "<pre>";
		print_r($info);
        echo "<div style='border: 1px solid green; padding: 5px;'><div style='font-weight: bold;'>Manage:</div><div>$ifRequestURL</div>";
        print_r(json_decode($output));
        echo "<br />[".DHLSettings::getVal('dhl_sessionid')."]<br />".curl_error($ch);
    
        echo "<div style='border: 2px solid orange; padding: 5px; margin-bottom: 5px;'>".curl_getinfo($ch, CURLINFO_HEADER_OUT)."</div>";
        echo "</div>";
    }
    
    // Close the cURL resource, and free system resources
    curl_close($ch);
    
    $vl = json_decode($output);
    $vl->code = isset($vl->key) ? 100001 : 0;
    
    if($vl->code != 100001)
        $errors['main'] = isset($vl->message) ? $vl->message : DHL_UNKNOWN_ERROR;
    
    include DHL_DIRPATH."views/manage.php";
?>
