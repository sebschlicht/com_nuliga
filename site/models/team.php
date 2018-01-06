<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 06.01.18
 * Time: 09:58
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// TODO deploy library files to ROOT/libraries
JLoader::registerPrefix('NuLiga', JPATH_ADMINISTRATOR . '/components/com_nuliga/libraries/nuliga');

/**
 * Model for single NuLiga teams.
 *
 * @package     Joomla.Site
 * @subpackage  com_nuliga
 * @since  0.0.40
 */
class NuLigaModelTeam extends JModelItem
{
    /**
     * @var JTable NuLiga team
     */
    protected $_team;

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
    public function getTable($type = 'Team', $prefix = 'NuLigaTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Loads a NuLiga team from the database. If necessary, the NuLiga team is updated.
     *
     * @param $id int team identifier
     * @return JTable|null NuLiga team loaded or null if not existing
     */
    public function loadNuLigaTeam($id)
    {
        // check if team already cached
        if ($this->_team !== null)
        {
            return $this->_team;
        }

        // load NuLiga team
        $this->_team = $this->getTable();
        if (!$this->_team->load($id)) {
            return null;
        }

        // prepare update handler to trigger updates
        NuLigaHandlerBase::init();

        return $this->_team;
    }
    
    protected function triggerTeamViewUpdate($viewId)
    {
        $handler = NuLigaHandlerBase::getHandler($viewId);
        if ($handler)
        {
            if ($handler->isUpdateRequired($this->_team))
            {
                echo '<script>console.log("NuLiga update necessary...");</script>';
                if (!$handler->update($this->_team))
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
            // error: unknown view id
            JFactory::getApplication()->enqueueMessage(JText::_('COM_NULIGA_INTERNAL_ERROR'), 'error');
        }
    }

    /**
     * Loads the teams of the current team's league.
     * Callers should check if a league URL is available beforehand.
     *
     * @return array|boolean league teams or false if current team not loaded
     */
    public function getLeagueTeams()
    {
        if ($this->_team !== null)
        {
            // update league if necessary
            $this->triggerTeamViewUpdate(1);
            
            // use league team model instance to load teams
            $model = JModelLegacy::getInstance('Leagueteams', 'NuLigaModel', array('ignore_request' => true));
            $model->setState('filter.team_id', $this->_team->id);
            $leagueteams = $model->getItems();

            if ($leagueteams === false)
            {
                $this->setError($model->getError());
            }
            return $leagueteams;
        }
        else
        {
            return false;
        }
    }

    /**
     * Loads the scheduled matches for the current team.
     * Callers should check if a portrait URL is available beforehand.
     *
     * @return array|boolean scheduled matches or false if current team not loaded
     */
    public function getMatches()
    {
        if ($this->_team !== null)
        {
            // update league if necessary
            $this->triggerTeamViewUpdate(2);
            
            // use match model instance to load matches
            $model = JModelLegacy::getInstance('Matches', 'NuLigaModel', array('ignore_request' => true));
            $model->setState('filter.team_id', $this->_team->id);
            $matches = $model->getItems();

            if ($matches === false)
            {
                $this->setError($model->getError());
            }
            return $matches;
        }
        else
        {
            return false;
        }
    }
}
