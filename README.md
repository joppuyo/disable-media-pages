# Disable Media Pages

[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/joppuyo/disable-media-pages/Build?logo=github)](https://github.com/joppuyo/disable-media-pages/actions?query=workflow%3ABuild)
[![GitHub release (latest by date)](https://img.shields.io/github/v/release/joppuyo/disable-media-pages)](https://github.com/joppuyo/disable-media-pages/releases)

Disable "attachment" pages for WordPress media.

By default WordPress creates a page for each of your attachments. This is bad because:

1. These are pages that don't have any content, except an image, so they provide little value and can negatively affect your SEO.
2. They can accidentally reserve slugs on your site. Let's say you upload an image named `contact.jpeg`, a page like `https://example.com/contact` is automatically created. If you then try to create a page named Contact, the URL will be `https://example.com/contact-2` which isn't that great.

## How it works

This plugin works by automatically setting all attachment slugs to an unique id, so they won't conflict with your pages. The plugin will also set 404 status code if a media page is accessed.

You can also mangle any existing attachment slugs so they won't cause any issues in the future.

## Requirements

* WordPress 5.0 or later
* PHP 7.0 or later

## Installation

* Download latest version from the [GitHub releases](https://github.com/joppuyo/disable-media-pages/releases)
* Unzip the plugin into your wp-content/plugins directory or upload it through the WordPress admin panel
* Activate the plugin on your Plugins page
