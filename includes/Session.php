<?php

namespace app\includes;

class Session
{
    protected const FLASH_KEY = 'flash_messages';

    /**
     * Constructor will be called whenever request is made
     */
    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            //  Mark to be removed at the end of request, so it will not be available for the next request
            $flashMessage['remove'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    /**
     * Set new flash message
     */
    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'removed' => false,
            'value' => $message
        ];
    }

    /**
     * Return flash value
     */
    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    /**
     * Unset flash session
     */
    public function __destruct()
    {
        //  Iterate over marked to be removed
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            //  Mark to be removed at the end of request, so it will not be available for the next request
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);    // set to false
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}