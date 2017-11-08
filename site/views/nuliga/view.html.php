<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 03.11.17
 * Time: 14:17
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * NuLiga table view.
 *
 * @package     Joomla.Site
 * @subpackage  com_nuliga
 * @since  0.0.2
 */
class NuLigaViewNuLiga extends JViewLegacy
{
    /**
     * @var string team title
     */
    protected $team;

    /**
     * @var int NuLiga table type
     */
    protected $type;

    /**
     * @var array team names to be highlighted
     */
    protected $highlight;

    /**
     * @var array league teams (NuLiga league tables only)
     */
    protected $teams;

    /**
     * @var array team matches (NuLiga match list tables only)
     */
    protected $matches;

    /**
     * Displays the NuLiga table view.
     *
     * @param   string  $tpl  template file name to parse; automatically searches through template paths
     *
     * @return  void
     */
    function display($tpl = null)
    {
        // assign view data
        $nuLigaTable = $this->get('NuLigaTable');
        $this->type = $this->get('NuLigaTableType');
        $this->team = $nuLigaTable->title;
        $this->highlight = array('TS Bendorf', 'TS Bendorf II', 'TS Bendorf III');

        if ($this->type == 1)
        {
            $this->teams = $this->get('Teams');
        }
        else
        {
            $this->matches = $this->get('Matches');
        }

        // check for errors
        if (count($errors = $this->get('Errors')))
        {
            JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
            return false;
        }

        // add style sheet
        JHtml::stylesheet('com_nuliga/nuliga.css', false, true, false);

        // display template
        parent::display($tpl);
    }

    function formatDate($date)
    {
        $dateTime = date_create($date);
        return $dateTime ? $dateTime->format('d.m.Y') : $date;
    }

    function formatTime($time)
    {
        $dateTime = DateTime::createFromFormat('H:i:s', $time);
        return $dateTime ? $dateTime->format('H:i') : $time;
    }
}
