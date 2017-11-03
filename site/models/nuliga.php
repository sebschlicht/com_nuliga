<?php
/**
 * Created by PhpStorm.
 * User: sebschlicht
 * Date: 03.11.17
 * Time: 14:35
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * NuLiga Model
 *
 * @since  0.0.4
 */
class NuLigaModelNuLiga extends JModelItem
{
    /**
     * @var string message
     */
    protected $message;

    /**
     * Get the message
     *
     * @return  string  The message to be displayed to the user
     */
    public function getMsg()
    {
        if (!isset($this->message))
        {
            $jinput = JFactory::getApplication()->input;
            $id     = $jinput->get('id', 1, 'INT');

            switch ($id)
            {
                case 2:
                    $this->message = 'Good bye World!';
                    break;
                default:
                case 1:
                    $this->message = 'Hello World!';
                    break;
            }
        }

        return $this->message;
    }
}
