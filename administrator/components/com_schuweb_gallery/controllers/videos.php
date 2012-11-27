<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_schuweb_gallery
 *
 * @copyright   Copyright (C) 2012 Schultschik Websolution, Sven Schultschik, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * SchuWeb Gallery master display controller.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_schuweb_gallery
 */
class SchuWeb_GalleryControllerVideos extends JControllerAdmin
{
    /**
     * @var    string  The prefix to use with controller messages.
     * @since  1.6
     */
    protected $text_prefix = 'COM_SCHUWEB_GALLERY';

    /**
     * Proxy for getModel.
     * @since	1.6
     */
    public function getModel($name = 'Video', $prefix = 'SchuWeb_GalleryModel', $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);
        return $model;
    }
}
