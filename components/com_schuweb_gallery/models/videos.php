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
class SchuWeb_GalleryModelVideos extends JModelList
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

        $vService = $menuparams->get('video_service');

        $query->select("video_id, video_service")
            ->from("#__schuweb_gallery_videos");
        if ( $vService != 'all') {
            $query->where('video_service=\''.$db->escape($vService).'\'');
        }

        return $query;
    }
}