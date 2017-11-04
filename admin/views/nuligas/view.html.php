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
class NuLigaViewNuLigas extends JViewLegacy
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

        // Set the toolbar
        $this->addToolBar();

        // Display the template
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function addToolBar()
    {
        JToolbarHelper::title(JText::_('COM_NULIGA_MANAGER_NULIGAS'));
        JToolbarHelper::addNew('nuliga.add');
        JToolbarHelper::editList('nuliga.edit');
        JToolbarHelper::deleteList('', 'nuligas.delete');
    }
}
