<?php
class DHLSettings {
	// Parameter Set Name
	public static $settingsGroup = DHL_CONFIG;
	
	// Name of Parameters
	private static $settingsArray = array(
		'dhl_token_id',
		'dhl_invite_key',
		'dhl_code_location',
		'dhl_username',
		'dhl_password',
        'dhl_sessionid'
	);
	
	public static function loadDHLSettings() {
		foreach (self::$settingsArray as $value) {
			register_setting(self::$settingsGroup, $value);
		}
	}
	
	public static function getVal($option) {
		if (!in_array(strtolower($option), self::$settingsArray)) {
			return false;
		} else {
			return get_option($option);
		}
	}
}
?>
