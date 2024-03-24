<?php

namespace NPX\DisableMediaPages\Modules;

use NPX\DisableMediaPages\Plugin;
use WP_Query;
use WP_REST_Request;
use WP_REST_Response;

class REST
{
    private static $instance = null;
    public $plugin_file = null;

    public static function get_instance(): REST
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function __construct()
    {
        add_filter('init', [$this, 'init']);
    }

    public function init()
    {
        add_action('rest_api_init', [$this, 'rest_api_init']);
    }

    public function rest_api_init()
    {
        // Status
        register_rest_route(
            'disable-media-pages/v1',
            '/get_status',
            [
                'methods' => 'GET',
                'callback' => [$this, 'rest_api_get_status'],
                'permission_callback' => function () {
                    return current_user_can('manage_options');
                },
            ]
        );

        // Mangle
        register_rest_route(
            'disable-media-pages/v1',
            '/get_all_attachments',
            [
                'methods' => 'GET',
                'callback' => [$this, 'rest_api_get_all_attachments'],
                'permission_callback' => function () {
                    return current_user_can('manage_options');
                },
            ]
        );
        register_rest_route(
            'disable-media-pages/v1',
            '/process/(?P<id>\d+)',
            [
                'methods' => 'POST',
                'callback' => [$this, 'rest_api_process_attachment'],
                'args' => [
                    'id' => [
                        'validate_callback' => function ($param) {
                            return is_numeric($param);
                        },
                    ],
                ],
                'permission_callback' => function () {
                    return current_user_can('manage_options');
                },
            ]
        );

        // Restore
        register_rest_route(
            'disable-media-pages/v1',
            '/get-attachments-to-restore',
            [
                'methods' => 'GET',
                'callback' => [$this, 'rest_api_get_attachments_to_restore'],
                'permission_callback' => function () {
                    return current_user_can('manage_options');
                },
            ]
        );

        register_rest_route(
            'disable-media-pages/v1',
            '/restore/(?P<id>\d+)',
            [
                'methods' => 'POST',
                'callback' => [$this, 'rest_api_restore_attachment'],
                'args' => [
                    'id' => [
                        'validate_callback' => function ($param) {
                            return is_numeric($param);
                        },
                    ],
                ],
                'permission_callback' => function () {
                    return current_user_can('manage_options');
                },
            ]
        );
    }

    public function rest_api_get_status(WP_REST_Request $data)
    {
        global $wpdb;

        $result = $wpdb->get_var(
            "SELECT COUNT(ID) FROM  $wpdb->posts WHERE post_type = 'attachment' AND post_name NOT RLIKE '^[a-f0-9]{8}-?[a-f0-9]{4}-?4[a-f0-9]{3}-?[89ab][a-f0-9]{3}-?[a-f0-9]{12}$'"
        );

        $json = [
            'non_unique_count' => (int)$result,
        ];

        return new WP_REST_Response($json);
    }

    public function rest_api_get_all_attachments(WP_REST_Request $data)
    {

        $mangle = Mangle::get_instance();

        $result = $mangle->get_attachments_to_mangle();

        $json = [
            'posts' => $result,
            'total' => count($result),
            'result' => $result,
        ];

        return new WP_REST_Response($json);
    }

    public function rest_api_process_attachment(WP_REST_Request $data)
    {
        $mangle = Mangle::get_instance();

        $post_id = $data->get_param('id');

        $mangle->mangle_attachment($post_id);

        return new WP_REST_Response([]);
    }

    public function rest_api_get_attachments_to_restore(WP_REST_Request $data)
    {
        $restore = Restore::get_instance();

        $result = $restore->get_attachments_to_restore();

        $json = [
            'posts' => $result,
            'total' => count($result),
            'result' => $result,
        ];

        return new WP_REST_Response($json);
    }

    public function rest_api_restore_attachment(WP_REST_Request $data)
    {
        $post_id = $data->get_param('id');

        $restore = Restore::get_instance();

        $restore->restore_attachment($post_id);

        return new WP_REST_Response([]);
    }
}