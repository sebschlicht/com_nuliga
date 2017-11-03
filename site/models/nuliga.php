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
            $this->message = 'Hello World!';
        }

        return $this->message;
    }
}
