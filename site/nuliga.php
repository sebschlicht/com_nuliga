<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 03.11.17
 * Time: 14:04
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// get NuLiga controller instance
$controller = JControllerLegacy::getInstance('NuLiga');

// perform requested task
$controller->execute(JFactory::getApplication()->input->getCmd('task'));

// redirect if requested by controller
$controller->redirect();
