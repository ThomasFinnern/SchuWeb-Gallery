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
     * Constructor.
     *
     * @param	array	An optional associative array of configuration settings.
     * @see		JController
     * @since	1.6
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'video_id', 'a.video_id',
                'video_service', 'a.video_service',
                'state', 'a.state',
                'ordering', 'a.ordering',
                'checked_out', 'a.checked_out',
                'checked_out_time', 'a.checked_out_time',
                'created', 'a.created',
                'publish_up', 'a.publish_up',
                'publish_down', 'a.publish_down',
                'state',
            );
        }

        parent::__construct($config);
    }
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
                    'a.publish_up, a.publish_down,'.
                    'a.state AS state, '.
                    'a.created AS created,'.
                    'a.ordering AS ordering,'.
                    'a.created_by AS created_by,'.
                    'a.created_by_alias AS created_by_alias,'.
                    'a.modified AS modified,'.
                    'a.modified_by AS modified_by'
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
                $query->where('(a.video_id LIKE '.$search.')');
            }
        }

        // Add the list ordering clause.
        $orderCol	= $this->state->get('list.ordering', 'ordering');
        $orderDirn	= $this->state->get('list.direction', 'ASC');
        if ($orderCol == 'ordering' || $orderCol == 'category_title') {
            $orderCol = 'a.video_id '.$orderDirn.', a.ordering';
        }

        $query->order($db->escape($orderCol.' '.$orderDirn));

        //echo nl2br(str_replace('#__','jos_',$query));
        return $query;
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since	1.6
     */
    protected function populateState($ordering = null, $direction = null)
    {
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
        $this->setState('filter.state', $state);

        // Load the parameters.
        $params = JComponentHelper::getParams('com_schuweb_gallery');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.video_id', 'asc');
    }
}
