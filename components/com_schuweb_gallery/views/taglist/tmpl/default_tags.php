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
    <?php foreach ($this->tags as $tag) : ?>
    <li>
        <a href="<?php echo JRoute::_("index.php?option=com_schuweb_gallery&view=tag&tagid=".$tag->id) ?>"><?php echo $tag->name ?></a>
    </li>
    <?php endforeach; ?>
</ul>