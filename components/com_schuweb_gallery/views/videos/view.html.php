<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_schuweb_gallery
 *
 * @copyright   Copyright (C) 2012 Schultschik Websolution, Sven Schultschik. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

jimport('joomla.filesystem.folder');
require_once(JPATH_ADMINISTRATOR . '/components/com_schuweb_gallery/helpers/thumbs.php');

class SchuWeb_GalleryViewVideos extends JViewLegacy
{
    protected $videos = array();

    public function display($tpl = null)
    {
        $thumbhelper = new ThumbsHelper();
        $this->video_grid_size = $thumbhelper->getParams()->get('video_grid_size', '3');
        $this->video_width = $thumbhelper->getParams()->get('video_width', '300');
        $this->video_height = $thumbhelper->getParams()->get('video_height', '200');

        $model = JModelList::getInstance('Videos', 'SchuWeb_GalleryModel');

        $this->videos = $model->getItems();
        parent::display($tpl);
    }

}