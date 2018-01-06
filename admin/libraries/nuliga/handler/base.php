<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 07.11.17
 * Time: 14:03
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Basic class for NuLiga table handlers.
 *
 * @since 0.0.16
 */
abstract class NuLigaHandlerBase
{
    /**
     * default update interval
     */
    const DEFAULT_UPDATE_INTERVAL = 'PT15M';

    /**
     * name of the table for NuLiga teams
     */
    const DB_TABLE_NAME_TEAMS = '#__nuliga_teams';

    /**
     * @var array registered NuLiga table handlers
     */
    protected static $handlers = array();

    /**
     * @var DateInterval interval between consecutive table updates
     */
    protected $updateInterval;

    /**
     * @var object league HTML parser
     */
    protected $parser;

    /**
     * @var object DB synchronizer
     */
    protected $updater;
    
    /**
     * @var string name of the database column holding the last update timestamp
     */
    protected $lastUpdateDbField;
    
    /**
     * @var string name of the database column holding the URL
     */
    protected $urlField;

    /**
     * Basic constructor of a NuLiga table handler.
     *
     * @param updateInterval DateInterval between consecutive table updates
     */
    function __construct($updateInterval = null)
    {
        $this->updateInterval = $updateInterval != null ? $updateInterval
            : new DateInterval(self::DEFAULT_UPDATE_INTERVAL);
    }

    /**
     * Performs an update for a NuLiga team.
     *
     * @param $table JTable NuLiga team
     * @return bool true if the update has been successful
     */
    public function update($team)
    {
        $url = $team[$this->urlField];
        $html = self::getRemoteContent($url);
        if ($html)
        {
            $model = $this->parser->parseHtml($html);
            if ($model)
            {
                // sync DB via updater
                if ($this->updater->update($team->id, $model))
                {
                    // update last_update timestamp
                    $db = JFactory::getDbo();
                    $query = $db->getQuery(true);

                    $now = new DateTime();
                    $query->update(self::DB_TABLE_NAME_TEAMS)
                        ->set($db->quoteName($this->lastUpdateDbField) . ' = ' . $db->quote($now->format('Y-m-d H:i:s')))
                        ->where($db->quoteName('id') . ' = ' . $db->quote($team->id));

                    $db->setQuery($query);
                    if ($db->execute())
                    {
                        // update was successful
                        return true;
                    }
                    else
                    {
                        // error: db update failed
                        JLog::add("Failed to mark NuLiga team #$team->id as up-to-date!", JLog::WARNING, 'jerror');
                        JLog::add($db->getErrorMsg(), JLog::WARNING, 'jerror');
                        return false;
                    }
                }
                else
                {
                    // error: db update failed
                    return false;
                }
            }
            else
            {
                // error: parsing failed
                JLog::add("Failed to parse HTML of NuLiga team #$team->id from URL '$table->url'!", JLog::WARNING,
                    'jerror');
                return false;
            }
        }
        else
        {
            // error: download failed
            JLog::add("Failed to download HTML of NuLiga team #$team->id from URL '$table->url'!", JLog::WARNING,
                'jerror');
            return false;
        }
    }

    /**
     * Checks whether a team's last update is longer ago than the configured update interval.
     *
     * @param $team JTable team with the respective timestamp column
     * @return bool true if an update is required, false if not or not possible due to lacking URL
     */
    public function isUpdateRequired($team)
    {
        if (empty($team[$this->urlField]))
        {
            return false;
        }
        
        $now = new DateTime('now');
        $lastUpdate = empty($team[$this->lastUpdateDbField]) ? null : new DateTime($team[$this->lastUpdateDbField]);
        return ($lastUpdate === null || $now->sub($this->updateInterval) > $lastUpdate);
    }

    /**
     * Retrieves the content of a remote page.
     *
     * @param $url string page URL
     * @return bool|string paqe content or false on error
     */
    protected static function getRemoteContent($url)
    {
        if (function_exists('curl_version'))
        {
            // use (faster) curl if available
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
        else
        {
            // fallback to native method if curl not available
            return file_get_contents($url);
        }
    }

    /**
     * Registers a handler.
     *
     * @param $viewId int id of the NuLiga team view which the handler is responsible for
     * @param $handler NuLigaHandlerBase handler instance
     */
    public static function registerHandler($viewId, $handler)
    {
        self::$handlers[$viewId] = $handler;
    }

    /**
     * Gets the handler which is responsible for a certain NuLiga team view.
     *
     * @param $viewId int NuLiga team view id
     * @return NuLigaHandlerBase|null handler instance or null if view id is unknown
     */
    public static function getHandler($viewId)
    {
        return array_key_exists($viewId, self::$handlers) ? self::$handlers[$viewId] : null;
    }

    /**
     * Initializes the basic handler to make the handler detection mechanism work.
     * TODO find php-like solution
     */
    public static function init()
    {
        if (empty(self::$handlers))
        {
            self::registerHandler(1, new NuLigaHandlerLeague());
            self::registerHandler(2, new NuLigaHandlerMatches());
        }
    }
}