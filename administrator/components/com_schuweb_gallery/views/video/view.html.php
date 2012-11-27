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

class SchuWeb_GalleryViewVideo extends JViewLegacy
{

    protected $form;

    protected $item;

    protected $state;

    /**
     * Display the view
     *
     * @since    1.6
     */
    public function display($tpl = null)
    {
        JToolbarHelper::title('SchuWeb Gallery');

        $this->form = $this->get('Form');
        $this->item	= $this->get('Item');
        $this->state = $this->get('State');

        $this->addToolbar();

        parent::display($tpl);
    }

    protected function addToolbar()
    {
        $user = JFactory::getUser();
        $userId = $user->get('id');
        $isNew = ($this->item->id == 0);
        $checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
        $canDo = GalleryHelper::getActions();


        if ($canDo->get('core.admin')) {
            JToolbarHelper::preferences('com_schuweb_gallery');
            JToolbarHelper::divider();
        }

        // For new records, check the create permission.
        if ($isNew && (count($user->getAuthorisedCategories('com_schuweb_gallery', 'core.create')) > 0)) {
            JToolbarHelper::apply('video.apply');
            JToolbarHelper::save('video.save');
            JToolbarHelper::save2new('video.save2new');
            JToolbarHelper::cancel('video.cancel');
        } else {
            // Can't save the record if it's checked out.
            if (!$checkedOut) {
                // Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
                if ($canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $userId)) {
                    JToolbarHelper::apply('video.apply');
                    JToolbarHelper::save('video.save');

                    // We can save this record, but check the create permission to see if we can return to make a new one.
                    if ($canDo->get('core.create')) {
                        JToolbarHelper::save2new('video.save2new');
                    }
                }
            }

            // If checked out, we can still save
            if ($canDo->get('core.create')) {
                JToolbarHelper::save2copy('video.save2copy');
            }

            JToolbarHelper::cancel('video.cancel', 'JTOOLBAR_CLOSE');
        }
    }
}