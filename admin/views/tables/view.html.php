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
 * NuLiga table list view.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_nuliga
 * @since  0.0.7
 */
class NuLigaViewTables extends JViewLegacy
{
    /**
     * Displays the NuLiga table list view.
     *
     * @param   string  $tpl  template file name to parse; automatically searches through template paths
     *
     * @return  void
     */
    function display($tpl = null)
    {
        // get application
        $app = JFactory::getApplication();
        $context = "nuliga.list.admin.table";

        // get model data
        $this->items		= $this->get('Items');
        $this->pagination	= $this->get('Pagination');
        $this->state			= $this->get('State');
        $this->filter_order 	= $app->getUserStateFromRequest($context.'filter_order', 'filter_order', 'title', 'cmd');
        $this->filter_order_Dir = $app->getUserStateFromRequest($context.'filter_order_Dir', 'filter_order_Dir', 'asc', 'cmd');
        $this->filterForm    	= $this->get('FilterForm');
        $this->activeFilters 	= $this->get('ActiveFilters');

        // check for errors
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode('<br />', $errors));

            return false;
        }

        // add toolbar
        $this->addToolBar();

        // display template
        parent::display($tpl);
    }

    /**
     * Adds the toolbar with title and actions.
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function addToolBar()
    {
        JToolbarHelper::title(JText::_('COM_NULIGA_MANAGER_TABLES'), 'table');
        JToolbarHelper::addNew('table.add');
        JToolbarHelper::editList('table.edit');
        JToolbarHelper::deleteList('', 'tables.delete');
    }
}
