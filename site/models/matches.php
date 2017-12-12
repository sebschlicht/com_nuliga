<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 07.11.17
 * Time: 15:02
 */

class NuLigaModelMatches extends JModelList
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
                'nr',
                'date',
                'home',
                'guest',
                'published'
            );
        }

        parent::__construct($config);
    }

    /**
     * Get the master query for retrieving a list of team matches subject to the model state.
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

        // select all fields of matches
        $query->select('*')
            ->from('#__nuliga_matches AS m');

        // filter: NuLiga table id
        $tableId = $this->getState('filter.table_id');
        if (is_numeric($tableId))
        {
            $query->where('m.tabid = ' . (int) $tableId);
        }

        // filter: published state
        $published = $this->getState('filter.published');
        if (is_numeric($published))
        {
            $query->where('m.published = ' . (int) $published);
        }
        elseif ($published === '')
        {
            $query->where('(m.published IN (0, 1))');
        }

        // ordering
        $orderCol	= $this->state->get('list.ordering', 'm.nr');
        $orderDirn 	= $this->state->get('list.direction', 'asc');
        $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

        return $query;
    }
}