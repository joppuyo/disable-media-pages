<?php

/*
 * Plugin name: Disable Media Pages
 * Description: Plugin to disable "attachment" pages for WordPress media.
 * Author: Johannes Siipola
 * Author URI: https://siipo.la
 * Version: 4.0.3
 * License: GPL v2 or later
 * Text Domain: disable-media-pages
 */

require __DIR__ . '/vendor/autoload.php';

// Load c3 in CI environment for code coverage. Codeception requests this file directly to collect the coverage
// report, so this has to run before the ABSPATH check below.
if (file_exists(__DIR__ . '/c3.php')) {
    require_once __DIR__ . '/c3.php';
}

// Prevent direct access to this file outside of WordPress.
if (!defined('ABSPATH')) {
    exit;
}

\NPX\DisableMediaPages\Plugin::get_instance();

