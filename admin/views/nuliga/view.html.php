<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 03.11.17
 * Time: 18:06
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * NuLiga View
 *
 * @since  0.0.7
 */
class NuLigaViewNuLiga extends JViewLegacy
{
    /**
     * Display the NuLiga view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    function display($tpl = null)
    {
        // Get data from the model
        $this->items		= $this->get('Items');
        $this->pagination	= $this->get('Pagination');

        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode('<br />', $errors));

            return false;
        }

        // Display the template
        parent::display($tpl);
    }
}
