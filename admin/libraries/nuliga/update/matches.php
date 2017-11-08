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
     * NuLiga matches table types (if special parsing/formatting necessary)
     */
    const DB_TABLE_TYPES = array(
        'date' => 'date'
    );

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

        // re-insert matches
        if (self::removeMatches($tableId))
        {
            foreach ($matches as $match)
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
        }
        else
        {
            // TODO error: delete failed
            return false;
        }

        return true;
    }

    /**
     * Removes all matches currently stored in the database for the current NuLiga table.
     *
     * @param $tableId int NuLiga table id
     * @return bool true if the operation was successful, otherwise false
     */
    protected static function removeMatches($tableId)
    {
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->delete(self::DB_TABLE_NAME)
            ->where('tabid = ' . $db->quote((int) $tableId));

        $db->setQuery($query);
        return $db->execute();
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
            array_push($values, $db->quote(self::getValue($array, $column)));
        }
        return implode(',', $values);
    }

    /**
     * Retrieves a value from an array, respecting the respective table column's type.
     *
     * @param $array array array
     * @param $key string respective table column name
     * @return null|string formatted value or null on error
     */
    protected static function getValue($array, $key)
    {
        $value = $array[$key];
        switch (self::DB_TABLE_TYPES[$key])
        {
            case 'date':
                // date: format German date as SQL date
                return self::germanToSqlDate($value);

            default:
                // default: text
                return $value;
        }
    }

    /**
     * Formats a German date as a SQL date.
     *
     * @param $date string German date
     * @return null|string SQL date or null if given an invalid date
     */
    protected static function germanToSqlDate($date)
    {
        $datetime = DateTime::createFromFormat('d.m.Y', $date);
        return $datetime ? $datetime->format('Y-m-d') : null;
    }
}