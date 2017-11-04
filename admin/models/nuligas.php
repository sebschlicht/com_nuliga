<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 03.11.17
 * Time: 18:10
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Backend model for the NuLiga table list.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_nuliga
 * @since  0.0.7
 */
class NuLigaModelNuLigas extends JModelList
{
    /**
     * Method to build an SQL query to load the list data.
     *
     * @return      string  SQL query
     */
    protected function getListQuery()
    {
        // initialize variables
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);

        // select all NuLiga tables
        $query->select('*')
            ->from($db->quoteName('#__nuliga'));

        return $query;
    }
}
