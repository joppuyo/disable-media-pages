# Disable Media Pages

[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/joppuyo/disable-media-pages/Build?logo=github)](https://github.com/joppuyo/disable-media-pages/actions?query=workflow%3ABuild)
[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/joppuyo/disable-media-pages/Test?label=tests&logo=github)](https://github.com/joppuyo/disable-media-pages/actions?query=workflow%3ATest)
[![WordPress Plugin Version](https://img.shields.io/wordpress/plugin/v/disable-media-pages?logo=wordpress)](https://wordpress.org/plugins/disable-media-pages/)

Disable "attachment" pages for WordPress media.

By default WordPress creates a page for each of your attachments. This is can be undesirable because:

1. These are pages that don't have any content, except an image, so they provide little value and can negatively affect your SEO.
2. They can accidentally reserve slugs on your site. Let's say you upload an image named `contact.jpeg`, an attachment page `https://example.com/contact` is automatically created. If you then try to create a page named **Contact**, the URL for that page will be `https://example.com/contact-2` which isn't that great.

## How it works

This plugin works by automatically setting all attachment slugs to an unique id, so they won't conflict with your pages. If an attachment page is accessed, the plugin will set a 404 status code and display the "page not found" template.

You can also mangle any existing attachment slugs so they won't cause any issues in the future.

## Requirements

* WordPress 5.0 or later
* PHP 7.0 or later

## Installation

* Download latest version on [wordpress.org](https://wordpress.org/plugins/disable-media-pages/)
* Upload the zip through the WordPress admin panel or unzip it and copy it into your wp-content/plugins directory
* Activate the plugin on your plugins page in the WordPress admin panel
