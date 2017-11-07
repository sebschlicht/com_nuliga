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
    const DEFAULT_UPDATE_INTERVAL = 'PT30M';

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
     * Performs an update for a NuLiga table.
     *
     * @param $table JTable NuLiga table
     * @return bool true if the update has been successful
     */
    public function update($table)
    {
        $html = self::getRemoteContent($table->url);
        if ($html)
        {
            $model = $this->parser->parseHtml($html);
            if ($model)
            {
                // TODO sync DB via updater
                return true;
            }
            else
            {
                // TODO error: parsing failed
                return false;
            }
        }
        else
        {
            // TODO error: download failed
            return false;
        }
    }

    /**
     * Checks whether a table's last update is longer ago than the configured update interval.
     *
     * @param $table JTable table with a `last_update` column
     * @return bool true if an update is required
     */
    public function isUpdateRequired($table)
    {
        $now = new DateTime('now');
        $tableDate = empty($table->last_update) ? null : new DateTime($table->last_update);
        return ($tableDate === null || $now->sub($this->updateInterval) > $tableDate);
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
     * @param $tableType int NuLiga table type the handler handles
     * @param $handler NuLigaHandlerBase handler instance
     */
    public static function registerHandler($tableType, $handler)
    {
        self::$handlers[$tableType] = $handler;
    }

    /**
     * Gets the handler which is responsible for a certain NuLiga table type.
     *
     * @param $tableType int NuLiga table type
     * @return NuLigaHandlerBase|null handler instance or null if table type unknown
     */
    public static function getHandler($tableType)
    {
        return array_key_exists($tableType, self::$handlers) ? self::$handlers[$tableType] : null;
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
        }
    }
}