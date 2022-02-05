<?php

namespace NPX\DisableMediaPages\Modules;

class Admin
{
    private static $instance = null;
    /**
     * @var string
     */
    private $plugin_file;

    public static function get_instance(): Admin
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __construct()
    {
        $this->plugin_file = realpath(__DIR__ . '/../../disable-media-pages.php');
        add_filter('init', [$this, 'init']);
    }

    public function init()
    {
        add_filter('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
        add_filter(
            'plugin_action_links_' . plugin_basename($this->plugin_file),
            [$this, 'plugin_action_links']
        );
        add_filter('plugin_row_meta', [$this, 'donate_link'], 10, 2);
        add_action('admin_menu', [$this, 'admin_menu']);
    }

    public function admin_menu()
    {
        add_submenu_page(
            'options-general.php',
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

    public function settings_page()
    {
        echo '<div id="disable-media-pages"><disable-media-pages></disable-media-pages></div>';
    }

    function admin_enqueue_scripts()
    {
        $plugin_data = get_plugin_data($this->plugin_file);
        $version = $plugin_data['Version'];
        $url = plugin_dir_url($this->plugin_file);
        $path = plugin_dir_path($this->plugin_file);

        $current_screen = get_current_screen();

        if (empty($current_screen)) {
            return;
        }

        if ($current_screen->id !== 'settings_page_disable-media-pages') {
            return;
        }

        wp_enqueue_script(
            'dmp-script',
            "{$url}dist/script.js",
            [],
            WP_DEBUG ? md5_file($path . 'dist/script.js') : $version
        );

        wp_localize_script(
            'dmp-script',
            'disable_media_pages',
            [
                'root' => rest_url(),
                'token' => wp_create_nonce('wp_rest'),
                'i18n' => [
                    'plugin_title' => __('Disable Media Pages', 'disable-media-pages'),
                    'tab_status' => __('Plugin status', 'disable-media-pages'),
                    'tab_mangle' => __('Mangle existing slugs', 'disable-media-pages'),
                    'tab_restore' => __('Restore media slugs', 'disable-media-pages'),
                    'mangle_title' => __('Mangle existing slugs', 'disable-media-pages'),
                    'mangle_subtitle' => __(
                        'Existing media slug mangling tool',
                        'disable-media-pages'
                    ),
                    'mangle_description' => __(
                        "This tool will let you change all existing post slugs to unique ids so they won't conflict with your page titles",
                        'disable-media-pages'
                    ),
                    'mangle_button' => __('Start mangling process', 'disable-media-pages'),
                    'mangle_progress_title' => __(
                        'Mangling existing media slugs...',
                        'disable-media-pages'
                    ),
                    'mangle_progress_description' => __('Progress %d%%', 'disable-media-pages'),
                    'mangle_success_title' => __('All media slugs mangled', 'disable-media-pages'),
                    'mangle_success_button' => __('Start over', 'disable-media-pages'),
                    'restore_title' => __('Restore media slugs', 'disable-media-pages'),
                    'restore_subtitle' => __('Media slug restoration tool', 'disable-media-pages'),
                    'restore_description' => __(
                        "This tool allows you to restore media slugs from UUID4 format to a slug based on the post title.",
                        'disable-media-pages'
                    ),
                    'restore_button' => __('Start restoring process', 'disable-media-pages'),
                    'restore_progress_title' => __(
                        'Restoring media slugs...',
                        'disable-media-pages'
                    ),
                    'restore_progress_description' => __('Progress %d%%', 'disable-media-pages'),
                    'restore_success_title' => __(
                        'All media slugs restored',
                        'disable-media-pages'
                    ),
                    'restore_success_button' => __('Start over', 'disable-media-pages'),
                    'tool_progress_subtitle' => __(
                        'Processed %s out of %s attachments',
                        'disable-media-pages'
                    ),
                    'status_title' => __('Plugin status', 'disable-media-pages'),
                    'status_loading_title' => __('Loading status', 'disable-media-pages'),
                    'status_loading_description' => __(
                        'Please wait while we fetch the plugin status…',
                        'disable-media-pages'
                    ),
                    'status_some_issues_title' => __("Some issues found", 'disable-media-pages'),
                    'status_non_unique_count_singular' => __(
                        'There is %d attachment with a non-unique slug.',
                        'disable-media-pages'
                    ),
                    'status_non_unique_count_plural' => __(
                        'There are %d attachments with non-unique slugs.',
                        'disable-media-pages'
                    ),
                    'status_non_unique_description' => __(
                        "With the plugin active, users can't access these pages. However, these attachments may accidentally reserve slugs from your pages. It's recommended to run the mangle attachments tool to prevent any potential issues in the future.",
                        'disable-media-pages'
                    ),
                    'status_no_issues_title' => __("No issues found", 'disable-media-pages'),
                    'status_no_issues_description' => __(
                        "All attachments have unique slugs. There's not risk of attachments accidentally reserving slugs from your pages.",
                        'disable-media-pages'
                    ),
                    'status_open_tool_button' => __("Open Tool", 'disable-media-pages'),
                ],
            ]
        );

        wp_enqueue_style(
            'dmp-style',
            "{$url}dist/style.css",
            [],
            WP_DEBUG ? md5_file($path . 'dist/style.css') : $version
        );
    }

    public function plugin_action_links($links)
    {
        $settings_link =
            '<a href="options-general.php?page=disable-media-pages">' .
            __('Settings', 'disable-media-pages') .
            '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    public function donate_link($links, $file) {
        if ($file === plugin_basename($this->plugin_file)) {
            array_push(
                $links,
                '<a href="https://github.com/sponsors/joppuyo">' .
                esc_html__(
                    'Support development on GitHub Sponsors',
                    'disable-media-pages'
                ) .
                '</a>'
            );
        }
        return $links;
    }
}