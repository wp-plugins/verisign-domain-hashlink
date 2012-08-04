<?php
define('DHL_KEY_SUGGESTION', DHLOutput::__('Enter the invite key received in your email promotion'));
define('DHL_UNKNOWN_ERROR', DHLOutput::__("Connection Error"));
$errors = array();

$vars = array('inviteKey', 'firstName', 'lastName', 'emailAddress', 'emailAddressConfirm', 'password', 'pw_confirm', 'terms', 'kwcount', 'kw1', 'url1');
foreach($vars as $var) {
    $$var = getv($var);
}

if($action != "unsubscribe") {
    $suba = getv("suba");
    $callWebService = false;
    
    $postVars = array();
    
    if($suba == "post") {
        if($inviteKey == DHL_KEY_SUGGESTION)
            $inviteKey = "";
        if(!$inviteKey)
            $errors['inviteKey'] = DHLOutput::__("Invite key is required.");
        if(!$firstName)
            $errors['firstName'] = DHLOutput::__("First name is required.");
        if(!$lastName)
            $errors['lastName'].= DHLOutput::__("Last name is required.");
        if(!$emailAddress)
            $errors['emailAddress'] = DHLOutput::__("Email Address is required.");
        if(strtolower($emailAddress) != strtolower($emailAddressConfirm))
            $errors['emailAddressConfirm'] = DHLOutput::__("Email Addresses do not match.");
        if(!$password)
            $errors['password'] = DHLOutput::__("Password is required.");
        if($password != $pw_confirm)
            $errors['passwordConfirm'] = DHLOutput::__("Passwords do not match.");
        if($terms != 1)
            $errors['terms'].= DHLOutput::__("Terms must be agreed upon before registering.");
    }
    
    $postVars = array();
    $postVars['inviteKey']      = $inviteKey;
    $postVars['email']          = $emailAddress;
    $postVars['domainName']     = DHL_HOSTNAME;
    $postVars['firstName']      = $firstName;
    $postVars['lastName']       = $lastName;
    $postVars['password']       = $password;
    /*POST, PUT : http://localhost:8080/sss/api/users?
        email=test2@test.com&
        password=password&
        domainName=gmail1.com&
        firstName=test2Name&
        lastName=test2LastName&
        inviteKey=KMgvNSYDxc53WkkF5xBIHA==
    */
    
    if(!count($errors) && $suba == "post")
        $callWebService = true;
    
    if($callWebService) {
        
        // is cURL installed yet?
        if (!function_exists('curl_init')) {
            die('Sorry cURL is not installed!');
        }
     
        // OK cool - then let's create a new cURL resource handle
        $ch = curl_init(); 
        
        $encoded = v_compact($postVars);
    
        // Set URL to download
        curl_setopt($ch, CURLOPT_URL, DHL_WEBSERVICE."users");
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
        curl_setopt($ch, CURLOPT_HEADER, 0); // Include header in result? (0 = yes, 1 = no)
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Should cURL return or print out the data? (true = return, false = print)
        curl_setopt($ch, CURLOPT_TIMEOUT, DHL_TIMEOUT); // Timeout in seconds
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, DHL_VERIFYPEER);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json')); 
        $output = curl_exec($ch); // Download the given URL, and return output
        
        
        $register = json_decode($output);
        
        if(DHL_DEBUG) {
            echo "<div style='border: 1px solid blue; padding: 5px;'><div style='font-weight: bold;'>Subscribe</div>$output<br />".curl_error($ch);
            print_r($register);
            echo "</div>";
        }
        
        // Close the cURL resource, and free system resources
        curl_close($ch);
        
        $register->code = isset($register->code) ? $register->code : 0;
        $register->message = isset($register->message) ? $register->message : DHL_UNKNOWN_ERROR;
        
        if($register->code == 40006)
            $errors['emailAddress'] = $register->message;
        else if($register->code == 70006)
            $errors['inviteKey'] = $register->message;
        else if($register->code == 50010)
            $errors['inviteKey'] = $register->message;
        else if($register->code != 70007)
            $errors['main'] = isset($register->message) ? $register->message : DHL_UNKNOWN_ERROR;
        
        if(!count($errors) && $register->code == 70007) {
            update_option("dhl_token_id", "true");
            update_option("dhl_username", $emailAddress);
            update_option("dhl_password", $password);
            
            //echo $encoded." - ".$output;
            //$data = v_extract($output);
            include DHL_DIRPATH."views/register_complete.php";
        } else {
            include DHL_DIRPATH."views/register.php";
        }
    } else {
        include DHL_DIRPATH."views/register.php";
    }
} else {
    $ch = curl_init(); 
    // Set URL to download
    curl_setopt($ch, CURLOPT_URL, DHL_WEBSERVICE."domain/".DHL_HOSTNAME."/subscription");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_HEADER, 0); // Include header in result? (0 = yes, 1 = no)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Should cURL return or print out the data? (true = return, false = print)
    curl_setopt($ch, CURLOPT_TIMEOUT, DHL_TIMEOUT); // Timeout in seconds
    curl_setopt($ch, CURLOPT_COOKIE, DHLSettings::getVal('dhl_sessionid'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, DHL_VERIFYPEER);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    $output = curl_exec($ch); // Download the given URL, and return output
    // Close the cURL resource, and free system resources
    curl_close($ch);
    
    $register = json_decode($output);
    $register->code = isset($register->code) ? $register->code : -1;
    $register->message = isset($register->message) ? ($register->message == "OK" ? DHLOutput::__("You have successfully unsubscribed.") : $register->message) : DHL_UNKNOWN_ERROR;
    
    $errors['main'] = isset($register->message) ? $register->message : "...";
    
    if(DHL_DEBUG) {
        echo "<div style='border: 1px solid blue; padding: 5px;'><div style='font-weight: bold;'>Unsubscribe</div><div>Output: [$output]</div>";
        print_r($register);
        echo "</div>";
    }
    
    if($register->code == 50018) {
        update_option("dhl_token_id", "");
        update_option("dhl_username", "");
        update_option("dhl_password", "");
        update_option("dhl_sessionid", "");
    }
    include DHL_DIRPATH."views/unsubscribe.php";
}
?>
