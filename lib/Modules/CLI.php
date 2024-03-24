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
        $mangle = Mangle::get_instance();
        \WP_CLI::line('Mangling media slugs...');
        $attachment_ids = $mangle->get_attachments_to_mangle();
        foreach ($attachment_ids as $attachment_id) {
            \WP_CLI::line('Mangling attachment with ID ' . $attachment_id . ' and title ' . get_the_title($attachment_id));
            $mangle->mangle_attachment($attachment_id);
        }
        \WP_CLI::success('Successfully mangled ' . count($attachment_ids) . ' media slugs!');
    }

    public function restore()
    {
        \WP_CLI::line('Restoring media slugs...');
        $restore = Restore::get_instance();
        $attachment_ids = $restore->get_attachments_to_restore();
        foreach ($attachment_ids as $attachment_id) {
            \WP_CLI::line('Restoring attachment with ID ' . $attachment_id . ' and title ' . get_the_title($attachment_id));
            $restore->restore_attachment($attachment_id);
        }
        \WP_CLI::success('Successfully restored ' . count($attachment_ids) . ' media slugs!');
    }

}