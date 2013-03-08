<?php
/**
 * @package     Joomla
 * @subpackage  com_schuweb_gallery
 *
 * @copyright   Copyright (C) 2012 Schultschik Websolution / Sven Schultschik. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');

$user = JFactory::getUser();
$userId = $user->get('id');
$sortFields = $this->getSortFields();

?>
<script type="text/javascript">
    Joomla.orderTable = function () {
        table = document.getElementById("sortTable");
        direction = document.getElementById("directionTable");
        order = table.options[table.selectedIndex].value;
        if (order != '<?php echo $listOrder; ?>') {
            dirn = 'asc';
        } else {
            dirn = direction.options[direction.selectedIndex].value;
        }
        Joomla.tableOrdering(order, dirn, '');
    }
</script>
<form action="<?php echo JRoute::_('index.php?option=com_schuweb_gallery&view=images'); ?>"
      method="post"
      name="adminForm"
      id="adminForm">
    <?php if (!empty($this->sidebar)): ?>
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
	<div id="j-main-container" class="span10">
    <?php else : ?>
	<div id="j-main-container">
    <?php endif;?>
    <div class="clearfix"></div>
    <?php echo $this->folders; ?>
    <table class="table table-striped" id="articleList">
        <thead>
        <tr>
            <!--th width="1%" class="hidden-phone">
                <input type="checkbox" name="checkall-toggle" value=""
                       title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)"/>
            </th-->
            <th>
                <?php  ?>
            </th>
            <th class="nowrap center hidden-phone">
                <?php  ?>
            </th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="13">
                <?php //echo $this->pagination->getListFooter(); ?>
            </td>
        </tr>
        </tfoot>
        <tbody>
        <?php foreach ($this->items as $i => $item) :
            //$ordering = ($listOrder == 'ordering');
            //$item->cat_link = JRoute::_('index.php?option=com_categories&extension=com_banners&task=edit&type=other&cid[]=' . $item->catid);
            //$canCreate = $user->authorise('core.create', 'com_banners.category.' . $item->catid);
            //$canEdit = $user->authorise('core.edit', 'com_schuweb_gallery' . $item->id);
            //$canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
            //$canChange = $user->authorise('core.edit.state', 'com_schuweb_gallery.' . $item->id) && $canCheckin;
            ?>
        <tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php //echo $item->id?>">
            <!--td class="center hidden-phone">
                <?php //echo JHtml::_('grid.id', $i, $item->id); ?>
            </td-->
            <td class="nowrap has-context">
                <div class="pull-left">
                    <?php //if ($canEdit) : ?>
                    <a href="<?php echo JRoute::_('index.php?option=com_schuweb_gallery&task=image.edit&file=' . preg_replace('/\//', '--', $item).'&path=' . $this->path); ?>">
                        <?php echo $this->escape($item); ?></a>
                    <?php //else : ?>
                    <?php //echo $this->escape($item->name); ?>
                    <?php //endif; ?>
                    <div class="small">
                        <?php //echo $this->escape($item->category_title); ?>
                    </div>
                </div>
            </td>

            <!--td class="small nowrap hidden-phone">
                <?php if ($item->language == '*'): ?>
                <?php echo JText::alt('JALL', 'language'); ?>
                <?php else: ?>
                <?php echo $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
                <?php endif;?>
            </td-->
        </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="0"/>
    <?php echo JHtml::_('form.token'); ?>
</div>
</form>