<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_schuweb_gallery
 *
 * @copyright   Copyright (C) 2012 Schultschik Websolution, Sven Schultschik, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

// import Joomla controller library
jimport('joomla.application.component.controller');
jimport('joomla.filesystem.folder');

/**
 * SchuWeb Gallery master display controller.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_schuweb_gallery
 */
class SchuWeb_GalleryController extends JControllerLegacy
{
    /**
     * Method to display a view.
     *
     * @param    boolean            If true, the view output will be cached
     * @param    array            An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return    JController        This object to support chaining.
     */
    public function display($cachable = false, $urlparams = false)
    {
        // set default view if not set
        $input = JFactory::getApplication()->input;
        $input->set('view', $input->get('view', 'gallery'));

        parent::display($cachable, $urlparams);
    }

    public function recreate()
    {
        require_once(JPATH_ADMINISTRATOR . '/components/com_schuweb_gallery/helpers/thumbs.php');
        $helper = new ThumbsHelper();
        $folders = JFolder::folders(JPATH_ROOT . '/' . $helper->getParams()->get('start_folder'), '.', true, true, $helper->getFolder_excludes());
        foreach ($folders as $folder) {
            //echo         'Folder: '.$folder . '/thumbs<br />';
            if (JFolder::exists($folder . '/thumbs')) {
                //echo         'Deleted: '.$folder . '/thumbs<br />';
                JFolder::delete($folder . '/thumbs');
            }
            $helper->getThumbs($folder);
        }

        $this->setRedirect('index.php?option=com_schuweb_gallery', 'SCHUWEB_GALLERY_RECREATE_SUCCESS');

    }
}
