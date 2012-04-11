<?php
/**
 * Mobile Device Detect (MDD)
 *
 * @package MDD
 * @author emanuele
 * @copyright the class uagent_info is copyright of Anthony Hand (see Subs-MobileDetect.php for details)
 * @copyright 2012 emanuele, Simple Machines
 * @license http://www.apache.org/licenses/LICENSE-2.0.html Apache License 2.0 (AL2)
 *
 * @version 0.2.2
 */

if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
	require_once(dirname(__FILE__) . '/SSI.php');
elseif (!defined('SMF'))
	exit('<b>Error:</b> Cannot install - please verify you put this in the same place as SMF\'s index.php.');

$hooks = array(
	'integrate_pre_include' => '$sourcedir/Subs-MobileDetect.php',
	'integrate_verify_user' => 'setThemeForMobileDevices',
);

if (SMF == 'SSI' && (!isset($_GET['action']) || (isset($_GET['action']) && !in_array($_GET['action'], array('install', 'uninstall')))))
	echo '
		Please select the action you want to perform:<br />
		<a href="' . $boardurl . '/install.php?action=install">Install</a><br />
		<a href="' . $boardurl . '/install.php?action=uninstall">Uninstall</a>';
else
{
	$context['uninstalling'] = isset($context['uninstalling']) ? $context['uninstalling'] : (isset($_GET['action']) && $_GET['action'] == 'uninstall' ? true : false);
	$integration_function = empty($context['uninstalling']) ? 'add_integration_function' : 'remove_integration_function';
	foreach ($hooks as $hook => $function)
		$integration_function($hook, $function);

	if (SMF == 'SSI')
		echo 'Database adaptation successful!';
}
?>