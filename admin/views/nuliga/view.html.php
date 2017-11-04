<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 03.11.17
 * Time: 23:53
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * NuLiga View
 *
 * @since  0.0.9
 */
class NuLigaViewNuLiga extends JViewLegacy
{
    /**
     * View form
     *
     * @var         form
     */
    protected $form = null;

    /**
     * Display the NuLiga view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    public function display($tpl = null)
    {
        // Get the Data
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');

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
        $input = JFactory::getApplication()->input;

        // Hide Joomla Administrator Main menu
        $input->set('hidemainmenu', true);

        $isNew = ($this->item->id == 0);

        if ($isNew)
        {
            $title = JText::_('COM_NULIGA_MANAGER_NULIGA_NEW');
        }
        else
        {
            $title = JText::_('COM_NULIGA_MANAGER_NULIGA_EDIT');
        }

        JToolbarHelper::title($title, 'nuliga');
        JToolbarHelper::save('nuliga.save');
        JToolbarHelper::cancel(
            'nuliga.cancel',
            $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE'
        );
    }
}
