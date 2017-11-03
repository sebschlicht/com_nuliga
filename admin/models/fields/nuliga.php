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
 * NuLiga Form Field class for the NuLiga component
 *
 * @since  0.0.6
 */
class JFormFieldNuLiga extends JFormFieldList
{
    /**
     * The field type.
     *
     * @var         string
     */
    protected $type = 'NuLiga';

    /**
     * Method to get a list of options for a list input.
     *
     * @return  array  An array of JHtml options.
     */
    protected function getOptions()
    {
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('id,greeting');
        $query->from('#__nuliga');
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
