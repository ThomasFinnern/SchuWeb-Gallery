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
class SchuWeb_GalleryTableVideo extends JTable
{
	/**
	 * Constructor
	 *
	 * @since	1.5
	 */
	public function __construct(&$_db)
	{
		parent::__construct('#__schuweb_gallery_videos', 'id', $_db);
		$date = JFactory::getDate();
		$this->created = $date->toSql();
	}

    /**
     * Method to set the publishing state for a row or list of rows in the database
     * table.  The method respects checked out rows by other users and will attempt
     * to checkin rows that it can after adjustments are made.
     *
     * @param	mixed	An optional array of primary key values to update.  If not
     *					set the instance property value is used.
     * @param	integer The publishing state. eg. [0 = unpublished, 1 = published, 2=archived, -2=trashed]
     * @param	integer The user id of the user performing the operation.
     * @return	boolean	True on success.
     * @since	1.6
     */
    public function publish($pks = null, $state = 1, $userId = 0)
    {
        $k = $this->_tbl_key;

        // Sanitize input.
        JArrayHelper::toInteger($pks);
        $userId = (int) $userId;
        $state  = (int) $state;

        // If there are no primary keys set check to see if the instance key is set.
        if (empty($pks))
        {
            if ($this->$k) {
                $pks = array($this->$k);
            }
            // Nothing to set publishing state on, return false.
            else {
                $this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
                return false;
            }
        }

        // Get an instance of the table
        $table = JTable::getInstance('Video', 'SchuWeb_GalleryTable');

        // For all keys
        foreach ($pks as $pk)
        {
            // Load the banner
            if(!$table->load($pk))
            {
                $this->setError($table->getError());
            }

            // Verify checkout
            if ($table->checked_out == 0 || $table->checked_out == $userId)
            {
                // Change the state
                $table->state = $state;
                $table->checked_out = 0;
                $table->checked_out_time = $this->_db->getNullDate();

                // Check the row
                $table->check();

                // Store the row
                if (!$table->store())
                {
                    $this->setError($table->getError());
                }
            }
        }
        return count($this->getErrors()) == 0;
    }
}
