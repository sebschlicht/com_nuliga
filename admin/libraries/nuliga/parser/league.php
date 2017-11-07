<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 07.11.17
 * Time: 10:21
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

require_once('simple_html_dom.php');

/**
 * HTML parser for team league NuLiga pages.
 *
 * @since 0.0.16
 */
class NuLigaParserLeague
{
    /**
     * Extracts the league teams from a team league NuLiga page.
     *
     * @param $html content of a NuLiga page, displaying a team's league
     * @return array|null list of teams in the league displayed on the page or null on error
     */
    public function parseHtml($html)
    {
        // load DOM tree
        $dom = str_get_html($html);

        // load teams from DOM tree
        $leagueTable = $dom->find('table.result-set', 0);
        if ($leagueTable)
        {
            $teams = array();
            $isHeader = true;
            foreach ($leagueTable->children() as $tr)
            {
                // skip header row
                if ($isHeader)
                {
                    $isHeader = false;
                    continue;
                }

                // process league table row
                $team = self::fromTableRow($tr);
                array_push($teams, $team);
            }
            return $teams;
        }
        else
        {
            // error: parsing failed
            return null;
        }
    }

    /**
     * Loads a league team object from a table row.
     *
     * @param $tr object table row
     * @return array league team object as array
     */
    protected static function fromTableRow($tr)
    {
        // build column mapping
        $model = array(
            'rank' => 1,
            'name' => 2,
            'matches' => 3,
            'wins' => 4,
            'evens' => 5,
            'losses' => 6,
            'goals' => 7,
            'goaldiff' => 8,
            'points' => 9
        );

        // load columns of table row
        foreach ($model as $key => $value)
        {
            $model[$key] = self::getTableRowText($tr, $value);
        }

        return $model;
    }

    /**
     * Retrieves the text of a table cell.
     *
     * @param $tr object table row
     * @param $column int number of the column within the row
     * @return string plain text of the specified cell
     */
    protected static function getTableRowText($tr, $column)
    {
        return $tr->children($column)->plaintext;
    }
}
