<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 03.11.17
 * Time: 15:05
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * NuLiga Table class
 *
 * @since  0.0.6
 */
class NuLigaTableNuLiga extends JTable
{
    /**
     * Constructor
     *
     * @param   JDatabaseDriver  &$db  A database connector object
     */
    function __construct(&$db)
    {
        parent::__construct('#__nuliga', 'id', $db);
    }
}
