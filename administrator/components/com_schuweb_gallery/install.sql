CREATE TABLE IF NOT EXISTS `#__schuweb_gallery_videos` (
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
);

CREATE TABLE IF NOT EXISTS `#__schuweb_gallery_image_tags` (
  `tagid` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`tagid`),
  KEY `path` (`path`),
  KEY `image` (`image`)
);

CREATE TABLE IF NOT EXISTS `#__schuweb_gallery_video_tags` (
  `tagid` int(11) NOT NULL,
  `videoid` int(11) NOT NULL,
  UNIQUE KEY `tagid` (`tagid`,`videoid`),
  KEY `videoid` (`videoid`)
);
