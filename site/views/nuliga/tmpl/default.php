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
<h1 class="nuliga"><?php echo $this->team; ?></h1>
<?php foreach($this->teams as $team): ?>
    <p><?php echo $team->name; ?></p>
<?php endforeach; ?>
