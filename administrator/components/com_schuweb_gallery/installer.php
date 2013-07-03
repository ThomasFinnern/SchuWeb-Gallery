<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_schuweb_gallery
 *
 * @copyright   Copyright (C) 2013 Schultschik Websolution, Sven Schultschik, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

class com_schuweb_galleryInstallerScript
{
    /**
     * Constructor
     *
     * @param   JAdapterInstance $adapter  The object responsible for running this script
     */
    public function __constructor(JAdapterInstance $adapter)
    {
    }

    /**
     * Called before any type of action
     *
     * @param   string $route  Which action is happening (install|uninstall|discover_install)
     * @param   JAdapterInstance $adapter  The object responsible for running this script
     *
     * @return  boolean  True on success
     */
    public function preflight($route, JAdapterInstance $adapter)
    {
    }

    /**
     * Called after any type of action
     *
     * @param   string $route  Which action is happening (install|uninstall|discover_install)
     * @param   JAdapterInstance $adapter  The object responsible for running this script
     *
     * @return  boolean  True on success
     */
    public function postflight($route, JAdapterInstance $adapter)
    {
    }

    /**
     * Called on installation
     *
     * @param   JAdapterInstance $adapter  The object responsible for running this script
     *
     * @return  boolean  True on success
     */
    public function install(JAdapterInstance $adapter)
    {
    }

    /**
     * Called on update
     *
     * @param   JAdapterInstance $adapter  The object responsible for running this script
     *
     * @return  boolean  True on success
     */
    public function update(JAdapterInstance $adapter)
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select('*')
            ->from('#__schuweb_gallery_videos');
        $db->setQuery($query);
        try {
            $db->loadResult();
        } catch (Exception $e) {
            $query = "CREATE TABLE IF NOT EXISTS `#__schuweb_gallery_videos` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` varchar(30) NOT NULL,
  `video_service` varchar(30) NOT NULL,
  `date` datetime NOT NULL,
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `video_id` (`video_id`),
  UNIQUE KEY `video_id_2` (`video_id`,`video_service`),
  KEY `video_service` (`video_service`),
  KEY `state` (`state`)
)";
            $db->setQuery($query);
            $db->execute();
        }

        $query = $db->getQuery(true);
        $query->select('*')
            ->from('#__schuweb_gallery_image_tags');
        $db->setQuery($query);
        try {
            $db->loadResult();
        } catch (Exception $e) {
            $query = "CREATE TABLE IF NOT EXISTS `#__schuweb_gallery_image_tags` (
        `tagid` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  UNIQUE KEY `tagid` (`tagid`,`path`,`image`),
  KEY `path` (`path`),
  KEY `image` (`image`)
)";
            $db->setQuery($query);
            $db->execute();
        }

        $query = $db->getQuery(true);
        $query->select('*')
            ->from('#__schuweb_gallery_tags');
        $db->setQuery($query);
        try {
            $db->loadResult();
        } catch (Exception $e) {
            $query = "CREATE TABLE IF NOT EXISTS `#__schuweb_gallery_tags` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY(`id`),
  UNIQUE KEY `name` (`name`)
)";
            $db->setQuery($query);
            $db->execute();
        }

        $query = $db->getQuery(true);
        $query->select('*')
            ->from('#__schuweb_gallery_tags');
        $db->setQuery($query);
        if (!$db->loadResult()) {
            $query = "CREATE TABLE IF NOT EXISTS `#__schuweb_gallery_video_tags` (
    `tagid` int(11) NOT NULL,
  `videoid` int(11) NOT NULL,
  UNIQUE KEY `tagid` (`tagid`,`videoid`),
  KEY `videoid` (`videoid`)
)";
            $db->setQuery($query);
            $db->execute();
        }
    }

    /**
     * Called on uninstallation
     *
     * @param   JAdapterInstance $adapter  The object responsible for running this script
     */
    public function uninstall(JAdapterInstance $adapter)
    {
    }
}