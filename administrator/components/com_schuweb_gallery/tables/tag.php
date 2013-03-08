<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Video table
 *
 * @package     Joomla.Administrator
 * @subpackage  com_schuweb_gallery
 * @since       1.5
 */
class SchuWeb_GalleryTableTag extends JTable
{
	/**
	 * Constructor
	 *
	 * @since	1.5
	 */
	public function __construct(&$_db)
	{
		parent::__construct('#__schuweb_gallery_tags', 'id', $_db);
	}

    public function loadTags() {
        $query = $this->_db->getQuery(true);
        $query->select('*')
            ->from($this->_tbl);

        $this->_db->setQuery($query);

        return $this->_db->loadAssocList();
    }

}
