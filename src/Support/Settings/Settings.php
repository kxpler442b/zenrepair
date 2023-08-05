<?php

declare(strict_types = 1);

namespace App\Support\Settings;

class Settings implements SettingsInterface
{
    private readonly array $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Undocumented function
     *
     * @param string $key
     * 
     * @return void
     */
    public function get(string $key, mixed $default = null)
    {
        $path = explode('.', $key);
        $value = $this->settings[array_shift($path)] ?? null;

        if($value == null) {
            return $default;
        }

        foreach($path as $key) {
            if(!isset($value[$key])) {
                return $default;
            } else {
                $value = $value[$key];
            }
        }

        return $value;
    }
}