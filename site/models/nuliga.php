<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 03.11.17
 * Time: 14:35
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// TODO deploy library files to ROOT/libraries
//JLoader::registerPrefix('NuLiga', JPATH_LIBRARIES . '/nuliga');
JLoader::registerPrefix('NuLiga', JPATH_ADMINISTRATOR . '/components/com_nuliga/libraries/nuliga');

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
     * @var JTable NuLiga table
     */
    protected $_table;

    /**
     * @var array NuLiga league table teams
     */
    protected $_teams;

    /**
     * @var array NuLiga team matches
     */
    protected $_matches;

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
     * Retrieves the NuLiga table of the current request.
     *
     * @return JTable NuLiga table object
     */
    public function getNuLigaTable($id = 1)
    {
        // get requested id
        $jinput = JFactory::getApplication()->input;
        $id = $jinput->get('id', 1, 'INT');

        // load NuLiga table
        return $this->loadNuLigaTable($id);
    }

    /**
     * Gets the type of the current NuLiga table, if loaded.
     *
     * @return int|null table type or null if not loaded
     */
    public function getNuLigaTableType()
    {
        return ($this->_table->type !== null) ? $this->_table->type : null;
    }

    /**
     * Loads a NuLiga table from the database. If necessary, the NuLiga table is updated.
     *
     * @param $id int table identifier
     * @return JTable|null NuLiga table loaded or null if not existing
     */
    public function loadNuLigaTable($id)
    {
        // check if table already cached
        if ($this->_table !== null)
        {
            return $this->_table;
        }

        // load NuLiga table
        $this->_table = $this->getTable();
        if (!$this->_table->load($id)) {
            return null;
        }

        // trigger table update procedure
        NuLigaHandlerBase::init();
        $handler = NuLigaHandlerBase::getHandler($this->_table->type);
        if ($handler)
        {
            if ($handler->isUpdateRequired($this->_table))
            {
                echo '<script>console.log("NuLiga update necessary...");</script>';
                if (!$handler->update($this->_table))
                {
                    // error: update failed
                    JFactory::getApplication()->enqueueMessage(JText::_('COM_NULIGA_NULIGA_UPDATE_ERROR'), 'error');
                }
                else
                {
                    echo '<script>console.log("NuLiga update successful.");</script>';
                }
            }
        }
        else
        {
            // error: unknown table type
            JFactory::getApplication()->enqueueMessage(JText::_('COM_NULIGA_INTERNAL_ERROR'), 'error');
        }

        return $this->_table;
    }

    public function getTeams()
    {
        if ($this->_teams === null && $this->_table !== null)
        {
            // use league team model instance to load teams
            $model = JModelLegacy::getInstance('Leagueteams', 'NuLigaModel', array('ignore_request' => true));
            $model->setState('filter.table_id', $this->_table->id);
            $this->_teams = $model->getItems();

            if ($this->_teams === false)
            {
                $this->setError($model->getError());
            }
        }
        return $this->_teams;
    }

    public function getMatches()
    {
        if ($this->_matches === null && $this->_table !== null)
        {
            // use match model instance to load matches
            $model = JModelLegacy::getInstance('Matches', 'NuLigaModel', array('ignore_request' => true));
            $model->setState('filter.table_id', $this->_table->id);
            $this->_matches = $model->getItems();

            if ($this->_matches === false)
            {
                $this->setError($model->getError());
            }
        }
        return $this->_matches;
    }
}
