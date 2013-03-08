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
class SchuWeb_GalleryTableVideoTags extends JTable
{
    /**
     * Constructor
     *
     * @since    1.5
     */
    public function __construct(&$_db)
    {
        parent::__construct('#__schuweb_gallery_video_tags', 'tagid', $_db);
        $date = JFactory::getDate();
        $this->created = $date->toSql();
    }

    public function loadItemTags($videoid){
        $query = $this->_db->getQuery(true);
        $query->select('tagid')
            ->from($this->_tbl)
            ->where('videoid='.$this->_db->quote($videoid));

        $this->_db->setQuery($query);

        return $this->_db->loadAssocList();

    }

    public function update($tags, $id)
    {
        $query = $this->_db->getQuery(true);
        $query->select('*')
            ->from($this->_tbl)
            ->where($this->_db->quoteName('videoid') . '=' . $this->_db->quote($id));

        $this->_db->setQuery($query);

        $res = $this->_db->loadObjectList();

        if ($res) {

            //Sort out existing entries and delete those which where not in the array
            for ($i = 0; $i < count($res); $i++) {
                $obj = $res[$i];
                $key = array_search($obj->tagid, $tags);

                if ($key === FALSE) {
                    $this->deleteObject($obj);
                } else {
                    unset($tags[$key]);
                }
            }

            //insert the tags array into table
            foreach ($tags as $k => $v) {
                $obj = new JObject();
                $obj->tagid = $v;
                $obj->videoid = $id;

                $this->_db->insertObject($this->_tbl, $obj);
            }
        }

        return true;

    }

    private function deleteObject($obj)
    {
        $query = $this->_db->getQuery(true);
        $query->delete($this->_tbl)
            ->where($this->_db->quoteName($this->_tbl_key) . '=' . $this->_db->quote($obj->tagid))
            ->where($this->_db->quoteName('videoid') . '=' . $this->_db->quote($obj->videoid));

        $this->_db->setQuery($query);

        return $this->_db->execute();
    }
}
