<?php

/*
 * Plugin name: Disable Media Pages
 * Description: Plugin to disable "attachment" pages for WordPress media.
 * Author: Johannes Siipola
 * Author URI: https://siipo.la
 * Version: 1.0.7
 * License: GPL v2 or later
 * Text Domain: disable-media-pages
 */

require __DIR__ . '/vendor/autoload.php';

$npx_disable_media_pages = \NPX\DisableMediaPages::get_instance();
$npx_disable_media_pages->plugin_file = __FILE__;
