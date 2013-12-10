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
<div>
    <?php if ($this->prevButtonPosition == 1 || $this->prevButtonPosition == 3) : ?>
        <a href="<?php echo $this->backPath; ?>" class="btn btn-primary"><?php echo JText::_('JPREV'); ?></a>
    <?php endif; ?>
    
    <?php if ($this->folders) echo $this->loadTemplate('folders'); ?>

    <?php if ($this->images) echo $this->loadTemplate('images'); ?>

    <?php if ($this->prevButtonPosition == 2 || $this->prevButtonPosition == 3) : ?>
        <a href="<?php echo $this->backPath; ?>" class="btn btn-primary"><?php echo JText::_('JPREV'); ?></a>
    <?php endif; ?>
</div>