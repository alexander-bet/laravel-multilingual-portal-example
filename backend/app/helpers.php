<?php

declare(strict_types=1);

use Modules\Core\Models\Setting;

if (! function_exists('setting')) {
    /**
     * Return a setting value by key, or the entire Setting instance when key is null.
     *
     * Examples:
     *   setting('phones')       // array|null
     *   setting('addresses')    // array|null
     *   setting()               // Setting singleton
     */
    function setting(?string $key = null): mixed
    {
        $instance = Setting::instance();
        return $key === null ? $instance : $instance->{$key};
    }
}
