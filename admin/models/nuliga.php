<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 04.11.17
 * Time: 00:02
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Backend model for single NuLiga tables.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_nuliga
 * @since  0.0.9
 */
class NuLigaModelNuLiga extends JModelAdmin
{
    /**
     * Method to get a table object, load it if necessary.
     *
     * @param   string  $type    [table name]
     * @param   string  $prefix  [class prefix]
     * @param   array   $config  [configuration array]
     *
     * @return  JTable  table object
     *
     * @since   1.6
     */
    public function getTable($type = 'NuLiga', $prefix = 'NuLigaTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param   array    $data      form data
     * @param   boolean  $loadData  true if the form is to load its own data (default case), false if not
     *
     * @return  mixed    JForm object on success, false on failure
     *
     * @since   1.6
     */
    public function getForm($data = array(), $loadData = true)
    {
        // load form
        $form = $this->loadForm(
            'com_nuliga.nuliga',
            'nuliga',
            array(
                'control' => 'jform',
                'load_data' => $loadData
            )
        );

        return (empty($form) ? false : $form);
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return  mixed  form data
     *
     * @since   1.6
     */
    protected function loadFormData()
    {
        // check session for previously entered form data
        $data = JFactory::getApplication()->getUserState(
            'com_nuliga.edit.nuliga.data',
            array()
        );

        // insert item as form data if empty
        if (empty($data))
        {
            $data = $this->getItem();
        }

        return $data;
    }
}
