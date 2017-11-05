<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 03.11.17
 * Time: 14:04
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// custom icon declarations
$document = JFactory::getDocument();
$document->addStyleDeclaration('.icon-nuliga {background-image: url(../media/com_nuliga/images/Tux-16x16.png);}');

// get NuLiga controller instance
$controller = JControllerLegacy::getInstance('NuLiga');

// perform requested task
$controller->execute(JFactory::getApplication()->input->get('task'));

// redirect if requested by controller
$controller->redirect();
