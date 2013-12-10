<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_schuweb_gallery
 *
 * @copyright   Copyright (C) 2012 Schultschik Websolution, Sven Schultschik. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

jimport('joomla.filesystem.folder');
require_once(JPATH_ADMINISTRATOR . '/components/com_schuweb_gallery/helpers/thumbs.php');

class SchuWeb_GalleryViewTagList extends JViewLegacy
{
    protected $tags = array();

    public function display($tpl = null)
    {
        $model = JModelList::getInstance('TagList', 'SchuWeb_GalleryModel');

        $this->tags = $model->getItems();
        parent::display($tpl);
    }

}