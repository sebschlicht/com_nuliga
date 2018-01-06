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
class NuLigaUpdateMatches extends NuLigaUpdateBase
{   
    function __construct()
    {
        $this->dbTableName = '#__nuliga_matches';
        $this->dbColumns = ['teamid', 'position', 'weekday', 'date', 'time', 'hall', 'nr', 'home', 'guest', 'goals',
                            'reportUrl', 'isPlayed'];
    }
    
    protected function onClearFailed($errorMessage, $teamId)
    {
        JLog::add("Failed to clear matches of NuLiga team #$teamId!", JLog::WARNING, 'jerror');
        JLog::add($errorMessage, JLog::WARNING, 'jerror');
    }
    
    protected function onInsertionFailed($errorMessage, $teamId)
    {
        JLog::add("Failed to insert matches for NuLiga team #$teamId!", JLog::WARNING, 'jerror');
        JLog::add($errorMessage, JLog::WARNING, 'jerror');
    }
    
    protected function validate($item)
    {
        if (intval($item['nr']) <= 0)
        {
            JLog::add('Failed to insert match for NuLiga team #' . $item[$this->dbColumnTeam]
                      . ": Invalid match number '" . $item['nr'] . "'!", JLog::WARNING, 'jerror');
            return false;
        }
        else
        {
            return true;
        }
    }
}
