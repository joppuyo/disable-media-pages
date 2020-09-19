<?php

/*
 * Plugin name: Disable Media Pages
 */

class DisableMediaPages {
    public function __construct() {
        add_filter('wp_unique_post_slug', [$this, 'unique_slug'], 10, 6);
        add_filter('template_redirect', [$this, 'set_404']);
        add_filter('redirect_canonical', [$this, 'set_404'], 0);
        add_filter('attachment_link', [$this, 'change_attachment_link'], 10, 2);
        add_filter('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
        // Add settings link on the plugin page
        add_filter(
            'plugin_action_links_' . plugin_basename(__FILE__), [$this, 'plugin_action_links']
        );

        // Add plugin to WordPress admin menu
        add_action('admin_menu', [$this, 'admin_menu']);

    }

    function set_404()
    {
        if (is_attachment()) {
            global $wp_query;
            $wp_query->set_404();
            status_header(404);
        }
    }

    function change_attachment_link($url, $id)
    {
        $attachment_url = wp_get_attachment_url($id);
        if ($attachment_url) {
            return $attachment_url;
        }
        return $url;
    }

    function unique_slug($slug, $post_ID, $post_status, $post_type, $post_parent, $original_slug) {
        if ($post_type === 'attachment') {
            return str_replace('-', '', wp_generate_uuid4());
        }
        return $slug;
    }

    function admin_enqueue_scripts()
    {
        $plugin_data = get_plugin_data(__FILE__);
        $version = $plugin_data['Version'];
        $url = plugin_dir_url(__FILE__);
        $path = plugin_dir_path(__FILE__);

        wp_enqueue_script(
            'csf-script',
            "{$url}dist/script.js",
            [],
            WP_DEBUG ? md5_file($path . 'dist/script.js') : $version
        );

        wp_enqueue_style(
            'csf-style',
            "{$url}dist/style.css",
            [],
            WP_DEBUG ? md5_file($path . 'dist/style.css') : $version
        );
    }

    public function plugin_action_links($links) {
        $settings_link =
            '<a href="options-general.php?page=disable-media-pages">' .
            __('Settings', 'disable-media-pages') .
            '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    public function admin_menu() {
        add_submenu_page(
            null,
            __(
                'Disable Media Pages',
                'disable-media-pages'
            ),
            __(
                'Disable Media Pages',
                'disable-media-pages'
            ),
            'manage_options',
            'disable-media-pages',
            [$this, 'settings_page']
        );
    }

    public function settings_page() {
        echo '<div id="disable-media-pages"><disable-media-pages></disable-media-pages></div>';
    }
}

$disable_media_pages = new DisableMediaPages();