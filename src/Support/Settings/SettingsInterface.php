<?php

declare(strict_types = 1);

namespace App\Support\Settings;

interface SettingsInterface
{
    /**
     * Returns the stored value if it exists in the settings array.
     *
     * @param string $key
     * 
     * @return void
     */
    public function get(string $key, mixed $default = null);
}