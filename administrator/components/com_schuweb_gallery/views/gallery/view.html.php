<?php
    /**
     * @package     Joomla.Plugin
     * @subpackage  Editors-xtd.schuweb_gallery
     *
     * @copyright   Copyright (C) 2012 Schultschik Websolution / Sven Schultschik. All rights reserved.
     * @license     GNU General Public License version 2 or later
     **/

    defined('_JEXEC') or die;

jimport( 'joomla.html.parameter.element.folderlist' );

class SchuWeb_GalleryViewImages extends JViewLegacy
{
    protected $state;
    /**
     * Display the view
     *
     * @since	1.6
     */
    public function display($tpl = null)
    {
        JHtml::_('script', 'com_schuweb_gallery/modal.js', true, true);

        $document = JFactory::getDocument();
        $document->addScriptDeclaration("var SchuWebGallery = window.parent.SchuWebGallery;");

        $this->form = $this->get('Form');
        $this->folderList = $this->get('folderList');
        //$this->state = $this->get('state');
        parent::display($tpl);
    }
}