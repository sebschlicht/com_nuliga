<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 07.01.18
 * Time: 14:21
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

JHtml::_('formbehavior.chosen', 'select');

$listOrder     = $this->escape($this->filter_order);
$listDirn      = $this->escape($this->filter_order_Dir);
?>
<form action="index.php?option=com_nuliga&view=matches" method="post" id="adminForm" name="adminForm">
    <div class="row-fluid">
        <div class="span6">
            <?php
            echo JLayoutHelper::render(
                'joomla.searchtools.default',
                array('view' => $this)
            );
            ?>
        </div>
    </div>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th width="1%"><?php echo JText::_('COM_NULIGA_NUM'); ?></th>
            <th width="2%">
                <?php echo JHtml::_('grid.checkall'); ?>
            </th>
            <th width="12%">
                <?php echo JHtml::_('grid.sort', 'COM_NULIGA_TEAM_MATCHES_TEAMID', 'teamid', $listDirn, $listOrder); ?>
            </th>
            <th width="15%">
                <?php echo JHtml::_('grid.sort', 'COM_NULIGA_TEAM_MATCHES_NR', 'nr', $listDirn, $listOrder); ?>
            </th>
            <th width="20%">
                <?php echo JHtml::_('grid.sort', 'COM_NULIGA_TEAM_MATCHES_DATE', 'date', $listDirn, $listOrder); ?>
            </th>
            <th width="25%">
                <?php echo JHtml::_('grid.sort', 'COM_NULIGA_TEAM_MATCHES_HOME', 'home', $listDirn, $listOrder); ?>
            </th>
            <th width="25%">
                <?php echo JHtml::_('grid.sort', 'COM_NULIGA_TEAM_MATCHES_GUEST', 'guest', $listDirn, $listOrder); ?>
            </th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="7">
                <?php echo $this->pagination->getListFooter(); ?>
            </td>
        </tr>
        </tfoot>
        <tbody>
        <?php if (!empty($this->items)) : ?>
            <?php foreach ($this->items as $i => $row): ?>
                <tr>
                    <td>
                        <?php echo $this->pagination->getRowOffset($i); ?>
                    </td>
                    <td>
                        <?php echo JHtml::_('grid.id', $i, $row->id); ?>
                    </td>
                    <td>
                        <?php echo $row->teamid; ?>
                    </td>
                    <td>
                        <?php echo $row->nr; ?>
                    </td>
                    <td>
                        <?php echo $row->date; ?>
                    </td>
                    <td>
                        <?php echo $row->home; ?>
                    </td>
                    <td>
                        <?php echo $row->guest; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="0"/>
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
    <?php echo JHtml::_('form.token'); ?>
</form>
