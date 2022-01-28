<?php

namespace NPX\DisableMediaPages;

use NPX\DisableMediaPages\Modules\Admin;
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
        add_filter('redirect_canonical', [$this, 'set_404'], 0);
        add_filter('attachment_link', [$this, 'change_attachment_link'], 10, 2);
    }

    public function __construct()
    {
        add_filter('init', [$this, 'init']);
        REST::get_instance();
        Admin::get_instance();
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
        if ($post_type === 'attachment') {
            return $this->generate_uuid_v4();
        }
        return $slug;
    }

    /**
     * @return string|string[]
     */
    public function generate_uuid_v4()
    {
        return str_replace('-', '', wp_generate_uuid4());
    }
}
