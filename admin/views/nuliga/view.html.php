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
 * View to edit NuLiga single tables.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_nuliga
 * @since  0.0.9
 */
class NuLigaViewNuLiga extends JViewLegacy
{
    /**
     * form to edit NuLiga tables
     *
     * @var         form
     */
    protected $form = null;

    /**
     * Displays the NuLiga view.
     *
     * @param   string  $tpl  template file name to parse; automatically searches through template paths
     *
     * @return  void
     */
    public function display($tpl = null)
    {
        // get data
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');

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

        // prepare document
        $this->setDocument();
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
        $input = JFactory::getApplication()->input;

        // hide main Joomla administration menu
        $input->set('hidemainmenu', true);

        // set title depending on item action
        $isNew = ($this->item->id == 0);
        $title = JText::_($isNew ? 'COM_NULIGA_MANAGER_NULIGA_NEW' : 'COM_NULIGA_MANAGER_NULIGA_EDIT');

        // add tool bar components
        JToolbarHelper::title($title, 'nuliga');
        JToolbarHelper::save('nuliga.save');
        JToolbarHelper::cancel(
            'nuliga.cancel',
            $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE'
        );
    }

    /**
     * Method to set up the document properties.
     *
     * @return void
     */
    protected function setDocument()
    {
        $isNew = ($this->item->id < 1);
        $document = JFactory::getDocument();
        $document->setTitle(JText::_($isNew ? 'COM_NULIGA_NULIGA_CREATING' : 'COM_NULIGA_NULIGA_EDITING'));
    }
}
