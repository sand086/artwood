<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

class MessageHelper
{
    public static function flash($type, $message)
    {
        Session::flash('message', [
            'type' => $type,
            'message' => $message,
        ]);
    }

    public static function success($message)
    {
        self::flash('success', $message);
    }

    public static function error($message)
    {
        self::flash('error', $message);
    }

    public static function warning($message)
    {
        self::flash('warning', $message);
    }

    public static function info($message)
    {
        self::flash('info', $message);
    }

    public static function confirm($message)
    {
        self::flash('confirm', $message);
    }

    public static function getMessage()
    {
        return Session::get('message');
    }
}