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
 */
class SchuWeb_GalleryModelVideos extends JModelList
{
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
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery()
    {
        $db		= $this->getDbo();
        $query	= $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
            $this->getState(
                'list.select',
                'a.id AS id, a.video_id AS video_id, a.video_service AS video_service,'.
                    'a.checked_out AS checked_out,'.
                    'a.checked_out_time AS checked_out_time,' .
                    'a.state AS state, '.
                    'a.publish_up, a.publish_down'
            )
        );
        $query->from($db->quoteName('#__schuweb_gallery_videos').' AS a');

        // Join over the users for the checked out user.
        $query->select('uc.name AS editor');
        $query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

        // Filter by published state
        $published = $this->getState('filter.state');
        if (is_numeric($published)) {
            $query->where('a.state = '.(int) $published);
        } elseif ($published === '') {
            $query->where('(a.state IN (0, 1))');
        }

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = '.(int) substr($search, 3));
            } else {
                $search = $db->Quote('%'.$db->escape($search, true).'%');
                $query->where('(a.name LIKE '.$search.' OR a.alias LIKE '.$search.')');
            }
        }

        // Add the list ordering clause.
        /*$orderCol	= $this->state->get('list.ordering', 'ordering');
        $orderDirn	= $this->state->get('list.direction', 'ASC');
        if ($orderCol == 'ordering' || $orderCol == 'category_title') {
            $orderCol = 'c.title '.$orderDirn.', a.ordering';
        }

        $query->order($db->escape($orderCol.' '.$orderDirn));*/

        //echo nl2br(str_replace('#__','jos_',$query));
        return $query;
    }
}
