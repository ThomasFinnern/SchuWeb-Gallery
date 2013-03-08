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
class SchuWeb_GalleryTableImageTags extends JTable
{
    /**
     * Constructor
     *
     * @since    1.5
     */
    public function __construct(&$_db)
    {
        parent::__construct('#__schuweb_gallery_image_tags', null, $_db);
        $date = JFactory::getDate();
        $this->created = $date->toSql();
    }

    public function store($data = array())
    {
        $tags = $data['tags'];

        $query = $this->_db->getQuery(true);
        $query->select('*')
            ->from($this->_tbl)
            ->where('path=' . $this->_db->quote($data['path']))
            ->where('image=' . $this->_db->quote($data['file']));

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
        }

        //insert the tags array into table
        foreach ($tags as $k => $v) {
            $obj = new JObject();
            $obj->tagid = $v;
            $obj->path = $data['path'];
            $obj->image = $data['file'];

            $this->_db->insertObject($this->_tbl, $obj);
        }

        return true;
    }

    private function deleteObject($obj)
    {
        $query = $this->_db->getQuery(true);
        $query->delete($this->_tbl)
            ->where($this->_db->quoteName('tagid') . '=' . $this->_db->quote($obj->tagid))
            ->where($this->_db->quoteName('path') . '=' . $this->_db->quote($obj->path))
            ->where($this->_db->quoteName('image') . '=' . $this->_db->quote($obj->image));

        $this->_db->setQuery($query);

        return $this->_db->execute();
    }

    public function getTags($path, $image)
    {
        $query = $this->_db->getQuery(true);
        $query->select('tagid')
            ->from($this->_tbl)
            ->where('path=' . $this->_db->quote($path))
            ->where('image=' . $this->_db->quote($image));

        $this->_db->setQuery($query);

        return $this->_db->loadAssocList();

    }
}
