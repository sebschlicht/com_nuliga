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
 * Helper to update league teams in the database.
 *
 * @since 0.0.17
 */
class NuLigaUpdateLeague
{
    /**
     * NuLiga league teams table name
     */
    const DB_TABLE_NAME = '#__nuliga_leagueteams';

    /**
     * NuLiga league teams table columns
     */
    const DB_TABLE_COLUMNS = array('tabid', 'rank', 'name', 'numMatches', 'numWins', 'numDraws', 'numLosses', 'goals',
        'goalDiff', 'points');

    /**
     * NuLiga league teams table column: NuLiga table id
     */
    const DB_TABLE_COLUMN_TABLEID = 'tabid';

    /**
     * Stores the current NuLiga league teams in the database.
     *
     * @param $tableId int NuLiga table id
     * @param $leagueteams array current league teams
     * @return bool true if the database update was successful, otherwise false
     */
    public function update($tableId, $leagueteams)
    {
        $db = JFactory::getDbo();

        // add NuLiga table id
        $numLeagueTeams = count($leagueteams);
        for ($i = 0; $i < $numLeagueTeams; $i++)
        {
            $leagueteams[$i][self::DB_TABLE_COLUMN_TABLEID] = $tableId;
        }

        // re-insert league teams
        if (self::removeLeagueTeams($db, $tableId)) {
            foreach ($leagueteams as $leagueteam)
            {
                $values = self::getValues($db, $leagueteam);

                $query = $db->getQuery(true);
                $query->insert($db->quoteName(self::DB_TABLE_NAME))
                    ->columns($db->quoteName(self::DB_TABLE_COLUMNS))
                    ->values($values);

                $db->setQuery($query);
                if (!$db->execute())
                {
                    // error: insert failed
                    JLog::add("Failed to insert league teams for NuLiga table #$tableId!", JLog::WARNING, 'jerror');
                    JLog::add($db->getErrorMsg(), JLog::WARNING, 'jerror');
                    return false;
                }
            }
        }
        return true;
    }
    
    /**
     * Removes all legaue teams currently stored in the database for the current NuLiga table.
     *
     * @param $db JDatabaseDriver dbo to be used
     * @param $tableId int NuLiga table id
     * @return bool true if the operation was successful, otherwise false
     */
    protected static function removeLeagueTeams($db, $tableId)
    {
        $query = $db->getQuery(true);

        $query->delete(self::DB_TABLE_NAME)
            ->where($db->quoteName(self::DB_TABLE_COLUMN_TABLEID) . ' = ' . $db->quote((int) $tableId));

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
            array_push($values, $db->quote($array[$column]));
        }
        return implode(',', $values);
    }
}
