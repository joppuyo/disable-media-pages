<?php

namespace NPX\DisableMediaPages;

use NPX\DisableMediaPages\Modules\Admin;
use NPX\DisableMediaPages\Modules\CLI;
use NPX\DisableMediaPages\Modules\REST;
use WP_Query;
use WP_REST_Request;
use WP_REST_Response;

class Plugin
{
    private static $instance = null;
    public $plugin_file = null;

    public static function get_instance(): Plugin
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function init()
    {
        add_filter('wp_unique_post_slug', [$this, 'unique_slug'], 10, 6);
        add_filter('template_redirect', [$this, 'set_404']);
        add_filter('redirect_canonical', [$this, 'redirect_canonical'], 0, 2);
        add_filter('attachment_link', [$this, 'change_attachment_link'], 10, 2);
    }

    public function __construct()
    {
        add_filter('init', [$this, 'init']);
        REST::get_instance();
        Admin::get_instance();
        CLI::get_instance();
    }

    public static function debug(...$messages)
    {
        if (defined('WP_DEBUG') && WP_DEBUG === true) {
            error_log(print_r($messages, true));
        }
    }

    function set_404()
    {
        if (is_attachment()) {
            global $wp_query;
            $wp_query->set_404();
            status_header(404);
        }
    }

    function redirect_canonical($redirect_url, $requested_url)
    {
        if (is_attachment()) {
            global $wp_query;
            $wp_query->set_404();
            status_header(404);

            // Handle WordPress 6.4's attachment page redirection by cancelling the redirection.
            // https://make.wordpress.org/core/2023/10/16/changes-to-attachment-pages/
            global $wp_version;
            if (version_compare($wp_version, '6.4', '>=')) {
                return false;
            }

        }
        return $redirect_url;
    }

    function change_attachment_link($url, $id)
    {
        $attachment_url = wp_get_attachment_url($id);
        if ($attachment_url) {
            return $attachment_url;
        }
        return $url;
    }

    function unique_slug($slug, $post_ID, $post_status, $post_type, $post_parent, $original_slug)
    {
        if ($post_type === 'attachment' && !self::is_uuid($slug)) {
            return $this->generate_uuid_v4();
        }
        return $slug;
    }

    /**
     * @return string|string[]
     */
    public function generate_uuid_v4()
    {
        return str_replace('-', '', $this->wp_generate_uuid4_improved());
    }

    /**
     * Generate UUIDv4 with improved randomness. The built-in WordPress function starts to generate duplicate UUIDs
     * After 80 000 iterations. This function uses random_int() instead of mt_rand() to generate the UUID.
     * @see https://core.trac.wordpress.org/ticket/59239
     * @return string
     */
    public function wp_generate_uuid4_improved()
    {
        try {
            return sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                random_int(0, 0xffff),
                random_int(0, 0xffff),
                random_int(0, 0xffff),
                random_int(0, 0x0fff) | 0x4000,
                random_int(0, 0x3fff) | 0x8000,
                random_int(0, 0xffff),
                random_int(0, 0xffff),
                random_int(0, 0xffff)
            );
        } catch (\Exception $exception) {
            // If for some reason random_int() fails (eg. a source of randomness is not available), fall back to the
            // built-in WordPress function.
            return wp_generate_uuid4();
        }
    }

    /**
     * @param string $slug
     * @return bool
     */
    public static function is_uuid(string $slug): bool
    {
        $is_uuid = (bool)preg_match(
            '/^[0-9a-f]{8}[0-9a-f]{4}4[0-9a-f]{3}[89ab][0-9a-f]{3}[0-9a-f]{12}$/',
            $slug
        );
        return $is_uuid;
    }
}
