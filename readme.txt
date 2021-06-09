# Disable Media Pages

Tags: remove, disable, media, attachment, image, permalink
Contributors: joppuyo
Requires at least: 5.0
Tested up to: 5.6
Requires PHP: 7.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://github.com/sponsors/joppuyo
Stable tag: 1.0.4

Disable "attachment" pages for WordPress media.

## Description

Disable "attachment" pages for WordPress media.

By default WordPress creates a page for each of your attachments. This is can be undesirable because:

1. These are pages that don't have any content, except an image, so they provide little value and can negatively affect your SEO.
2. They can accidentally reserve slugs on your site. Let's say you upload an image named `contact.jpeg`, an attachment page `https://example.com/contact` is automatically created. If you then try to create a page named **Contact**, the URL for that page will be `https://example.com/contact-2` which isn't that great.

### How it works

This plugin works by automatically setting all attachment slugs to an unique id, so they won't conflict with your pages. If an attachment page is accessed, the plugin will set a 404 status code and display the "page not found" template.

You can also mangle any existing attachment slugs so they won't cause any issues in the future.

## Installation

1. Install the plugin from your WordPress dashboard
2. Activate the Disable Media Pages plugin via the plugins admin page
3. From now on, media pages will be disabled and new media items uploaded in the library will get unique id slugs

## Frequently Asked Questions

### How to mangle existing attachment slugs?

Go to the plugins page, scroll to "Disable Media Pages", click "Settings". This will show you a wizard to mangle existing attachment slugs.

### Why not just use Yoast SEO? It has a feature to redirect attachment pages to parent

First of all, not everyone uses Yoast SEO. More importantly, while Yoast SEO can fix the duplicate content issue, it does not help with issue of media files reserving slugs for pages.

### What kind of unique id is used?

The unique id is an UUIDv4, without dashes.

### Can I restore the attachment page slugs after mangling?

Not right now, but this feature is planned in a future version of the plugin.

## Changelog

### 1.0.4 (2021-01-02)
* Change: Add icon

### 1.0.3 (2020-12-31)
* Fix: Change required WordPress version correctly to 5.0
* Fix: Optimize autoloader

### 1.0.2 (2020-12-31)
* Change: Release on WordPress plugin directory
* Change: Changes to internal plugin structure
* Fix: Make plugin translatable
* Fix: Load JavaScript and CSS only on plugin page

### 1.0.1 (2020-12-19)
* Fix: WordPress 5.6 compatibility, thanks [@tnottu](https://github.com/tnottu)

### 1.0.0 (2020-09-26)
* Initial release
