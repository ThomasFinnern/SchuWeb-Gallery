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

$user		= JFactory::getUser();
$input = JFactory::getApplication()->input;
//$listOrder	= $this->escape($this->state->get('list.ordering'));
//$listDirn	= $this->escape($this->state->get('list.direction'));

?>
<form action="index.php?option=com_schuweb_gallery&amp;view=images" class="form-horizontal" id="imageForm" method="post" enctype="multipart/form-data">
    <div id="messages" style="display: none;">
        <span id="message"></span><?php echo JHtml::_('image', 'media/dots.gif', '...', array('width' => 22, 'height' => 12), true)?>
    </div>
    <div class="well">
        <div class="row">
            <div class="span9 control-group">
                <div class="control-label">
                    <label class="control-label" for="folder"><?php echo JText::_('COM_SCHUWEB_GALLERY_DIRECTORY') ?></label>
                </div>
                <div class="controls">
                    <?php echo $this->folderList; ?>
                    <?php //if ($this->form != false ) echo $this->form->getInput('folder'); ?>
                </div>
            </div>
        </div>
    </div>
    <iframe id="imageframe" name="imageframe" src="index.php?option=com_media&amp;view=imagesList&amp;tmpl=component&amp;folder=<?php echo $this->folder?>&amp;asset=<?php echo $input->getCmd('asset');?>&amp;author=<?php echo $input->getCmd('author');?>"></iframe>
    <div class="well">
        <div class="row">
            <div class="span9 control-group">
                <div class="control-label">
                    <label class="control-label" for="images"><?php echo JText::_('COM_SCHUWEB_GALLERY_IMAGES') ?></label>
                </div>
                <div class="controls images">

                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="tmpl" name="component" />
</form>