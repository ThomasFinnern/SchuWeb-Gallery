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

class SchuWeb_GalleryViewGallery extends JViewLegacy
{
    protected $folders = array();
    protected $images = array();

    public function display($tpl = null)
    {
        $thumbhelper = new ThumbsHelper();
        $input = JFactory::getApplication()->input;

        $start_folder = $thumbhelper->getParams()->get('start_folder', 'images');
        $this->folder_grid_size = $thumbhelper->getParams()->get('folder_grid_size', '3');
        $this->image_grid_size = $thumbhelper->getParams()->get('image_grid_size', '3');
        $entry_folder = $input->get('folder', null, 'STRING');
        if ($entry_folder) {
            $start_folder = preg_replace(array('/\:/', '/\./'), array('-', '/'), $entry_folder);
        }
        //get folders
        $excludes = $thumbhelper->getFolder_excludes();
        $folders = JFolder::folders(JPATH_BASE . '/' . $start_folder, '.', false, false, $excludes);
        //get a random image
        $image_excludes = $thumbhelper->getImage_excludes();
        if (!empty($folders)) {
            foreach ($folders as $key => $folder) {
                $path = $start_folder . '/' . $folder;
                $images = JFolder::files(JPATH_BASE . '/' . $path, '.', false, false, $image_excludes);
                if (!empty($images)) {
                    $image = $images[array_rand($images)];
                    $image = $thumbhelper->getThumb($path, $image);
                    $this->folders[$key]['folder'] = $path;
                    $this->folders[$key]['name'] = preg_replace('/\_/', ' ', $folder);
                    $this->folders[$key]['image'] = $image;
                }
            }
        }

        $this->images = $thumbhelper->getThumbs($start_folder);

        $thumbhelper->insertJS();

        parent::display($tpl);
    }

}