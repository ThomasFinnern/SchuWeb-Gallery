<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  schuweb_gallery
 *
 * @copyright   Copyright (C) 2012 Schultschik Websolution / Sven Schultschik. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

/**
 * Filter model class for Finder.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_finder
 * @since       2.5
 */
require_once(JPATH_ADMINISTRATOR . '/components/com_schuweb_gallery/helpers/gallery.php');

class Schuweb_galleryModelImages extends JModelList
{
    function getItems()
    {
        $params = JComponentHelper::getParams('com_schuweb_gallery');

        $base = JFactory::getApplication()->input->get('folderlist',null, null);

        if (empty($base)){
            $base = $params->get('start_folder', 'images');
        }else{
            $base = $params->get('start_folder', 'images').'/'.$base;
        }

        $thumbhelper = new GalleryHelper();
        $image_excludes = $thumbhelper->getImage_excludes();

        return JFolder::files(JPATH_ROOT . '/' . $base, '.', false, false, $image_excludes);
    }

    function getFolders($base = null, $xhtml = true)
    {

        $selected = JFactory::getApplication()->input->get('folderlist', null, null);

        // Get some paths from the request
        if (empty($base)) {
            $params = JComponentHelper::getParams('com_schuweb_gallery');
            $base = $params->get('start_folder', 'images');
        }

        //corrections for windows paths
        $base = str_replace(DIRECTORY_SEPARATOR, '/', $base);
        $com_media_base_uni = str_replace(DIRECTORY_SEPARATOR, '/', JPATH_ROOT . '/images');

        $thumbhelper = new GalleryHelper();
        $folder_excludes = $thumbhelper->getFolder_excludes();

        // Get the list of folders
        jimport('joomla.filesystem.folder');
        $folders = JFolder::folders(JPATH_ROOT . '/' .$base, '.', true, true, $folder_excludes);
        //$document = JFactory::getDocument();
        //$document->setTitle(JText::_('COM_MEDIA_INSERT_IMAGE'));

        if ($xhtml) {
            // Build the array of select options for the folder list
            $options[] = JHtml::_('select.option', "", "/");

            foreach ($folders as $folder) {
                $folder = str_replace($com_media_base_uni, "", str_replace(DIRECTORY_SEPARATOR, '/', $folder));
                $value = substr($folder, 1);
                $text = str_replace(DIRECTORY_SEPARATOR, "/", $folder);
                $options[] = JHtml::_('select.option', $value, $text);
            }

            // Sort the folder list array
            if (is_array($options)) {
                sort($options);
            }

            // Create the drop-down folder select list
            $list = JHtml::_('select.genericlist', $options, 'folderlist', 'class="inputbox folderlist" size="1" onchange="this.form.submit()" ', 'value', 'text', $selected);

            return $list;
        }

        return $folders;
    }

    public function getState($property = null, $default = null)
    {
        static $set;

        if (!$set) {
            $input = JFactory::getApplication()->input;
            $folder = $input->get('folder', '', 'path');
            $this->setState('folder', $folder);

            $parent = str_replace("\\", "/", dirname($folder));
            $parent = ($parent == '.') ? null : $parent;
            $this->setState('parent', $parent);
            $set = true;
        }

        return parent::getState($property, $default);
    }
}
