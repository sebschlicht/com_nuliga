<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 03.11.17
 * Time: 18:10
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Backend model for the NuLiga table list.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_nuliga
 * @since  0.0.7
 */
class NuLigaModelNuLigas extends JModelList
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
                'greeting',
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

        // select all NuLiga tables
        $query->select('*')
            ->from($db->quoteName('#__nuliga'));

        // filter: like / search
        $search = $this->getState('filter.search');
        if (!empty($search))
        {
            $like = $db->quote('%' . $search . '%');
            $query->where('greeting LIKE ' . $like);
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
        $orderCol	= $this->state->get('list.ordering', 'greeting');
        $orderDirn 	= $this->state->get('list.direction', 'asc');
        $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

        return $query;
    }
}
