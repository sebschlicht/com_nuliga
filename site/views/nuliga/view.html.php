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
        $this->team = $nuLigaTable->title;
        $this->teams = $this->get('Teams');

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
}
