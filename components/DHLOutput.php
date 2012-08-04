<?php
class DHLOutput {	
	const _NAMESPACE = 'domain_hashlink';
	public static $options_page = "options-general.php?page=";//.DHL_CONFIG;
	
	// Alias Localization Function
	public static function __($output) {
		return __($output, self::_NAMESPACE);
	}
	
	public static function _e($output) {
		_e($output, self::_NAMESPACE);
	}
	
	public static function sub_error($errors, $part, $method = "") {
	    $ret = "";
	    if(isset($errors[$part]))
    	    if($errors[$part] != "")
    	        $ret =  ($method == "tag" ? "<tr><th class='th_error'>" : "").
                        "<div class='sub_error'>{$errors[$part]}</div>".
                        ($method == "tag" ? "</th><td></td></tr>" : "");
	    return $ret;
	}
	
	public static function errClass($errors, $part) {
	    $ret = "";
	    if(isset($errors[$part]))
	       if($errors[$part] != "")
	           $ret = "input_error";
	    return $ret;
	}
	
	// General Settings
	public static function settingsPage() {
	  
            $action = getv("action");
            if(!$action) $action = "settings";
            
            if(DHL_DEBUG) {
                if($action == "customadd") {
                    update_option("dhl_token_id", "true");
                    update_option("dhl_username", getv("username"));
                    update_option("dhl_password", getv("password"));
                    
                    echo "<h3>Custom Add</h3><div><strong>**Debug Mode**</strong> -- Added ".getv("username")."/".getv("password")."</div>";
                } else if($action == "clear") {
                    delete_option("dhl_token_id");
                    delete_option("dhl_username");
                    delete_option("dhl_password");
                }
            }
            
            $tok = DHLSettings::getVal('dhl_token_id');
            
            if(DHLSettings::getVal('dhl_username')) {
                $postVars = array();
                $postVars['email']          = DHLSettings::getVal('dhl_username');
                $postVars['password']       = DHLSettings::getVal('dhl_password');
                
                $encoded = v_compact($postVars);
                // Set URL to download
                $ch = curl_init(); 
                curl_setopt($ch, CURLOPT_URL, DHL_WEBSERVICE."users/signIn");
                curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
                curl_setopt($ch, CURLOPT_HEADER, 1); // Include header in result? (0 = yes, 1 = no)
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Should cURL return or print out the data? (true = return, false = print)
                curl_setopt($ch, CURLOPT_TIMEOUT, DHL_TIMEOUT); // Timeout in seconds
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, DHL_VERIFYPEER);
                curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json')); 
                $output = curl_exec($ch); // Download the given URL, and return output
                preg_match_all('/^Set-Cookie: (.*?);/m', $output, $m);
                
				$jsid_str = implode(';',$m[1]);

                if(DHL_DEBUG) {
                        echo "jsid_str:". $jsid_str . "<br/>";
                }

                //DHL-931: update_option("dhl_sessionid", isset($m[1][1]) ? $m[1][1] : (isset($m[1]) ? $m[1] : ""));				
				update_option("dhl_sessionid", $jsid_str);
                // Split out the JSON from the response manually because of the headers added
                $content = explode("Content-Type: application/json;charset=UTF-8", $output);
                $content = isset($content[1]) ? $content[1] : "";
                
                $login = json_decode($content);
                $login->code = isset($login->code) ? $login->code : 0;
                $login->message = isset($login->message) ? $login->message : "";
                
                if(DHL_DEBUG) {
                    echo "<div style='border: 1px solid orange; padding: 5px; margin-bottom: 5px;'><strong>Host:</strong> ".DHL_HOSTNAME;
                    print_r($m);
                    echo "</div>";
                    echo "<div>".curl_getinfo($ch, CURLINFO_HEADER_OUT)."</div>";
                    echo "<div style='border: 2px solid blue; padding: 5px; margin-bottom: 5px;'><div style='font-weight: bold;'>Sign In</div>";
                    echo $output;
                    echo "<br />Cookies ".(DHLSettings::getVal('dhl_sessionid'))."</div>";
                    //echo "<div style='border: 1px solid purple; padding: 5px; margin-bottom: 5px;'>$content</div>";
                }
                
                // Close the cURL resource, and free system resources
                curl_close($ch);
            } else {
                if(DHL_DEBUG) {
                    echo "<div style='border: 1px solid green; padding: 5px;'>".DHLSettings::getVal('dhl_sessionid')."</div>";
                }
            }
    ?>
            <?php if(DHL_DEBUG): ?>
            <div style="border: 1px solid yellow; padding: 5px;"><?php echo DHLSettings::getVal("dhl_username")." -- ".DHLSettings::getVal("dhl_password"); ?></div>
            <?php endif; ?>
<script language="JavaScript" type="text/javascript" src="<?php echo DHL_URL.'js/'."jquery-1.7.1.min.js"; ?>"></script>
<script language="JavaScript" type="text/javascript">
function unsubscribe() {
    if (confirm("<?php echo DHLOutput::__('Are you sure you want to unsubscribe from') . DHL_PLUGIN_TITLE; ?>")) {
        location.href = "<?php echo DHLOutput::$options_page.DHL_CONFIG.'&action=unsubscribe'; ?>";
    } else {
        return false;
    }
}
</script>
			<link href="<?php echo DHL_URL; ?>css/style.css" rel="stylesheet" type="text/css" />
            <div class="wrap">
                <h2>
                    <img src="<?php echo DHL_WHITELABEL; ?>" alt="<?php echo DHL_WHITELABEL; ?>" />
                    <!--<img src="<?php echo DHL_WHITELABEL_COMPANY; ?>" alt="<?php echo DHL_PLUGIN_TITLE; ?>" />
                    <img src="<?php echo DHL_WHITELABEL_PRODUCT; ?>" alt="<?php echo DHL_PLUGIN_TITLE; ?>" />-->
                </h2>
                <p style="float: right; display: inline;">
                    <a href="<?php echo DHLOutput::$options_page.DHL_CONFIG."&action=faq"; ?>"><?php echo DHLOutput::__("Frequently Asked Questions"); ?></a> | 
                    <?php if($tok == ""): ?>
                    <a href="<?php echo DHLOutput::$options_page.DHL_CONFIG."&action=register"; ?>"><?php echo DHLOutput::__("Subscribe"); ?></a>
                    <?php else: ?>
                    <a href="<?php echo DHLOutput::$options_page.DHL_CONFIG."&action=manage"; ?>"><?php echo DHLOutput::__("Manage"); ?></a> |
                    <a href="JavaScript: unsubscribe();"><?php echo DHLOutput::__("Unsubscribe"); ?></a>
                    <?php endif; ?>
                </p>
				<p>
					<?php
						DHLOutput::_e(DHL_PLUGIN_TITLE." allows you to easily add hashlinks to all your WordPress pages.");
						echo '<br/>';
					?>
				</p>
        <?php
            
