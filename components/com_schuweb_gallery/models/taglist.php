<?php
/**
 * @package     Joomla.Site
 * @subpackage  schuweb_gallery
 *
 * @copyright   Copyright (C) 2012 Schultschik Websolution / Sven Schultschik. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

/**
 * Filter model class for Finder.
 *
 * @package     Joomla.Site
 * @subpackage  com_schuweb_gallery
 */
class SchuWeb_GalleryModelTagList extends JModelList
{
    function getItems()
    {
        // Which tags should be displayed
        $app = JFactory::getApplication();
        $menuparams = $app->getParams();

        $tagListDisplayOption = $menuparams->get('tagListDisplayOption');

        //Get the data from DB
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        if ($tagListDisplayOption == "used" || $tagListDisplayOption == "image") {

            //Get all tags from image table
            $query->select("DISTINCT t.id, t.title")
                ->from("#__schuweb_gallery_image_tags AS it")
                ->leftJoin('#__tags AS t ON it.tagid = t.id');

        } elseif ($tagListDisplayOption == "video") {
            $query->select("DISTINCT t.id, t.title")
                ->from("#__schuweb_gallery_video_tags AS it")
                ->leftJoin('#__tags AS t ON it.tagid = t.id');

        } else { //Select all available tags
            $query->select("*")
                ->from("#__tags AS t")
                ->where("t.title != 'ROOT'");
        }

        $query->where('t.published = 1');

        $db->setQuery($query);
        $tags = $db->loadObjectList();

        if ($tagListDisplayOption == "used") {
            //Get all tags from videos but not those which we have already
            $query = $db->getQuery(true);

            $query->select("DISTINCT t.id, t.title")
                ->from("#__tags AS t")
                ->rightJoin('#__schuweb_gallery_video_tags AS vt ON vt.tagid = t.id')
                ->where("t.id != ANY (SELECT it.tagid FROM #__schuweb_gallery_image_tags AS it)")
                ->where("t.published = 1");
            $db->setQuery($query);
            $tags2 = $db->loadObjectList();


            //concat both tag lists
            $tags = array_merge($tags, $tags2);
        }

        return $tags;
    }
}