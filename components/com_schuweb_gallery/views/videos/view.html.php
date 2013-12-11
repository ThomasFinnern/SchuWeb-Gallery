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
require_once(JPATH_ADMINISTRATOR . '/components/com_schuweb_gallery/helpers/gallery.php');

class SchuWeb_GalleryViewVideos extends JViewLegacy
{
    protected $videos = array();
    protected $prevButtonPosition = null;
    protected $video_grid_size = null;
    protected $video_width = null;
    protected $video_height = null;
    protected $backPath = null;
    protected $displayVideoName = null;

    public function display($tpl = null)
    {
        $galleryHelper = new GalleryHelper();
        $params = $galleryHelper->getParams();

        $this->video_grid_size = $params->get('video_grid_size', '3');
        $this->video_width = $params->get('video_width', '300');
        $this->video_height = $params->get('video_height', '200');

        $this->prevButtonPosition = $params->get('prevButtonPosition', 1);

        $model = JModelList::getInstance('Videos', 'SchuWeb_GalleryModel');

        $this->videos = $model->getItems();

        $this->displayVideoName = $params->get('videoName', 1);

        $this->backPath = JRoute::_("index.php?option=com_schuweb_gallery&amp;view=videos");

        parent::display($tpl);
    }

}