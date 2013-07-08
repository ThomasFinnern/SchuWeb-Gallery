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

class SchuWeb_GalleryViewTag extends JViewLegacy
{
    protected $videos = array();

    public function display($tpl = null)
    {
        $galleryHelper = new GalleryHelper();
        $params = $galleryHelper->getParams();

        $this->video_grid_size = $params->get('video_grid_size', '3');
        $this->image_grid_size = $params->get('image_grid_size', '3');
        $this->video_width = $params->get('video_width', '300');
        $this->video_height = $params->get('video_height', '200');
        $this->startFolder = $params->get('start_folder', 'images');

        $model = JModelList::getInstance('Videos', 'SchuWeb_GalleryModel');

        $this->videos = $model->getItems();

        $imagesModel = JModelList::getInstance('Images', 'SchuWeb_GalleryModel');

        $this->images = $imagesModel->getItems();

        $galleryHelper->insertJS();

        parent::display($tpl);
    }

}