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
class Schuweb_galleryModelImages extends JModelAdmin
{
    /**
     * The prefix to use with controller messages.
     *
     * @var    string
     * @since  2.5
     */
    protected $text_prefix = 'COM_SCHUWEB_GALLERY';

    /**
     * Model context string.
     *
     * @var    string
     * @since  2.5
     */
    protected $context = 'com_schuweb_gallery.images';

    /**
     * Method to get the record form.
     *
     * @param   array    $data      Data for the form. [optional]
     * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not. [optional]
     *
     * @return  mixed  A JForm object on success, false on failure
     *
     * @since   2.5
     */
    public function getForm($data = array(), $loadData = false)
    {
        // Get the form.
        $form = $this->loadForm('com_schuweb_gallery.images', 'images', array('control' => 'jform', 'load_data' => $loadData));

        if (empty($form))
        {
            return false;
        }

        return $form;
    }

    function getFolderList($base = null)
    {
        // Get some paths from the request
        if (empty($base)) {
            $base = JPATH_ROOT.'/images';
        }
        //corrections for windows paths
        $base = str_replace(DIRECTORY_SEPARATOR, '/', $base);
        $com_media_base_uni = str_replace(DIRECTORY_SEPARATOR, '/', JPATH_ROOT.'/images');

        // Get the list of folders
        jimport('joomla.filesystem.folder');
        $folders = JFolder::folders($base, '.', true, true);

        $document = JFactory::getDocument();
        $document->setTitle(JText::_('COM_MEDIA_INSERT_IMAGE'));

        // Build the array of select options for the folder list
        $options[] = JHtml::_('select.option', "", "/");

        foreach ($folders as $folder)
        {
            $folder		= str_replace($com_media_base_uni, "", str_replace(DIRECTORY_SEPARATOR, '/', $folder));
            $value		= substr($folder, 1);
            $text		= str_replace(DIRECTORY_SEPARATOR, "/", $folder);
            $options[]	= JHtml::_('select.option', $value, $text);
        }

        // Sort the folder list array
        if (is_array($options)) {
            sort($options);
        }

        // Get asset and author id (use integer filter)
        $input = JFactory::getApplication()->input;
        $asset = $input->get('asset', 0, 'integer');
        $author = $input->get('author', 0, 'integer');

        // Create the drop-down folder select list
        $list = JHtml::_('select.genericlist', $options, 'folderlist', 'class="inputbox folderlist" size="1" onchange="SchuWebGallery.setFolder(this.options[this.selectedIndex].value, '.$asset.', '.$author.')" ', 'value', 'text', $base);

        return $list;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return  mixed  The data for the form.
     *
     * @since   2.5
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
       // $data = JFactory::getApplication()->getUserState('com_schuweb_gallery.images.data', array());

        if (empty($data))
        {
            $data = $this->getItem();
        }
        return $data;
    }

    public function getState($property = null, $default = null)
    {
        static $set;

        if (!$set)
        {
            $input  = JFactory::getApplication()->input;
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
