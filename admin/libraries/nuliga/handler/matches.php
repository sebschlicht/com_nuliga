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
 * Handler for NuLiga matches.
 *
 * @since 0.0.19
 */
class NuLigaHandlerMatches extends NuLigaHandlerBase
{
    function __construct()
    {
        parent::__construct();
        $this->parser = new NuLigaParserMatches();
        $this->updater = new NuLigaUpdateMatches();
    }
}
