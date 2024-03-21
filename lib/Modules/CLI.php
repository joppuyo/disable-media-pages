<?php

namespace NPX\DisableMediaPages\Modules;

class CLI
{
    private static $instance = null;

    public static function get_instance(): CLI
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __construct()
    {
        add_filter('cli_init', [$this, 'cli_init']);
    }

    public function cli_init()
    {
        \WP_CLI::add_command('disable-media-pages mangle', [$this, 'mangle']);
        \WP_CLI::add_command('disable-media-pages restore', [$this, 'restore']);
    }

    public function mangle()
    {
        \WP_CLI::success('Mangling media slugs');
    }

    public function restore()
    {
        \WP_CLI::success('Restoring media slugs');
    }

}