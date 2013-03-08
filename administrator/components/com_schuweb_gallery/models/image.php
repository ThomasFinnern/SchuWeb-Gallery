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
 * @subpackage  com_schuweb_gallery
 * @since       2.5
 */
class SchuWeb_GalleryModelImage extends JModelAdmin
{
    public function getForm($data = array(), $loadData = true)
    {
        $form = $this->loadForm('com_schuweb_gallery.image', 'image', array('control' => 'jform', 'load_data' => $loadData));

        if (empty($form)) {
            return false;
        }

        return $form;
    }

    public function loadFormData()
    {
        $data = $this->getItem();

        return $data;
    }

    public function getItem($pk = null)
    {
        $image = JFactory::getApplication()->input->get('file');
        $path = JFactory::getApplication()->input->get('path', null, null);

        $table = $this->getTable('ImageTags', 'SchuWeb_GalleryTable');
        $tagsAssoc = $table->getTags($path, $image);

        $tags = array();

        foreach ( $tagsAssoc as $v) {
            $tags[] = $v['tagid'];
        }

        $res = array('file' => $image, 'path' => $path, 'tags' => $tags);

        return $res;
    }

    public function save($data) {

        $table = $this->getTable('ImageTags', 'SchuWeb_GalleryTable');
        $table->store($data);

        return true;

    }
}