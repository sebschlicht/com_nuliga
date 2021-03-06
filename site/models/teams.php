<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 05.01.18
 * Time: 13:56
 */

/**
 * Model for NuLiga team lists.
 *
 * @package     Joomla.Site
 * @subpackage  com_nuliga
 * @since  0.0.30
 */
class NuLigaModelTeams extends JModelList
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
                'published'
            );
        }

        parent::__construct($config);
    }

    /**
     * Get the master query for retrieving a list of teams subject to the model state.
     *
     * @return  JDatabaseQuery
     *
     * @since   1.6
     */
    protected function getListQuery()
    {
        // Get the current user for authorisation checks
        $user = JFactory::getUser();

        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // select all fields of teams
        $query->select('*')
            ->from('#__nuliga_teams AS t');
        
        // filter: like / search
        $search = $this->getState('filter.search');
        if (!empty($search))
        {
            $like = $db->quote('%' . $search . '%');
            $query->where('title LIKE ' . $like);
        }

        // filter: published state
        $published = $this->getState('filter.published');
        if (is_numeric($published))
        {
            $query->where('t.published = ' . (int) $published);
        }
        elseif ($published === '')
        {
            $query->where('(t.published IN (0, 1))');
        }

        // ordering
        $orderCol	= $this->state->get('list.ordering', 't.title');
        $orderDirn 	= $this->state->get('list.direction', 'asc');
        $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

        return $query;
    }
}