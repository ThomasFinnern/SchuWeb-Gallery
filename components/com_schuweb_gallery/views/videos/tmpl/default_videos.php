<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_schuweb_gallery
 *
 * @copyright   Copyright (C) 2012 Schultschik Websolution, Sven Schultschik. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

?>
<ul class="thumbnails">
    <?php foreach ($this->videos as $video) : ?>
        <li class="span<?php echo $this->video_grid_size; ?>">
            <?php if ($video->video_service == 'SCHUWEB_GALLERY_VIMEO') : ?>
                <a href="http://player.vimeo.com/video/<?php echo $video->video_id ?>" class="vimeo groupVideos">
                    <img src="<?php //echo $image['thumb']; ?>" alt="<?php echo $video->name; ?>">
                </a>
            <?php endif; ?>
            <?php if ($video->video_service == 'SCHUWEB_GALLERY_YOUTUBE') : ?>
                <a href="http://www.youtube.com/embed/<?php echo $video->video_id ?>?rel=0&amp;wmode=transparent&amp;enablejsapi=1"
                   class="youtube groupVideos">
                    <img src="<?php //echo $image['thumb']; ?>" alt="<?php echo $video->name; ?>">
                </a>
            <?php endif; ?>

            <?php if ($this->displayVideoName == 1) : ?>
                <h5><?php echo $video->name; ?></h5>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>