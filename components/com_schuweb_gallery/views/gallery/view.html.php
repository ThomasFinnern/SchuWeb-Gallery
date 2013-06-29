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
require_once(JPATH_ADMINISTRATOR . '/components/com_schuweb_gallery/helpers/gallery.php');

class SchuWeb_GalleryViewGallery extends JViewLegacy
{
    protected $folders = array();
    protected $images = array();

    public function display($tpl = null)
    {
        $thumbHelper = new ThumbsHelper();
        $input = JFactory::getApplication()->input;

        $galleryHelper = new GalleryHelper();
        $params = $galleryHelper->getParams();

        $start_folder = $params->get('start_folder', 'images');

        $this->folder_grid_size = $params->get('folder_grid_size', 3);
        $this->image_grid_size = $params->get('image_grid_size', 3);
        $entry_folder = $input->get('folder', null, 'STRING');

        if ($entry_folder) {
            $start_folder = preg_replace(array('/\:/', '/\./'), array('-', '/'), $entry_folder);
        }

        $this->folders = $galleryHelper->getFolders($start_folder);

        $this->images = $thumbHelper->getThumbs($start_folder);

        $galleryHelper->insertJS();

        parent::display($tpl);
    }

}
