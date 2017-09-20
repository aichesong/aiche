<?php

/**
 * This is a stub include that automatically configures the include path.
 */

set_include_path(dirname(__FILE__) . PATH_SEPARATOR . get_include_path() );
require_once 'HTMLPurifier/Bootstrap.php';


if (function_exists('spl_autoload_register') && function_exists('spl_autoload_unregister')) {
	// We need unregister for our pre-registering functionality
	HTMLPurifier_Bootstrap::registerAutoload();
	if (function_exists('__autoload')) {
		// Be polite and ensure that userland autoload gets retained
		spl_autoload_register('__autoload');
	}
} elseif (!function_exists('__autoload')) {
	function __autoload($class)
	{
		return HTMLPurifier_Bootstrap::autoload($class);
	}
}

if (ini_get('zend.ze1_compatibility_mode')) {
	trigger_error("HTML Purifier is not compatible with zend.ze1_compatibility_mode; please turn it off", E_USER_ERROR);
}

// vim: et sw=4 sts=4

// vim: et sw=4 sts=4
