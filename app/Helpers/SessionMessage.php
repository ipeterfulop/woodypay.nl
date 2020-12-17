<?php


namespace App\Helpers;


class SessionMessage
{
    const TYPE_NOTIFICATION = 1;
    const TYPE_POPUP = 2;

    const SEVERITY_SUCCESS = 'message-severity-success';
    const SEVERITY_WARNING = 'message-severity-warning';
    const SEVERITY_ERROR = 'message-severity-error';

    public static function createSuccessMessage($message, $type = self::TYPE_NOTIFICATION)
    {
        session()->put('notificationMessage', ['type' => $type, 'severity' => self::SEVERITY_SUCCESS, 'message' => $message]);
    }

    public static function createWarningMessage($message, $type = self::TYPE_POPUP)
    {
        session()->put('notificationMessage', ['type' => $type, 'severity' => self::SEVERITY_WARNING, 'message' => $message]);
    }

    public static function createErrorMessage($message, $type = self::TYPE_POPUP)
    {
        session()->put('notificationMessage', ['type' => $type, 'severity' => self::SEVERITY_ERROR, 'message' => $message]);
    }
}