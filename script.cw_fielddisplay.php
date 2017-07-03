<?php
/**
 * @copyright   Copyright (C) 2017 Cory Webb Media, LLC. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Script file of Field Display module
 */
class mod_cw_fielddisplayInstallerScript
{
    /**
     * method to install the component
     *
     * @return void
     */
    function install($parent) 
    {
        
    }
 
    /**
     * method to uninstall the component
     *
     * @return void
     */
    function uninstall($parent) 
    {
        
    }
 
    /**
     * method to update the component
     *
     * @return void
     */
    function update($parent) 
    {
        
    }
 
    /**
     * method to run before an install/update/uninstall method
     *
     * @return void
     */
    function preflight($type, $parent) 
    {
        
    }
 
    /**
     * method to run after an install/update/uninstall method
     *
     * @return void
     */
    function postflight($type, $parent) 
    {
        if ($type == 'uninstall') {
            return true;
        }
        
        $this->source = $parent->getParent()->getPath('source');
        
        // Get a new installer
        $installer = new JInstaller();
        
        $db = JFactory::getDbo();
                
        if ($installer->install($this->source.'/plugins/plg_installer_cw')) {
            $query = $db->getQuery(true);
            $query->update('#__extensions')
                  ->set($db->qn('enabled').'='.$db->q(1))
                  ->where($db->qn('element').'='.$db->q('cw'))
                  ->where($db->qn('type').'='.$db->q('plugin'))
                  ->where($db->qn('folder').'='.$db->q('installer'));
            $db->setQuery($query);
            $db->execute();
        }
    }
}