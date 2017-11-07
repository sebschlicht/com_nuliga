<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 03.11.17
 * Time: 14:19
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<div class="nuliga">
    <h1 ><?php echo $this->team; ?></h1>

    <?php if ($this->teams): ?>
    <table>
    <tr>
        <th>Rang</th>
        <th>Mannschaft</th>
        <th>Begegnungen</th>
        <th>S</th>
        <th>U</th>
        <th>N</th>
        <th>Tore</th>
        <th>+/-</th>
        <th>Punkte</th>
    </tr>
    <?php foreach($this->teams as $team): ?>
        <tr<?php if (in_array($team->name, $this->highlight)) echo ' class="highlight"'; ?>>
            <td><?php echo $team->rank; ?></td>
            <td><?php echo $team->name; ?></td>
            <td><?php echo $team->numMatches; ?></td>
            <td><?php echo $team->numWins; ?></td>
            <td><?php echo $team->numDraws; ?></td>
            <td><?php echo $team->numLosses; ?></td>
            <td><?php echo $team->goals; ?></td>
            <td><?php echo $team->goalDiff; ?></td>
            <td><?php echo $team->points; ?></td>
        </tr>
    <?php endforeach; ?>
    </table>
    <?php else: ?>
    <p><?php echo JText::_('COM_NULIGA_NULIGA_RENDERING_FAILURE');?></p>
    <?php endif; ?>
</div>
