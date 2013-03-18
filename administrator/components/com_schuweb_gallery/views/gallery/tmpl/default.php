<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Editors-xtd.schuweb_gallery
 *
 * @copyright   Copyright (C) 2012 Schultschik Websolution / Sven Schultschik. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

?>
<form action="<?php echo JRoute::_('index.php?option=com_schuweb_gallery'); ?>" method="post" name="adminForm"
      id="adminForm">
    <?php if (!empty($this->sidebar)): ?>
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
	<div id="j-main-container" class="span10">
    <?php else : ?>
	<div id="j-main-container">
    <?php endif;?>
    <div class="cpanel-left span9 hidden-phone">

    </div>
    <div class="cpanel-right span3 width-40">
        <div class="well well-small">
            <h4>About SchuWeb Gallery</h4>
            <ul>
                <li><a href="http://extensions.schultschik.com/support" title="Support Website">Support</a></li>
                <li><a href="http://extensions.schultschik.com/documentation" title="Documentation Website">Documentation</a></li>
                <li><a href="http://extensions.schultschik.com/products/57-schuweb-gallery-features" title="Comparison Website">SchuWeb Gallery Pro features</a></li>
            </ul>
        </div>
        <div class="well well-small">
            <h4>Wall of Honor</h4>
            <strong>Libraries:</strong>
            <ul>
                <li><a href="http://www.jacklmoore.com/colorbox" title="Colorbox Website">Colorbox</a> by Jack Moore</li>
                <li><a href="http://twitter.github.com/bootstrap" title="Bootstrap Website">Twitter Bootstrap</a></li>
            </ul>
        </div>
    </div>
    <input type="hidden" name="task" value=""/>
</form>
