<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 04.01.18
 * Time: 16:21
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * NuLiga team class.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_nuliga
 * @since  0.0.28
 */
class NuLigaTableTeam extends JTable
{
    /**
     * Constructor
     *
     * @param   JDatabaseDriver  &$db  database connector object
     */
    function __construct(&$db)
    {
        parent::__construct('#__nuliga_teams', 'id', $db);
    }
}
