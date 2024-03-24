<?php

namespace NPX\DisableMediaPages\Modules;

use NPX\DisableMediaPages\Plugin;

class Mangle
{
    private static $instance = null;

    public static function get_instance(): Mangle
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function get_attachments_to_mangle()
    {
        global $wpdb;

        $result = $wpdb->get_col(
            "SELECT ID FROM  $wpdb->posts WHERE post_type = 'attachment' AND post_name NOT RLIKE '^[a-f0-9]{8}-?[a-f0-9]{4}-?4[a-f0-9]{3}-?[89ab][a-f0-9]{3}-?[a-f0-9]{12}$'"
        );

        return $result;
    }

    public function mangle_attachment($attachment_id)
    {
        $plugin = Plugin::get_instance();
        $attachment = get_post($attachment_id);
        $slug = $attachment->post_name;

        $is_uuid = Plugin::is_uuid($slug);

        if (!$is_uuid) {
            $new_attachment = [
                'ID' => $attachment->ID,
                'post_name' => $plugin->generate_uuid_v4(),
            ];

            wp_update_post($new_attachment);
        }

    }
}