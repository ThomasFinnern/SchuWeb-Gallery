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
    <?php foreach ($this->folders as $folder) : ?>
    <li class="span<?php echo $this->folder_grid_size; ?>">
        <a href="index.php?option=com_schuweb_gallery&amp;view=gallery&amp;folder=<?php echo preg_replace('/\//', '.', $folder['folder']); ?>"
           class="thumbnail">
            <img src="<?php echo $folder['image']; ?>" alt="">

            <h3><?php echo $folder['name']; ?></h3>
        </a>
    </li>
    <?php endforeach; ?>
</ul>
