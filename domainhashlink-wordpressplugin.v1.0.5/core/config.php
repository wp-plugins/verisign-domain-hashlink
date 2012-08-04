<?php
/* Environmental Settings - REGISTRAR TO UPDATE */
    define('DHL_VAPI', true);           // Depreciated (used when using Stubs vs API)
    define('DHL_DEBUG', false);
    define('DHL_TIMEOUT', 90);          // Timeout for API calls to be made
    define('DHL_VERIFYPEER', false);    // This will bypass API verification to SSL websites
	define('DHL_PLUGIN_TITLE', 'Domain Hashlink');
	define('DHL_WHITELABEL_COMPANY', DHL_URL."images/verisign.jpg");       // Dep.
	define('DHL_WHITELABEL_PRODUCT', DHL_URL."images/domainhashlink.jpg"); // Dep.
	define('DHL_WHITELABEL', DHL_URL."images/vLogoDH.png");    // Use this to maintain single image.
	define('DHL_DOMAIN', 'https://www.domainhashlink.com');
	define('DHL_FAQ', "https://www.domainhashlink.com/sss/main/faq");
	define('DHL_JS_HOST', "resolution.domainhashlink.com");
	define('DHL_JS_OSN_EMBED', "http://".DHL_JS_HOST."/osn_embed.js");
	define('DHL_WEBSERVICE', 'https://www.domainhashlink.com/sss/api/');
	define('DHL_IFRAME_SIZE', '1600');
?>