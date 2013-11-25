<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Editors-xtd.schuweb_gallery
 *
 * @copyright   Copyright (C) 2012 Schultschik Websolution / Sven Schultschik. All rights reserved.
 * @license     GNU General Public License version 2 or later
 **/

defined('_JEXEC') or die;

require_once(JPATH_ADMINISTRATOR . '/components/com_schuweb_gallery/helpers/gallery.php');

class SchuWeb_GalleryViewVideos extends JViewLegacy
{
    protected $state;

    /**
     * Display the view
     *
     */
    public function display($tpl = null)
    {
        //$this->categories	= $this->get('CategoryOrders');
        $this->items		= $this->get('Items');
        $this->pagination	= $this->get('Pagination');
        $this->state		= $this->get('State');

        JToolbarHelper::title('SchuWeb Gallery');
        $this->addToolbar();
        $this->sidebar = JHtmlSidebar::render();

        parent::display($tpl);
    }

    protected function addToolbar()
    {
        $canDo = GalleryHelper::getActions();

        if ($canDo->get('core.admin')) {
            JToolbarHelper::preferences('com_schuweb_gallery');
            JToolbarHelper::divider();
            JToolbarHelper::addNew('video.add');
        }

        if ($canDo->get('core.edit')) {
            JToolbarHelper::editList('video.edit');
        }

        if ($canDo->get('core.edit.state'))
        {
            if ($this->state->get('filter.state') != 2)
            {
                JToolbarHelper::publish('videos.publish', 'JTOOLBAR_PUBLISH', true);
                JToolbarHelper::unpublish('videos.unpublish', 'JTOOLBAR_UNPUBLISH', true);
            }

            if ($this->state->get('filter.state') != -1)
            {
                if ($this->state->get('filter.state') != 2)
                {
                 //   JToolbarHelper::archiveList('videos.archive');
                }
                elseif ($this->state->get('filter.state') == 2)
                {
                 //   JToolbarHelper::unarchiveList('videos.publish');
                }
            }
        }

        if ($canDo->get('core.edit.state'))
        {
          //  JToolbarHelper::checkin('videos.checkin');
        }

        if ($this->state->get('filter.state') == -2 && $canDo->get('core.delete'))
        {
          //  JToolbarHelper::deleteList('', 'videos.delete', 'JTOOLBAR_EMPTY_TRASH');
        }
        elseif ($canDo->get('core.edit.state')) {
          //  JToolbarHelper::trash();
        }


        JHtmlSidebar::addEntry(JText::_('SCHUWEB_GALLERY_CP'),'index.php?option=com_schuweb_gallery');

        JHtmlSidebar::addEntry(JText::_('SCHUWEB_GALLERY_IMAGES'), 'index.php?option=com_schuweb_gallery&view=images');

        JHtmlSidebar::addEntry(JText::_('SCHUWEB_GALLERY_VIDEOS'),'index.php?option=com_schuweb_gallery&view=videos', true);

        JHtmlSidebar::addFilter(
            JText::_('JOPTION_SELECT_PUBLISHED'),
            'filter_state',
            JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true)
        );
    }

    /**
     * Returns an array of fields the table can be sorted by
     *
     * @return  array  Array containing the field name to sort by as the key and display text as value
     *
     */
    protected function getSortFields()
    {
        return array(
            'ordering' => JText::_('JGRID_HEADING_ORDERING'),
            'a.state' => JText::_('JSTATUS'),
            'a.video_id' => JText::_('SCHUWEB_GALLERY_VIDEOID'),
            'a.video_service' => JText::_('SCHUWEB_GALLERY_VIDEO_SERVICE'),
            'a.id' => JText::_('JGRID_HEADING_ID')
        );
    }
}