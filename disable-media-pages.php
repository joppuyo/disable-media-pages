<?php

/*
 * Plugin name: Disable Media Pages
 * Description: Plugin to disable "attachment" pages for WordPress media.
 * Author: Johannes Siipola
 * Author URI: https://siipo.la
 * Version: 3.1.3
 * License: GPL v2 or later
 * Text Domain: disable-media-pages
 */

require __DIR__ . '/vendor/autoload.php';

// Load c3 in CI environment for code coverage
if (file_exists(__DIR__ . '/c3.php')) {
    require_once __DIR__ . '/c3.php';
}

\NPX\DisableMediaPages\Plugin::get_instance();

