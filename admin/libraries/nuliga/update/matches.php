<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 07.11.17
 * Time: 16:48
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Helper to update matches in the database.
 *
 * @since 0.0.19
 */
class NuLigaUpdateMatches
{
    /**
     * NuLiga matches table name
     */
    const DB_TABLE_NAME = '#__nuliga_matches';

    /**
     * NuLiga matches table columns
     */
    const DB_TABLE_COLUMNS = array('tabid', 'weekday', 'date', 'time', 'hall', 'nr', 'home', 'guest', 'goals',
        'reportUrl', 'isPlayed');

    /**
     * NuLiga matches table column: NuLiga table id
     */
    const DB_TABLE_COLUMN_TABLEID = 'tabid';

    /**
     * Stores the current NuLiga matches in the database.
     *
     * @param $tableId int NuLiga table id
     * @param $matches array current matches
     * @return bool true if the database update was successful, otherwise false
     */
    public function update($tableId, $matches)
    {
        $db = JFactory::getDbo();

        // add NuLiga table id
        $numMatches = count($matches);
        for ($i = 0; $i < $numMatches; $i++)
        {
            $matches[$i][self::DB_TABLE_COLUMN_TABLEID] = $tableId;
        }

        // insert/update matches
        foreach ($matches as $match)
        {
            if (!self::isMatchExisting($tableId, $match['nr']))
            {
                $values = self::getValues($db, $match);

                $query = $db->getQuery(true);
                $query->insert($db->quoteName(self::DB_TABLE_NAME))
                    ->columns($db->quoteName(self::DB_TABLE_COLUMNS))
                    ->values($values);

                $db->setQuery($query);
                if (!$db->execute())
                {
                    // TODO error: insertion failed
                    return false;
                }
            }
            else
            {
                $fields = self::getFields($db, $match);

                $query = $db->getQuery(true);
                $query->update(self::DB_TABLE_NAME)
                    ->set($fields)
                    ->where($db->quoteName('nr') . ' = ' . $db->quote($match['nr']));

                $db->setQuery($query);

                if (!$db->execute())
                {
                    // TODO error: insertion failed
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Checks if a match is existing in the respective table.
     *
     * @param $tableId int NuLiga table id
     * @param $nr string match number
     * @return bool true if the match is existing, otherwise false
     */
    protected static function isMatchExisting($tableId, $nr)
    {
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('COUNT(*)')
            ->from(self::DB_TABLE_NAME)
            ->where(array(
                'nr = ' . $db->quote($nr),
                'tabid = ' . $db->quote((int) $tableId)
            ));

        $db->setQuery($query);
        $result = $db->loadRow();

        return is_array($result) ? (bool) $result[0] : false;
    }

    /**
     * Converts an array to a string which can be passed to the SQL values method.
     *
     * @param $db object dbo
     * @param $array array array
     * @return string imploded and quoted array values
     */
    protected static function getValues($db, $array)
    {
        $values = array();
        foreach (self::DB_TABLE_COLUMNS as $column)
        {
            array_push($values, $db->quote($array[$column]));
        }
        return implode(',', $values);
    }

    /**
     * Converts an array to an array which can be passed to the SQL set method.
     *
     * @param $db object dbo
     * @param $array array array
     * @return array fields array ([key = value])
     */
    protected static function getFields($db, $array)
    {
        $fields = array();
        foreach (self::DB_TABLE_COLUMNS as $column)
        {
            array_push($fields, $db->quoteName($column) . ' = ' . $db->quote($array[$column]));
        }
        return $fields;
    }
}
