<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_schuweb_gallery
 *
 * @copyright   Copyright (C) 2012 Schultschik Websolution, Sven Schultschik. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

class GalleryHelper
{
    public static function getActions()
    {
        $user = JFactory::getUser();
        $result = new JObject;

        $actions = JAccess::getActionsFromFile(
            JPATH_ADMINISTRATOR . '/components/com_schuweb_gallery/access.xml', "/access/section[@name='component']/");

        foreach ($actions as $action) {
            $result->set($action->name, $user->authorise($action->name, "com_schuweb_gallery"));
        }

        return $result;
    }
}