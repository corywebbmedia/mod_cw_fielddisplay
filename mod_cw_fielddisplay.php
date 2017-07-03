<?php
/**
 * @copyright   Copyright (C) 2017 Cory Webb Media, LLC. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the helper functions only once
require_once __DIR__ . '/helper.php';

$helper  = new ModCwFieldDisplayHelper($params);

$context = $helper->getContext($params);
$item    = $helper->getItem($params);
$fields  = $helper->getFields($params);

require JModuleHelper::getLayoutPath('mod_cw_fielddisplay', $params->get('layout', 'default'));
