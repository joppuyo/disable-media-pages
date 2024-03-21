<?php

namespace NPX\DisableMediaPages\Modules;

use NPX\DisableMediaPages\Plugin;

class Restore
{
    private static $instance = null;

    public static function get_instance(): Restore
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function get_attachments_to_restore()
    {
        global $wpdb;

        $result = $wpdb->get_col(
            "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND post_name RLIKE '^[a-f0-9]{8}-?[a-f0-9]{4}-?4[a-f0-9]{3}-?[89ab][a-f0-9]{3}-?[a-f0-9]{12}$' ORDER BY post_date ASC;"
        );

        return $result;
    }

    public function restore_attachment($attachment_id)
    {

        $plugin = Plugin::get_instance();

        $attachment = get_post($attachment_id);
        $slug = $attachment->post_name;

        $is_uuid = Plugin::is_uuid($slug);

        if ($is_uuid) {
            $new_slug = sanitize_title($attachment->post_title);

            // Remove our filter so we get a real slug instead of UUID
            remove_filter('wp_unique_post_slug', [$plugin, 'unique_slug'], 10);

            $new_attachment = [
                'ID' => $attachment->ID,
                'post_name' => $new_slug,
            ];
            wp_update_post($new_attachment);
        }

    }
}