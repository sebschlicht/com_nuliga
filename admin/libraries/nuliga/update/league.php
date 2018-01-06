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
class NuLigaUpdateLeague extends NuLigaUpdateBase
{
    function __construct()
    {
        $this->dbTableName = '#__nuliga_leagueteams';
        $this->dbColumns = ['teamid', 'rank', 'name', 'numMatches', 'numWins', 'numDraws', 'numLosses', 'goals',
                            'goalDiff', 'points'];
    }
    
    protected function onClearFailed($errorMessage, $teamId)
    {
        JLog::add("Failed to clear league teams of NuLiga team #$teamId!", JLog::WARNING, 'jerror');
        JLog::add($errorMessage, JLog::WARNING, 'jerror');
    }
    
    protected function onInsertionFailed($errorMessage, $teamId)
    {
        JLog::add("Failed to insert league team for NuLiga team #$teamId!", JLog::WARNING, 'jerror');
        JLog::add($errorMessage, JLog::WARNING, 'jerror');
    }
    
    protected function validate($item)
    {
        return true;
    }
}
