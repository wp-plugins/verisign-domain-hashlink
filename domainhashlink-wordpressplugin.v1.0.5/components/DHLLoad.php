<?php
class DHLLoad {
	const _NAMESPACE = 'domain_hashlink';
		
	/* Declarations */
	private $actions = array(
		'init' => 'launch_i18n',
		'admin_init' => 'loadDHLSettings',
		'admin_menu' => 'dhlsettings',
		'wp_head' => 'insertCode',
		'widgets_init' => 'load_widgets'
	);
	
	private $filters = array(
		'plugin_action_links' => 'pluginLinks',
	);
	
	/* Initialization */
	public function __construct() {
    	$this->addActions();
		$this->addFilters();
	}
	
	// Add Actions
	private function addActions() {
		// Iterate through all the actions
		foreach ($this->actions as $key => $value) {
			$key = str_replace('%%LOCATION%%', DHLSettings::getVal('dhl_code_location'), $key);
			add_action($key, 'DHLLoad::' . $value);
		}
	}
	
	// Localization
	public static function launch_i18n() {
		$lngPath = DHL_ROOT . '/languages/';
		load_plugin_textdomain(self::_NAMESPACE, false, $lngPath);
	}
	
	// Register Parameters
	public static function loadDHLSettings() {
		DHLSettings::loadDHLSettings();
	}
	
	public static function dhlsettings() {
		add_options_page(DHL_PLUGIN_TITLE, DHL_PLUGIN_TITLE.' '.DHLOutput::__('Settings'), DHL_SETTINGS_AUTH, 'domain-hashlink-config', "DHLOutput::settingsPage");
	}
	
	// Insert custom DHL Code
	public static function insertCode() {
		$options = array();
		
        if(DHLSettings::getVal('dhl_token_id') !== false && DHLSettings::getVal('dhl_token_id') != "") {
            array_push($options, true);
        }
        //echo "<div style='border: 1px solid red; padding: 10px;'>".Settings::getVal('dhl_token_id')."</div>";
		echo DHLOutput::dhlCode($options);
	}
	
	// Add Widgets here -- Currently these are stored in the "components" directory
	public static function load_widgets() {
	    register_widget('DHL_Widget');
	}
	
	// Add Filters
	private function addFilters() {
		foreach ($this->filters as $key => $value) {
			add_filter($key . '_' . DHL_BASENAME, 'DHLLoad::' . $value);
        }
	}
	
	// Action Links
	public static function pluginLinks($links) {
	    $links = is_array($links) ? $links : Array();
		$link = '<a href="' . menu_page_url(DHL_CONFIG, false) . '">' . DHLOutput::__('Manage Service') .'</a>';
        array_pop($links);
        array_push($links, $link);
		return $links;
	}
}
?>
