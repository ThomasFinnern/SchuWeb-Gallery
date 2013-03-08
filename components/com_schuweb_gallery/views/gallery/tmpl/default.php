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
    <?php if ($this->folders) echo $this->loadTemplate('folders');?>
    <?php if ($this->images) echo $this->loadTemplate('images');?>
</div>