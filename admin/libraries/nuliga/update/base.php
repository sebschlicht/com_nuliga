<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 06.01.18
 * Time: 13:11
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Basic class for NuLiga team updaters.
 *
 * @since 0.0.40
 */
abstract class NuLigaUpdateBase
{
    /**
     * @var string name of the underlying database table
     */
    protected $dbTableName;
    
    /**
     * @var string name of the database column for the parental team
     */
    protected $dbColumnTeam = 'teamid';
    
    /**
     * @var array names of the underlying table's columns
     */
    protected $dbColumns;
    
    /**
     * Handles database errors on the removal of previous items.
     *
     * @param $errorMessage string database error message
     * @param $teamId int NuLiga team id
     */
    abstract protected function onClearFailed($errorMessage, $teamId);
    
    /**
     * Handles database errors on the insertion of items.
     *
     * @param $errorMessage string database error message
     * @param $teamId int NuLiga team id
     */
    abstract protected function onInsertionFailed($errorMessage, $teamId);
    
    /**
     * Validates a single item before its insertion into the database.
     *
     * @param $item object item to be validated
     * @return bool true if the model is valid and should be inserted, false otherwise
     */
    abstract protected function validate($item);
    
    /**
     * Stores new items in the database while removing previous items beforehand.
     *
     * @param $teamId int NuLiga team id
     * @param $items array new items to be inserted
     * @return bool true if the database update was successful, otherwise false
     */
    public function update($teamId, $items)
    {
        // add NuLiga team id
        $numItems = count($items);
        for ($i = 0; $i < $numItems; $i++)
        {
            $items[$i][$this->dbColumnTeam] = $teamId;
        }
        
        $db = JFactory::getDbo();
        
        // re-insert items
        if ($this->removeItems($db, $teamId))
        {
            foreach ($items as $item)
            {
                // verify item
                if (!$this->validate($item))
                {
                    continue;
                }
                
                // build SQL statement for the item
                $values = $this->getValues($db, $match);
                
                // insert item
                $query = $db->getQuery(true);
                $query->insert($db->quoteName($this->dbTableName))
                    ->columns($db->quoteName($this->dbColumns))
                    ->values($values);

                $db->setQuery($query);
                if (!$db->execute())
                {
                    // error: insertion failed
                    $this->onInsertionFailed($db->getErrorMsg(), $teamId);
                    return false;
                }
            }
            return true;
        }
        else
        {
            // error: removal failed
            $this->onClearFailed($db->getErrorMsg(), $teamId);
            return false;
        }
    }
    
    /**
     * Removes all items currently stored in the database for a NuLiga team.
     *
     * @param $db JDatabaseDriver dbo to be used
     * @param $teamId int NuLiga team id
     * @return bool true if the operation was successful, otherwise false
     */
    protected function removeItems($db, $teamId)
    {
        $query = $db->getQuery(true);

        $query->delete($this->dbTableName)
            ->where($db->quoteName($this->dbColumnTeam) . ' = ' . $db->quote((int) $teamId));

        $db->setQuery($query);
        return $db->execute();
    }
    
    /**
     * Converts an array of values to a string which can be passed to the SQL values method.
     *
     * @param $db object dbo
     * @param $array array column values
     * @return string imploded and quoted array values
     */
    protected function getValues($db, $array)
    {
        $values = array();
        foreach ($this->dbColumns as $column)
        {
            array_push($values, $db->quote($array[$column]));
        }
        return implode(',', $values);
    }
}