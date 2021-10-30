<?php

class Noty
{
    public static function success($message, array $options = [])
    {
        return static::notify($message, 'success', $options);
    }


    public static function error($message, array $options = [])
    {
        return static::notify($message, 'error', $options);
    }


    public static function notify($message, $type, array $options = [])
    {
        if (! in_array($type, ['success', 'error'])) {
            throw new \InvalidArgumentException(sprintf(
                "Only 'success' and 'error' are supported for notification type. Got %s",
                $type
            ));
        }

        $messages = Session::get('noty.messages', []);
        $options = array_merge(Config::get('noty::noty'), $options);
        $message = is_null($message) ? 'Null' : $message;

        $messages[] = [
            'message' => $message,
            'type' => $type,
            'options' => $options,
        ];

        Session::flash('noty.messages', $messages);
    }
}
