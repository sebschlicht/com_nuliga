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
 * HTML parser for NuLiga match list pages.
 *
 * @since 0.0.19
 */
class NuLigaParserMatches
{
    /**
     * Extracts the matches from a NuLiga match list page.
     *
     * @param $html string content of a NuLiga page, displaying a team's match list
     * @return array|null list of matches in the list displayed on the page or null on error
     */
    public function parseHtml($html)
    {
        // load DOM tree
        $dom = str_get_html($html);

        // load teams from DOM tree
        $matchesTable = $dom->find('table.result-set', 1);
        if ($matchesTable)
        {
            $matches = array();
            $isHeader = true;
            foreach ($matchesTable->children() as $tr)
            {
                // skip header row
                if ($isHeader)
                {
                    $isHeader = false;
                    continue;
                }

                // process match table row
                $match = self::fromTableRow($tr);
                array_push($matches, $match);
            }
            return $matches;
        }
        else
        {
            // error: parsing failed
            return null;
        }
    }

    /**
     * Loads a match object from a table row.
     *
     * @param $tr object table row
     * @return array match object as array
     */
    protected static function fromTableRow($tr)
    {
        // build column mapping
        $tableColumns = array(
            'weekday' => 0,
            'date' => 1,
            'time' => 2,
            'hall' => 3,
            'nr' => 4,
            'home' => 5,
            'guest' => 6,
            'goals' => 7,
            'reportUrl' => 8,
            'isPlayed' => 9
        );

        // load columns of table row
        $model = array();
        foreach ($tableColumns as $key => $value)
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
        return trim($tr->children($column)->plaintext);
    }
}
