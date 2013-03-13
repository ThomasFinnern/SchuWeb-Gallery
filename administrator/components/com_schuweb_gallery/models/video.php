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
class SchuWeb_GalleryModelVideo extends JModelAdmin
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
    protected $context = 'com_schuweb_gallery.video';

    /**
     * Returns a JTable object, always creating it.
     *
     * @param   string  $type    The table type to instantiate. [optional]
     * @param   string  $prefix  A prefix for the table class name. [optional]
     * @param   array   $config  Configuration array for model. [optional]
     *
     * @return  JTable  A database object
     *
     * @since   1.6
     */
    public function getTable($type = 'Video', $prefix = 'SchuWeb_GalleryTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

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
    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm('com_schuweb_gallery.video', 'video', array('control' => 'jform', 'load_data' => $loadData));

        if (empty($form))
        {
            return false;
        }

        // Modify the form based on access controls.
        if (!$this->canEditState((object) $data))
        {
            // Disable fields for display.
            $form->setFieldAttribute('ordering', 'disabled', 'true');
            $form->setFieldAttribute('publish_up', 'disabled', 'true');
            $form->setFieldAttribute('publish_down', 'disabled', 'true');
            $form->setFieldAttribute('state', 'disabled', 'true');
            $form->setFieldAttribute('sticky', 'disabled', 'true');

            // Disable fields while saving.
            // The controller has already verified this is a record you can edit.
            $form->setFieldAttribute('ordering', 'filter', 'unset');
            $form->setFieldAttribute('publish_up', 'filter', 'unset');
            $form->setFieldAttribute('publish_down', 'filter', 'unset');
            $form->setFieldAttribute('state', 'filter', 'unset');
            $form->setFieldAttribute('sticky', 'filter', 'unset');
        }


        return $form;
    }

    public function save($data)
    {
        $tags = $data['tags'];

        if (!is_array($tags)) {
            $tags = array($tags);
        }
        $id = $data['id'];

        unset($data['tags']);

        if (parent::save($data)) {

            $table = $this->getTable('VideoTags');
            $table->update($tags, $id);
        }

        return true;
    }

    public function getItem($pk = null) {
        $item = parent::getItem($pk);

        $tagsTable = JTable::getInstance("VideoTags", "SchuWeb_GalleryTable", array());
        $res = $tagsTable->loadItemTags($item->id);

        $tags = array();

        foreach ( $res as $v) {
            $tags[] = $v['tagid'];
        }

        $item->tags = $tags;

        return $item;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return      mixed   The data for the form.
     * @since       2.5
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_schuweb_gallery.edit.video.data', array());

        if (empty($data))
        {
            $data = $this->getItem();

        }
        return $data;
    }

}
