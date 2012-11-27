<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Editors-xtd.schuweb_gallery
 *
 * @copyright   Copyright (C) 2012 Schultschik Websolution / Sven Schultschik. All rights reserved.
 * @license     GNU General Public License version 2 or later
 **/

defined('_JEXEC') or die;

jimport('joomla.html.parameter.element.folderlist');
require_once(JPATH_ADMINISTRATOR . '/components/com_schuweb_gallery/helpers/gallery.php');

class SchuWeb_GalleryViewGallery extends JViewLegacy
{
    protected $state;

    /**
     * Display the view
     *
     * @since    1.6
     */
    public function display($tpl = null)
    {
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
            JToolbarHelper::custom('recreate', 'new', '', 'SCHUWEB_GALLERY_RECREATE_THUMBS', false);
        }

        JHtmlSidebar::addEntry(JText::_('SCHUWEB_GALLERY_CP'),'index.php?option=com_schuweb_gallery', true);

        JHtmlSidebar::addEntry(JText::_('SCHUWEB_GALLERY_VIDEOS'),'index.php?option=com_schuweb_gallery&view=videos');
    }
}