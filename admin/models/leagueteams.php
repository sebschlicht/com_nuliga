<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 07.01.18
 * Time: 13:40
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Backend model for the NuLiga league team list.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_nuliga
 * @since  0.0.42
 */
class NuLigaModelLeagueteams extends JModelList
{
    /**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     *
     * @see     JController
     * @since   1.6
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                'teamid',
                'rank',
                'name'
            );
        }

        parent::__construct($config);
    }

    /**
     * Method to build an SQL query to load the list data.
     *
     * @return      string  SQL query
     */
    protected function getListQuery()
    {
        // initialize variables
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);

        // select all NuLiga league teams
        $query->select('*')
            ->from($db->quoteName('#__nuliga_leagueteams'));

        // filter: like / search
        $search = $this->getState('filter.search');
        if (!empty($search))
        {
            $like = $db->quote('%' . $search . '%');
            $query->where('name LIKE ' . $like);
        }
        
        // filter: NuLiga team
        $teamId = $this->getState('filter.team_id');
        if (is_numeric($teamId))
        {
            $query->where('teamid = ' . (int) $teamId);
        }

        // order
        $orderCol	= $this->state->get('list.ordering', 'rank');
        $orderDirn 	= $this->state->get('list.direction', 'asc');
        $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

        return $query;
    }
}
