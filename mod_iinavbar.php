<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_iinavbar
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$list		= ModIinavbarHelper::getList($params);
$base		= ModIinavbarHelper::getBase($params);
$active		= ModIinavbarHelper::getActive($params);
$active_id 	= $active->id;
$path		= $base->tree;
$app		= JFactory::getApplication();
$siteName 	= $app->get('sitename');
$home		= $app->get('baseurl');

$showAll	= $params->get('showAllChildren');
$class_sfx	= htmlspecialchars($params->get('class_sfx'));

if (count($list))
{
	require JModuleHelper::getLayoutPath('mod_iinavbar', $params->get('layout', 'default'));
}
