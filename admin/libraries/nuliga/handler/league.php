<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 07.11.17
 * Time: 13:55
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Handler for NuLiga league tables.
 *
 * @since 0.0.16
 */
class NuLigaHandlerLeague extends NuLigaHandlerBase
{
    function __construct()
    {
        parent::__construct();
        $this->parser = new NuLigaParserLeague();
        $this->updater = new NuLigaUpdateLeague();
        $this->lastUpdateDbField = 'last_update_league';
    }
    
    protected function getUrl($team)
    {
        return $team->urlLeague;
    }
    
    protected function getLastUpdate($team)
    {
        return $team->last_update_league;
    }
}
