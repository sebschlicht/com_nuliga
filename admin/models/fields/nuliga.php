<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 03.11.17
 * Time: 15:01
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

/**
 * NuLiga table form field for the NuLiga component.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_nuliga
 * @since  0.0.6
 */
class JFormFieldNuLiga extends JFormFieldList
{
    /**
     * field type
     *
     * @var         string
     */
    protected $type = 'NuLiga';

    /**
     * Method to get a list of options for a list input.
     *
     * @return  array  JHtml options array
     */
    protected function getOptions()
    {
        // initialize variables
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);

        // select all NuLiga tables
        $query->select('id,greeting')
            ->from('#__nuliga');

        // execute query and build select box
        $db->setQuery((string) $query);
        $messages = $db->loadObjectList();
        $options  = array();

        if ($messages)
        {
            foreach ($messages as $message)
            {
                $options[] = JHtml::_('select.option', $message->id, $message->greeting);
            }
        }

        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }
}
