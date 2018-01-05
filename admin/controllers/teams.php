<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 04.01.18
 * Time: 16:25
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Administration controller for the NuLiga team list.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_nuliga
 * @since  0.0.28
 */
class NuLigaControllerTeams extends JControllerAdmin
{
    /**
     * Proxy for getModel.
     *
     * @param   string  $name    The model name. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  object  The model.
     *
     * @since   1.6
     */
    public function getModel($name = 'Team', $prefix = 'NuLigaModel', $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);

        return $model;
    }
}
