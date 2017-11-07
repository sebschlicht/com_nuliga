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
        // TODO
        $this->updater = null;
    }
}
