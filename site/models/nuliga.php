<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 03.11.17
 * Time: 14:35
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Model for NuLiga single tables.
 *
 * @package     Joomla.Site
 * @subpackage  com_nuliga
 * @since  0.0.4
 */
class NuLigaModelNuLiga extends JModelItem
{
    /**
     * @var array messages
     */
    protected $messages;

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
     * Get the message of a greeting.
     *
     * @param   integer  $id  greeting id
     *
     * @return  string        greeting message
     */
    public function getMsg($id = 1)
    {
        if (!is_array($this->messages))
        {
            $this->messages = array();
        }

        if (!isset($this->messages[$id]))
        {
            // get requested id
            $jinput = JFactory::getApplication()->input;
            $id     = $jinput->get('id', 1, 'INT');

            // get a TableNuLiga instance
            $table = $this->getTable();

            // load NuLiga table
            $table->load($id);

            // store greeting message
            $this->messages[$id] = $table->greeting;
        }

        return $this->messages[$id];
    }
}
