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
 * NuLigaList Model
 *
 * @since  0.0.7
 */
class NuLigaModelNuLigas extends JModelList
{
    /**
     * Method to build an SQL query to load the list data.
     *
     * @return      string  An SQL query
     */
    protected function getListQuery()
    {
        // Initialize variables.
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);

        // Create the base select statement.
        $query->select('*')
            ->from($db->quoteName('#__nuliga'));

        return $query;
    }
}
