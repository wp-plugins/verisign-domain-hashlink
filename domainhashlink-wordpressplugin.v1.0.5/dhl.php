<?php
/*
Plugin Name: Domain Hashlink
Plugin URI: http://domainhashlink.com/
Description: Domain Hashlink, by Verisign&trade;, is a new web navigational tool that lets you create memorable URL shortcuts. You can direct someone exactly where you want them to be on your site: with a short, intuitive and easily remembered keyword preceded by a # hash symbol (e.g. www.example.com#keyword).
Version: 1.0.5
Author: Verisign
Author URI: http://www.verisigninc.com/
License: -- GPL?
*/
/*  Copyright 2012  Phillihp Harmon (Princeton Information (email : phil.harmon@princetoninformation.com)

    This section should contain the legal ramifications for altering, change, distribution, and more...
*/

    /* Core Settings - DO NOT CHANGE */
	define('DHL_ROOT', dirname(plugin_basename(__FILE__)));
	define('DHL_DIRPATH', plugin_dir_path(__FILE__));
	define('DHL_BASENAME', plugin_basename(__FILE__));
	define('DHL_URL', WP_PLUGIN_URL."/".DHL_ROOT."/");
	
	/* DO NOT CHANGE */
	define('DHL_SETTINGS_AUTH', 'administrator');      // What permissions should you have to see the Settings link?
	// Dynamically pull the hostname from the Server var
	define('DHL_HOSTNAME', (strpos($_SERVER['HTTP_HOST'], "www.") == 0 ? str_replace("www.", "", $_SERVER['HTTP_HOST']) : $_SERVER['HTTP_HOST']));
    define('DHL_CONFIG', 'domain-hashlink-config');    // Declare the settings group name

    /* To change your configuration, update the core/config.php file */
    @include("core/config.php");
	
	/* Kickstart the plugin */
	@include('core/functions.php');
	new DHLLoad;
?>
