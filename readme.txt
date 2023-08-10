# Disable Media Pages

Tags: remove, disable, hide, media, attachment, image, permalink
Contributors: joppuyo
Requires at least: 5.2
Tested up to: 6.3
Requires PHP: 7.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://github.com/sponsors/joppuyo
Stable tag: 3.0.2

Completely remove "attachment" pages for WordPress media. Improve SEO and prevent conflicts between page and image permalinks.

## Description

Completely disable "attachment" pages created by WordPress.

By default, WordPress creates a page for each of your attachments. This is can be undesirable because of two reasons:

### Search engine optimization

Attachment pages don't have any content, except an image, so they provide little value and can negatively affect your SEO because they are so-called [thin content](https://developers.google.com/search/docs/advanced/guidelines/thin-content). Even worse, attachment pages may in some cases rank higher than your actual content pages which leads to a poor user experience.

### Reserved slugs

Attachment pages can accidentally reserve slugs on your site. Let's say you upload an image named **contact.jpeg**, an attachment page `https://example.com/contact` is automatically created. If you then try to create a page named **Contact**, the URL for that page will be `https://example.com/contact-2` which isn't that great.

### How it works

This plugin works by automatically setting all attachment slugs to an unique id, so they won't conflict with your pages. If an attachment page is accessed, the plugin will set a 404 status code and display the "page not found" template.

You can also mangle any existing attachment slugs so they won't cause any issues in the future.

### Thanks

Special thanks to Greg Schoppe for [his research](https://gschoppe.com/wordpress/disable-attachment-pages/) and inspiration that helped a lot with developing this plugin.

## Support the plugin

Maintaining a WordPress plugin is a lot of work. If you like the plugin, please consider rating it on [WordPress.org](https://wordpress.org/support/plugin/disable-media-pages/reviews/#new-post). You can also support me on [GitHub sponsors](https://github.com/sponsors/joppuyo). Thank you!

If you are interested, you can also check out my other WordPress plugins:

* [Disable Customizer](https://wordpress.org/plugins/customizer-disabler/)
* [Disable Drop Cap](https://wordpress.org/plugins/disable-drop-cap/)
* [ACF Image Aspect Ratio Crop](https://wordpress.org/plugins/acf-image-aspect-ratio-crop/)

## Installation

1. Install the plugin from your WordPress dashboard
2. Activate the Disable Media Pages plugin via the plugins admin page
3. From now on, media pages will be disabled and new media items uploaded in the library will get unique id slugs

## Frequently Asked Questions

### How to mangle existing attachment slugs?

Go to the **Settings** ▸ **Disable Media Pages** ▸ **Mangle existing slugs**. This will show you a wizard to mangle existing attachment slugs.

### Why not just use Yoast SEO? It has a feature to redirect attachment pages to parent

First of all, not everyone uses Yoast SEO. More importantly, while Yoast SEO can fix the duplicate content issue, it does not help with issue of media files reserving slugs for pages.

### What if I want to redirect attachment pages to parent page instead?

Instead of displaying a 404 HTTP error, some people recommend you to redirect attachment pages to the parent page instead. I think this can be a good short-term solution if the attachment pages have been indexed by Google and you want to preserve SEO ranking for these URLs. There's a plenty of plugins on the plugin directory that let you to do that. In my opinion returning the 404 error is the correct long-term solution and if you are launching a new site, it's best to simply disable these pages so they won't ever end up in Google index.

### What kind of unique id is used?

The unique id is an UUIDv4, without dashes.

### Can I restore the attachment page slugs after mangling?

Yes, this functionality is available in version 1.1.0. The attachment slug restoration tool allows you to restore the attachment slugs back to ones based on the attachment title.

### Can I find this plugin on GitHub?

Yes, check out the [GitHub repository.](https://github.com/joppuyo/disable-media-pages)

## Changelog

### 3.0.2 (2023‐08‐10)
* Fix: Tested in WP 6.3

### 3.0.1 (2023-06-15)
* Fix: Fix typo

### 3.0.0 (2023-06-15)
* Fix: Tested in WordPress 6.2
* Breaking change: Dropped support for WordPress 5.0, WordPress 5.1, and PHP 7.0. The Debian version in the Docker images is so old it no longer works properly and crashes the build. This makes it very difficult to run tests. New minimum PHP version is 7.1 and minimum WordPress version is 5.2.

### 2.0.3 (2022-12-11)
* Fix: Fix typo. Thanks to [porg](https://github.com/joppuyo/disable-media-pages/issues/34) for noticing this!

### 2.0.2 (2022-10-31)
* Fix: Test in WP 6.1

### 2.0.1 (2022-07-26)
* Fix: small update to readme

### 2.0.0 (2022-07-25)
* Breaking change: fixed how the plugin hooks into the `redirect_canonical` action. Because the plugin didn't return a value from this filter, this caused the plugin to change default WordPress behaviour (eg. https://example.com/index.php did not redirect to https://example.com/ like with a normal WordPress installation). In this version the filter returns the value which restores this WordPress default functionality. I'm making this a major release because it changes the plugin behaviour, so I recommend testing your site in a development or staging environment before updating your production site. For more information, see [this support thread](https://wordpress.org/support/topic/index-php-bug-breaks-wp-rocket/).

### 1.3.0 (2022-06-03)
* Feature: Improved slug generation logic. Now the plugin checks the slug is in UUIDv4 format before generating a new slug. This prevents slugs from changing when saving a post.

### 1.2.3 (2022-05-25)
* Fix: Test in WP 6.0

### 1.2.2 (2022-02-05)
* Fix: Add missing localization string
* Fix: Minor readme updates
* Fix: Optimize acceptance test database size

### 1.2.1 (2022-01-28)
* Fix: Fix typo

### 1.2.0 (2022-01-28)
* Feature: Improved plugin code structure
* Feature: Add donate link
* Fix: Readme update
* Fix: Fix issue where the plugin was unable to mangle slugs that contained UUID along with some other text

### 1.1.3 (2022-01-28)
* Fix: Bump supported WordPress version to 5.9
* Fix: Readme updates
* Fix: Add automated test for slug restore functionality

### 1.1.2 (2022-01-19)
* Fix: Remove debugging statements
* Fix: Fix typo in readme

### 1.1.1 (2022-01-06)
* Fix: Minor fix to the icon

### 1.1.0 (2022-01-06)
* Feature: Add a tool for restoring media slugs back to the original ones
* Feature: Add status page for the plugin which tells you if you have attachments without unique ids
* Fix: Add menu for the plugin under Settings on the WordPress dashboard
* Fix: Update plugin icon

### 1.0.8 (2021-07-24)
* Fix: Bump supported WordPress version to 5.8
* Fix: Update dependencies

### 1.0.7 (2021-06-14)
* Fix: Update dependencies
* Fix: Update FAQ
* Fix: Tweak icon

### 1.0.6 (2021-06-09)
* Fix: Fix issue with deployment

### 1.0.5 (2021-06-09)
* Fix: Bump tested up to @ 5.7
* Fix: Add acceptance tests

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
