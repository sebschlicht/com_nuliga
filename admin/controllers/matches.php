<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 07.01.18
 * Time: 14:15
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Administration controller for the NuLiga match list.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_nuliga
 * @since  0.0.42
 */
class NuLigaControllerMatches extends JControllerAdmin
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
    public function getModel($name = 'Matches', $prefix = 'NuLigaModel', $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);

        return $model;
    }
}
