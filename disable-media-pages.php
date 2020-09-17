<?php

/*
 * Plugin name: Disable Media Pages
 */

add_filter('wp_unique_post_slug', function ($slug, $post_ID, $post_status, $post_type, $post_parent, $original_slug) {
    if ($post_type === 'attachment') {
        return str_replace('-', '', wp_generate_uuid4());
    }
    return $slug;
}, 10, 6);

add_filter('template_redirect', 'set_404');
add_filter('redirect_canonical', 'set_404', 0);
add_filter('attachment_link', 'change_attachment_link', 10, 2);

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