            if($action == "faq" || $action == "unsubscribe")
                $subaction = $action;
            else if($tok)
                $subaction = "manage";
            else
                $subaction = "register";
            
            switch($subaction) {
                case "manage":
                    include DHL_DIRPATH."controllers/manage.php";
                    break;
                case "faq":
                    include DHL_DIRPATH."views/faq.php";
                    break;
                case "unsubscribe":
                    include DHL_DIRPATH."controllers/register.php";
                    break;
                case "register":
                    include DHL_DIRPATH."controllers/register.php";
                    break;
                default:
                    include DHL_DIRPATH."controllers/register.php";
                    break;
            }
		?>        <br />
			<p style="border-top: 1px solid gray; padding: 5px;">
				<?php
					DHLOutput::_e('For support / assistance with this plugin, please visit ');
					echo '<a href="'.DHL_DOMAIN.'" target="_blank">'.DHL_DOMAIN.'</a>';
				?>
			</p>
		</div>
	<?php
	}
	// Inject the JavaScript into the WP hook
	public static function dhlCode(array $options) {
	    $ret = "";
		// Insert the JS Code
		if(count($options) > 0)
			$ret  = "<script language='JavaScript' type='text/javascript' src='".DHL_JS_OSN_EMBED."'></script>";
		return $ret;
	}
}
	
?>
