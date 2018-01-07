<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 04.01.18
 * Time: 16:06
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Backend model for the NuLiga team list.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_nuliga
 * @since  0.0.28
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
                'id',
                'title',
                'urlPortrait',
                'league',
                'urlLeague',
                'published'
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

        // select all NuLiga teams
        $query->select('*')
            ->from($db->quoteName('#__nuliga_teams'));

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
            $query->where('published = ' . (int) $published);
        }
        elseif ($published === '')
        {
            $query->where('(published IN (0, 1))');
        }

        // order
        $orderCol	= $this->state->get('list.ordering', 'title');
        $orderDirn 	= $this->state->get('list.direction', 'asc');
        $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

        return $query;
    }
}
