<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 05.01.18
 * Time: 13:49
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Model for single NuLiga teams.
 *
 * @package     Joomla.Site
 * @subpackage  com_nuliga
 * @since  0.0.29
 */
class NuLigaModelTeam extends JModelItem
{
    /**
     * @var JTable NuLiga team
     */
    protected $_team;

    /**
     * Method to get a table object, load it if necessary.
     *
     * @param   string  $type    [table name]
     * @param   string  $prefix  [class prefix]
     * @param   array   $config  [configuration array]
     *
     * @return  JTable  table object
     *
     * @since   1.6
     */
    public function getTable($type = 'Team', $prefix = 'NuLigaTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }
}
