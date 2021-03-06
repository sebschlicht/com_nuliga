<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 07.01.18
 * Time: 13:47
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * NuLiga league team list view.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_nuliga
 * @since  0.0.42
 */
class NuLigaViewLeagueteams extends JViewLegacy
{
    /**
     * Displays the NuLiga league team list view.
     *
     * @param   string  $tpl  template file name to parse; automatically searches through template paths
     *
     * @return  void
     */
    function display($tpl = null)
    {
        // get application
        $app = JFactory::getApplication();
        $context = "nuliga.list.admin.leagueteam";

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
        JToolbarHelper::title(JText::_('COM_NULIGA_MANAGER_LEAGUETEAMS'), 'leagueteam');
    }
}
