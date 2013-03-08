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
class SchuWeb_GalleryModelTags extends JModelList
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
                'name', 'a.name'
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
    public function getTable($type = 'Tag', $prefix = 'SchuWeb_GalleryTable', $config = array())
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
                'a.id AS id, a.name AS name'
            )
        );
        $query->from($db->quoteName('#__schuweb_gallery_tags').' AS a');

        // Filter by published state
        /*$published = $this->getState('filter.state');
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
          */
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
        parent::populateState('a.name', 'asc');
    }
}
