<?php
/**
 * @package     Joomla.Site
 * @subpackage  schuweb_gallery
 *
 * @copyright   Copyright (C) 2012 Schultschik Websolution / Sven Schultschik. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

/**
 * Filter model class for Finder.
 *
 * @package     Joomla.Site
 * @subpackage  com_schuweb_gallery
 */
class SchuWeb_GalleryModelImages extends JModelList
{
    /**
     * Method to get a JDatabaseQuery object for retrieving the data set from a database.
     *
     * @return  JDatabaseQuery   A JDatabaseQuery object to retrieve the data set.
     *
     * @since   12.2
     */
    protected function getListQuery()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $app = JFactory::getApplication();
        $menuparams = $app->getParams();

        $tagId = JFactory::getApplication()->input->get('tagid', null, 'int');

        if ($tagId == null) {
            $tagId = $menuparams->get('tag');
        }

        if (is_array($tagId)) {
            $tagId = implode(',', $tagId);
        }

        $query->select("a.path, a.image")
            ->from("#__schuweb_gallery_image_tags as a");
        if ($tagId != null) {
            $query->where('a.tagid=' . $this->_db->quote($tagId));
        }

        return $query;
    }
}