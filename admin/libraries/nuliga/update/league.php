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

        // insert/update league teams
        foreach ($leagueteams as $leagueteam)
        {
            if (!self::isLeagueteamExisting($tableId, $leagueteam['name']))
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
            else
            {
                $fields = self::getFields($db, $leagueteam);

                $query = $db->getQuery(true);
                $query->update(self::DB_TABLE_NAME)
                    ->set($fields)
                    ->where($db->quoteName('name') . ' = ' . $db->quote($leagueteam['name']));

                $db->setQuery($query);

                if (!$db->execute())
                {
                    // error: update failed
                    JLog::add("Failed to update league teams for NuLiga table #$tableId!", JLog::WARNING, 'jerror');
                    JLog::add($db->getErrorMsg(), JLog::WARNING, 'jerror');
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Checks if a league team is existing in the respective table.
     *
     * @param $tableId int NuLiga table id
     * @param $name string team name
     * @return bool true if the league team is existing, otherwise false
     */
    protected static function isLeagueteamExisting($tableId, $name)
    {
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('COUNT(*)')
            ->from(self::DB_TABLE_NAME)
            ->where(array(
                'name = ' . $db->quote($name),
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
