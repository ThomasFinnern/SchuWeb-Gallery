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
                <iframe src="http://player.vimeo.com/video/<?php echo $video->video_id ?>"
                        width="<?php echo $this->video_width; ?>" height="<?php echo $this->video_height; ?>"
                        frameborder="0"
                        webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
            <?php endif; ?>
            <?php if ($video->video_service == 'SCHUWEB_GALLERY_YOUTUBE') : ?>
                <iframe id="player" type="text/html" width="<?php echo $this->video_width; ?>"
                        height="<?php echo $this->video_height; ?>"
                        src="http://www.youtube.com/embed/<?php echo $video->video_id ?>?enablejsapi=1"
                        frameborder="0"></iframe>
            <?php endif; ?>

            <?php if ($this->displayVideoName == 1) : ?>
                <h5><?php echo $video->name; ?></h5>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>